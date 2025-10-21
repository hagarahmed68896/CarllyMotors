<?php
namespace App\Http\Controllers;

use App\Models\CarBrand;
use App\Models\CarDealer;
use App\Models\SparePart;
use App\Models\SparepartCategory;
use Illuminate\Http\Request;

class SparePartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    // لجلب بيانات القوائم المستخدمة في الفيلتر (من جدول spare_parts)
    $makes = SparePart::select('brand')->distinct()->orderBy('brand')->pluck('brand');
    $models = SparePart::select('model')->distinct()->orderBy('model')->pluck('model');
    $conditions = SparePart::select('part_type')->distinct()->orderBy('part_type')->pluck('part_type');
    $cities = SparePart::select('city')->distinct()->orderBy('city')->pluck('city');

    $category_ids = SparePart::distinct()->pluck('category_id')->toArray();
//  $categories = SparepartCategory::whereIn('id', $category_ids)
//                 ->distinct()
//                 ->get(['id', 'name', 'image']);
$categories = SparepartCategory::orderBy('name')->get();


    $years = SparePart::select('year')
        ->distinct()
        ->pluck('year')
        ->filter(fn($y) => is_numeric($y))
        ->map(fn($y) => (int) $y)
        ->unique()
        ->sort()
        ->values()
        ->toArray();

    // بناء استعلام الديلرز (نبدأ من CarDealer)
    $dealersQuery = CarDealer::query()->withCount('spareParts');

    // بحث نصي عام على الديلر (company_name / company_address)
    if ($request->filled('q')) {
        $keyword = $request->q;
        $dealersQuery->where(function($q) use ($keyword) {
            $q->where('company_name', 'like', "%{$keyword}%")
              ->orWhere('company_address', 'like', "%{$keyword}%");
        });
    }

    // الآن نطبّق فلاتر مبنية على خصائص spare_parts باستخدام whereHas
    // make -> brand
    if ($request->filled('make')) {
        $dealersQuery->whereHas('spareParts', function($q) use ($request) {
            $q->where('brand', $request->make);
        });
    }

    // model
    if ($request->filled('model')) {
        $dealersQuery->whereHas('spareParts', function($q) use ($request) {
            $q->where('model', $request->model);
        });
    }

    // city
    if ($request->filled('city')) {
        $dealersQuery->whereHas('spareParts', function($q) use ($request) {
            $q->where('city', $request->city);
        });
    }

    // condition -> part_type
    if ($request->filled('condition')) {
        $dealersQuery->whereHas('spareParts', function($q) use ($request) {
            $q->where('part_type', $request->condition);
        });
    }

    // vin_number (بحث جزئي)
    if ($request->filled('vin_number')) {
        $dealersQuery->whereHas('spareParts', function($q) use ($request) {
            $q->where('vin_number', 'like', '%'.$request->vin_number.'%');
        });
    }

    // category (نبحث عن أجزاء لها category.name = القيمة)
    if ($request->filled('category')) {
        $dealersQuery->whereHas('spareParts.category', function($q) use ($request) {
            $q->where('name', $request->category);
        });
    }

    // إذا بعت dealer_id مباشرة (مثلاً من رابط)
    if ($request->filled('dealer_id')) {
        $dealersQuery->where('id', $request->dealer_id);
    }

    // ترتيب، pagination، وإعادة البيانات للفيو
    $dealers = $dealersQuery->orderBy('id','desc')->paginate(12)->withQueryString();

    return view('spareparts.index', compact(
        'dealers', 'cities', 'makes', 'models', 'years', 'categories', 'conditions'
    ));
}





