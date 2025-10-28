<?php
namespace App\Http\Controllers;

use App\Models\CarBrand;
use App\Models\CarDealer;
use App\Models\SparePart;
use App\Models\SparepartCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SparePartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    // ✅ جلب الفئات الرئيسية والفرعية
    $mainCategories = DB::table('sparepart_categories')
        ->whereNull('parent_id')
        ->get();

    $subCategories = DB::table('sparepart_categories')
        ->whereNotNull('parent_id')
        ->get();

    // ✅ ربط الفروع مع الرئيسية
    foreach ($mainCategories as $cat) {
        $cat->subcategories = $subCategories->where('parent_id', $cat->id)->values();
    }

    // ✅ بناء كويري الفلترة
    $sparePartsQuery = DB::table('spare_parts')
        ->when($request->filled('make'), fn($q) => $q->where('brand', $request->make))
        ->when($request->filled('category'), fn($q) => $q->where('category_id', $request->category))
        ->when($request->filled('city'), fn($q) => $q->whereRaw('LOWER(city) = ?', [strtolower($request->city)]))
        ->when($request->filled('model'), function ($q) use ($request) {
            $q->where(function ($subQ) use ($request) {
                $subQ->where('car_model', 'LIKE', '%"'.$request->model.'"%')
                     ->orWhere('car_model', 'LIKE', "%{$request->model}%");
            });
        })
        ->when($request->filled('year'), fn($q) => $q->whereRaw('JSON_CONTAINS(year, ?)', ['"' . $request->year . '"']))
        ->when($request->filled('condition'), fn($q) => $q->where('part_type', $request->condition))
        ->limit(25);

    // ✅ user_ids
    $userIds = $sparePartsQuery->distinct()->pluck('user_id');

    // ✅ dealers باستخدام الموديل CarDealer + العلاقات
    $dealers = collect();

    if ($userIds->isNotEmpty()) {
        $dealers = \App\Models\CarDealer::query()
            ->when($request->filled('dealer_id'), fn($q) => $q->where('id', $request->dealer_id))
            ->whereIn('user_id', $userIds)
            ->with(['user', 'spareParts'])
            ->withCount('spareParts')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();
    }

    // ✅ بيانات الفلاتر
    $makes = DB::table('spare_parts')->whereNotNull('brand')->distinct()->pluck('brand');
    $years = range(date('Y'), 1990);
    rsort($years);
    $cities = DB::table('spare_parts')->whereNotNull('city')->distinct()->pluck('city');
    $conditions = ['New', 'Used'];

    // ✅ خريطة الموديلات (make => models)
    $brandModels = DB::table('spare_parts')
        ->select('brand', 'car_model')
        ->whereNotNull('brand')
        ->whereNotNull('car_model')
        ->get()
        ->groupBy(fn($item) => strtolower(trim($item->brand)))
        ->map(function ($group) {
            $models = $group->pluck('car_model')
                ->flatMap(function ($item) {
                    $item = trim($item);

                    $decoded = json_decode($item, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        return $decoded;
                    }

                    if (str_contains($item, '\\')) {
                        $parts = preg_split('/\\\\+/', $item);
                        return $parts;
                    }

                    if (preg_match('/,| \//', $item)) {
                        $parts = preg_split('/\s*[,\|]\s*|\s+\/\s+/', $item);
                        return $parts;
                    }

                    return [$item];
                })
                ->map(function ($m) {
                    return trim(str_replace(['"', '[', ']', '\\'], '', $m));
                })
                ->filter(function ($m) {
                    return $m !== '' && !ctype_punct($m) && strlen($m) > 1;
                })
                ->unique()
                ->values();

            return $models;
        });

    // ✅ إرسال كل البيانات للواجهة
    return view('spareparts.index', compact(
        'dealers',
        'makes',
        'years',
        'cities',
        'conditions',
        'mainCategories',
        'subCategories',
        'brandModels'
    ));
}


public function filter(Request $request)
{
    // مجرد إعادة استخدام نفس الكود لكن مع الـ request الحالي
    return $this->index($request);
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





// public function getModels(Request $request)
// {
//     $brand = $request->get('brand');

//     $models = SparePart::where('brand', $brand)
//         ->select('model')
//         ->distinct()
//         ->orderBy('model')
//         ->pluck('model')
//         ->filter()
//         ->values();

//     return response()->json($models);
// }



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