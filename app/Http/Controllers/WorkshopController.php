<?php
namespace App\Http\Controllers;

use App\Models\WorkshopProvider;
use App\Models\WorkshopCategory;
use App\Models\CarBrand;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use DB;

class WorkshopController extends Controller
{
  public function index(Request $request)
{
    $currentUrl = url()->current();
    
    // Fetch distinct values for filters
    $cities = WorkshopProvider::select('branch')->distinct()->orderBy('branch')->pluck('branch');
    $brands = DB::table('car_brand_workshop_provider')->distinct()->pluck('car_brand_id')->toArray();
    $brands = CarBrand::select('id', 'name')->whereIn('id', $brands)->distinct()->pluck('name', 'id')->toArray();
    $categories = DB::table('workshop_category_provider')->distinct()->pluck('workshop_category_id')->toArray();
    $categories = WorkshopCategory::select('id', 'name')->whereIn('id', $categories)->distinct()->pluck('name')->toArray();
    
    // Start the base query
    $query = WorkshopProvider::query();
    $query->inRandomOrder();
    
    // Apply filters
    if ($request->city) {
        $query->where('branch', $request->city);
    }
    
    if ($request->brand_id) {
        $brand = CarBrand::find($request->brand_id);
        $workshop_ids = $brand->providers()->pluck('workshop_provider_id')->toArray();
        $query->whereIn('id', $workshop_ids);
    }
    
    if ($request->category_id) {
        $category = WorkshopCategory::find($request->category_id);
        $workshop_ids = $category->providers()->pluck('workshop_provider_id')->toArray();
        $query->whereIn('id', $workshop_ids);
    }

    // Additional filter support for search functionality
    if ($request->search) {
        $searchTerm = $request->search;
        $query->where(function ($q) use ($searchTerm) {
            $q->where('workshop_name', 'like', '%' . $searchTerm . '%')
              ->orWhere('description', 'like', '%' . $searchTerm . '%')
              ->orWhere('branch', 'like', '%' . $searchTerm . '%')
              ->orWhere('area', 'like', '%' . $searchTerm . '%');
        });
    }

    // Apply area filter
    if ($request->area) {
        $query->where('area', $request->area);
    }

    // Apply rating filter
    if ($request->rating) {
        $query->where('rating', '>=', $request->rating);
    }

    // Apply sorting
    $sortBy = $request->input('sortBy', 'random');
    switch ($sortBy) {
        case 'rating_high':
            $query->orderBy('rating', 'desc');
            break;
        case 'rating_low':
            $query->orderBy('rating', 'asc');
            break;
        case 'name_asc':
            $query->orderBy('workshop_name', 'asc');
            break;
        case 'name_desc':
            $query->orderBy('workshop_name', 'desc');
            break;
        case 'latest':
            $query->latest();
            break;
        case 'oldest':
            $query->orderBy('created_at', 'asc');
            break;
        default:
            $query->inRandomOrder();
            break;
    }
    
    // ✅ Get all results (no pagination)
    $workshops = $query->get();
    
    // Return view
    return view('workshops.index', compact('cities', 'workshops', 'brands', 'categories'));
}


    public function show(WorkshopProvider $workshop)
    {
        // Fetch distinct values for filters
        $cities = WorkshopProvider::select('branch')->distinct()->orderBy('branch')->pluck('branch');
        $brands   = DB::table('car_brand_workshop_provider')->distinct()->pluck('car_brand_id')->toArray();
        $brands = CarBrand::select('id', 'name')->whereIn('id', $brands)->distinct()->pluck('name', 'id')->toArray();
        $categories = DB::table('workshop_category_provider')->distinct()->pluck('workshop_category_id')->toArray();
        $categories = WorkshopCategory::select('id', 'name')->whereIn('id', $categories)->distinct()->pluck('name')->toArray();

        // Get related workshops in the same city/area
        $relatedWorkshops = WorkshopProvider::where('id', '!=', $workshop->id)
            ->where('branch', $workshop->branch)
            ->take(6)
            ->get();

        return view('workshops.show', compact('cities', 'workshop', 'brands', 'categories', 'relatedWorkshops'));
    }

    /**
     * Handle workshop requests with query parameters and redirect to proper route
     * This method handles URLs like: /workshops?id=43
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function showFromQuery(Request $request)
    {
        // Check if there's an ID parameter for direct workshop view
        $id = $request->query('id');
        if ($id && is_numeric($id)) {
            // Redirect to the proper deep link route
            return redirect()->route('workshops.show', ['workshop' => $id]);
        }

        // If has filter parameters, show filtered results
        if ($request->hasAny(['search', 'city', 'brand_id', 'category_id', 'area', 'rating', 'sortBy'])) {
            return $this->index($request);
        }

        // If no parameters, redirect to workshops listing page
        return redirect()->route('workshops.index');
    }

    /**
     * ✅ Deep Linking Workshops (Legacy method - keeping for compatibility)
     */
    public function deepLinkDetail(Request $request)
    {
        $id = $request->query('id');
        if (!$id || !is_numeric($id)) {
            abort(404); // or redirect to workshops index
        }
        return redirect()->route('workshops.show', ['workshop' => $id]);
    }