public function getModels(Request $request)
{
    $brand = $request->get('brand');

    $models = SparePart::where('brand', $brand)
        ->select('model')
        ->distinct()
        ->orderBy('model')
        ->pluck('model')
        ->filter()
        ->values();

    return response()->json($models);
}



    public function homeSection(Request $request)
    {
        // dd($request);
        // Fetch brands that have more than 2 cars
        $brands = CarBrand::withCount('cars')
            ->having('cars_count', '>', 2)
            ->orderBy('name')
            ->get(['id', 'name']);

        $spareParts = SparePart::query();

        $cities       = SparePart::distinct()->pluck('city')->toArray();
        $makes        = SparePart::distinct()->pluck('part_type')->toArray();
        $models       = SparePart::distinct()->pluck('model')->toArray();
        $years        = SparePart::distinct()->pluck('year')->toArray();
        $category_ids = SparePart::distinct()->pluck('category_id')->toArray();
        $categories   = SparepartCategory::select('id', 'name')->whereIn('id', $category_ids)->distinct()->pluck('name')->toArray();
        $prices       = SparePart::distinct()->pluck('price')->toArray();

        // city=&make=&model=&year=2020&body_type=&price=
        if ($request->city) {
            $spareParts->where('city', $request->city);
        }

        if ($request->make) {
            $spareParts->where('part_type', $request->make);
        }

        if ($request->model) {
            $spareParts->where('model', $request->model);
        }

        if ($request->year) {
            $spareParts->where('year', $request->year);
        }
        if ($request->brand) {
            $spareParts->where('brand', $request->brand);
        }

        if ($request->category) {
            $category = SparepartCategory::select('id')->where('name', $request->category)->first();
            $spareParts->where('category_id', $category->id);
        }

        if ($request->price) {
            $spareParts->where('price', $request->price);
        }

        $spareParts = $spareParts->orderBy('id', 'DESC')->take(8)->get();
        // Return view with grouped data and other filter data
        return view('spareparts.homeSection', compact('spareParts', 'cities', 'makes', 'models', 'years', 'categories', 'prices', 'brands'));
    }

    public function show(SparePart $sparePart)
    {
        //
        $images = $sparePart->images->pluck('image')->toArray();
        return view('spareParts.show', compact('sparePart', 'images'));
    }

    public function filter(Request $request)
    {
        // Fetch distinct values for filters
        $makes      = SparePart::select('brand')->distinct()->orderBy('brand')->pluck('brand');
        $models     = SparePart::select('model')->distinct()->orderBy('model')->pluck('model');
        $conditions = SparePart::select('part_type')->distinct()->orderBy('part_type')->pluck('part_type');
        $cities = SparePart::select('city')->distinct()->orderBy('city')->pluck('city');

        $category_ids = SparePart::distinct()->pluck('category_id')->toArray();
        $categories   = SparepartCategory::where('parent_id', null)->whereIn('id', $category_ids)->distinct()->pluck('name')->toArray();

        $years = SparePart::select('year')
            ->distinct()
            ->pluck('year')
            ->filter(function ($year) {
                return is_numeric($year); // Keep only numeric values
            })
            ->map(function ($year) {
                return (int) $year; // Convert to integers
            })
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        // Start the base query
        $query = SparePart::query();

        // Apply filters based on your URL parameters
        if ($request->has('shop_id') && $request->shop_id != '') {
            $query->where('user_id', $request->shop_id);
        }

        if ($request->has('car_type') && $request->car_type != '') {
            $query->where('brand', $request->car_type);
        }

        if ($request->has('car_model') && $request->car_model != '') {
            $query->where('model', 'like', '%' . $request->car_model . '%');
        }

        if ($request->has('year') && $request->year != '') {
            $query->where('year', 'like', '%' . $request->year . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $category = SparepartCategory::select('id')->where('name', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        if ($request->has('sub-category') && $request->input('sub-category') != '') {
            $subCategory = SparepartCategory::select('id')->where('name', $request->input('sub-category'))->first();
            if ($subCategory) {
                $query->where('category_id', $subCategory->id);
            }
        }

        // Legacy filters (keeping for backward compatibility)
        if ($request->has('make') && $request->make != '') {
            $query->where('brand', $request->make);
        }

        if ($request->has('model') && $request->model != '') {
            $query->where('model', 'like', '%' . $request->model . '%');
        }

        if ($request->has('city') && $request->city != '') {
            $query->where('city', $request->city);
        }

        if ($request->has('subCategory') && $request->subCategory != '') {
            $subCategory = SparepartCategory::select('id')->where(['name' => $request->subCategory])->first();
            if ($subCategory) {
                $query->where('category_id', $subCategory->id);
            }
        }

        // final result of the filter
        $spareParts = $query->select('user_id')->distinct()->pluck('user_id');

        if ($spareParts->isEmpty()) {
            $dealers = collect(); // Return an empty collection
        } else {
            if ($request->has('dealer_id')) {
                $dealers = CarDealer::where('id', $request->dealer_id)->whereIn('user_id', $spareParts)->get();
            } else {
                $dealers = CarDealer::whereIn('user_id', $spareParts)->paginate(8);
            }
        }

        return view('spareparts.index', compact('dealers', 'spareParts', 'cities', 'makes', 'models', 'years', 'categories', 'conditions'));
    }

    public function getSubCategories(Request $request)
    {
        $category      = SparepartCategory::where(['name' => $request->category, 'parent_id' => null])->first();
        $subCategories = SparepartCategory::where('parent_id', $category->id)->distinct()->pluck('name');

        return response()->json(['subCategories' => $subCategories], 200);
    }

    /**
     * Handle spare part requests with query parameters
     * This method handles URLs like: /spare-part?id=123 or /spare-part?shop_id=688&car_type=Honda...
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function showFromQuery(Request $request)
    {
        // Check if there's an ID parameter for direct spare part view
        $id = $request->query('id');
        if ($id && is_numeric($id)) {
            return redirect()->route('sparepart.detail', ['id' => $id]);
        }

        // If no direct ID, but has other filter parameters, show filtered results
        // This handles URLs like: /spare-part?car_model=Civic&car_type=Honda&category=Engine...
        if ($request->hasAny(['shop_id', 'car_type', 'car_model', 'year', 'category', 'sub-category', 'make', 'model', 'city', 'subCategory'])) {
            // Call the existing filter method
            return $this->filter($request);
        }

        // If no parameters, redirect to spare parts index/listing page
        return redirect()->route('spareParts.index');
    }

    /**
     * ✅ Deep Linking Spare Parts (Legacy method - keeping for compatibility)
     */
    public function deepLinkDetail(Request $request)
    {
        $shopId = $request->query('shop_id');

        if (!$shopId || !is_numeric($shopId)) {
            abort(404); // or return a default view
        }

        // Redirect to the dealer page or to the spareParts index with filters
        return redirect()->route('spareparts.index', [
            'shop_id' => $shopId,
            'car_type' => $request->query('car_type'),
            'car_model' => $request->query('car_model'),
            'year' => $request->query('year'),
            'category' => $request->query('category'),
            'sub-category' => $request->query('sub-category'),
            'vin-number' => $request->query('vin-number'),
        ]);
    }

    /**
     * Create a new spare part (if needed)
     */
    public function create()
    {
        $categories = SparepartCategory::where('parent_id', null)->get();
        $brands = CarBrand::orderBy('name')->get();
        
        return view('spareparts.create', compact('categories', 'brands'));
    }

    /**
     * Store a new spare part (if needed)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'category_id' => 'required|exists:sparepart_categories,id',
            'part_type' => 'required|string',
            'city' => 'required|string',
        ]);

        $sparePart = SparePart::create($request->all());

        return redirect()->route('spareParts.index')->with('success', 'Spare part created successfully.');
    }

    /**
     * Edit spare part (if needed)
     */
    public function edit(SparePart $sparePart)
    {
        $categories = SparepartCategory::where('parent_id', null)->get();
        $brands = CarBrand::orderBy('name')->get();
        
        return view('spareparts.edit', compact('sparePart', 'categories', 'brands'));
    }

    /**
     * Update spare part (if needed)
     */
    public function update(Request $request, SparePart $sparePart)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'category_id' => 'required|exists:sparepart_categories,id',
            'part_type' => 'required|string',
            'city' => 'required|string',
        ]);

        $sparePart->update($request->all());

        return redirect()->route('spareParts.show', $sparePart)->with('success', 'Spare part updated successfully.');
    }

    /**
     * Delete spare part (if needed)
     */
    public function destroy(SparePart $sparePart)
    {
        $sparePart->delete();

        return redirect()->route('spareParts.index')->with('success', 'Spare part deleted successfully.');
    }
}