    /**
     * Create a new workshop
     */
    public function create()
    {
        $categories = WorkshopCategory::orderBy('name')->get();
        $brands = CarBrand::orderBy('name')->get();
        $cities = WorkshopProvider::select('branch')->distinct()->orderBy('branch')->pluck('branch');
        
        return view('workshops.create', compact('categories', 'brands', 'cities'));
    }

    /**
     * Store a newly created workshop
     */
    public function store(Request $request)
    {
        $request->validate([
            'workshop_name' => 'required|string|max:255',
            'description' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:500',
            'branch' => 'required|string|max:100',
            'area' => 'required|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'website' => 'nullable|url|max:255',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:workshop_categories,id',
            'brands' => 'required|array|min:1', 
            'brands.*' => 'exists:car_brands,id',
        ]);

        $workshop = WorkshopProvider::create($request->except(['categories', 'brands']));

        // Attach categories
        $workshop->categories()->sync($request->categories);

        // Attach brands
        $workshop->brands()->sync($request->brands);

        return redirect()->route('workshops.show', $workshop->id)
            ->with('success', 'Workshop created successfully.');
    }

    /**
     * Edit workshop
     */
    public function edit(WorkshopProvider $workshop)
    {
        $categories = WorkshopCategory::orderBy('name')->get();
        $brands = CarBrand::orderBy('name')->get();
        $cities = WorkshopProvider::select('branch')->distinct()->orderBy('branch')->pluck('branch');
        
        return view('workshops.edit', compact('workshop', 'categories', 'brands', 'cities'));
    }

    /**
     * Update workshop
     */
    public function update(Request $request, WorkshopProvider $workshop)
    {
        $request->validate([
            'workshop_name' => 'required|string|max:255',
            'description' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:500',
            'branch' => 'required|string|max:100',
            'area' => 'required|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'website' => 'nullable|url|max:255',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:workshop_categories,id',
            'brands' => 'required|array|min:1', 
            'brands.*' => 'exists:car_brands,id',
        ]);

        $workshop->update($request->except(['categories', 'brands']));

        // Sync categories
        $workshop->categories()->sync($request->categories);

        // Sync brands
        $workshop->brands()->sync($request->brands);

        return redirect()->route('workshops.show', $workshop->id)
            ->with('success', 'Workshop updated successfully.');
    }

    /**
     * Delete workshop
     */
    public function destroy(WorkshopProvider $workshop)
    {
        $workshop->delete();

        return redirect()->route('workshops.index')
            ->with('success', 'Workshop deleted successfully.');
    }

    /**
     * Search workshops
     */
    public function search(Request $request)
    {
        $searchTerm = $request->input('q');
        
        $workshops = WorkshopProvider::where(function ($query) use ($searchTerm) {
                $query->where('workshop_name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('description', 'like', '%' . $searchTerm . '%')
                      ->orWhere('branch', 'like', '%' . $searchTerm . '%')
                      ->orWhere('area', 'like', '%' . $searchTerm . '%');
            })
            ->latest()
            ->paginate(12);

        return view('workshops.search', compact('workshops', 'searchTerm'));
    }

    /**
     * Get workshops for home section
     */
    public function homeSection()
    {
        $workshops = WorkshopProvider::where('rating', '>=', 4)
            ->latest()
            ->take(8)
            ->get();

        return response()->json($workshops);
    }

    /**
     * Add review to workshop
     */
    public function addReview(Request $request, WorkshopProvider $workshop)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Check if user already reviewed this workshop
        $existingReview = $workshop->reviews()
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this workshop.');
        }

        $workshop->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Update workshop average rating
        $averageRating = $workshop->reviews()->avg('rating');
        $workshop->update(['rating' => round($averageRating, 1)]);

        return back()->with('success', 'Review added successfully.');
    }

    /**
     * Toggle workshop favorite
     */
    public function toggleFavorite(WorkshopProvider $workshop)
    {
        $user = auth()->user();

        if ($user->favoriteWorkshops()->where('workshop_provider_id', $workshop->id)->exists()) {
            $user->favoriteWorkshops()->detach($workshop->id);
            $message = 'Workshop removed from favorites.';
        } else {
            $user->favoriteWorkshops()->attach($workshop->id);
            $message = 'Workshop added to favorites.';
        }

        return response()->json(['message' => $message]);
    }

    /**
     * Get user's favorite workshops
     */
    public function favorites()
    {
        $workshops = auth()->user()
            ->favoriteWorkshops()
            ->latest('pivot_created_at')
            ->paginate(12);

        return view('workshops.favorites', compact('workshops'));
    }

    /**
     * Filter workshops based on multiple criteria
     */
    public function filter(Request $request)
    {
        // This method can be used for AJAX filtering if needed
        return $this->index($request);
    }
}