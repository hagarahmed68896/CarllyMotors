<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CarListingModel;
use App\Models\SparePart;
use App\Models\SparepartCategory;
use App\Models\WorkshopProvider;
use App\Models\WorkshopCategory;
use App\Models\CarBrand;
use App\Models\CarDealer;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $type  = $request->get('type', 'cars'); // default to cars
        $query = $request->get('q');

        switch ($type) {
            case 'cars':
                return $this->searchCars($request, $query);

            case 'spareparts':
                return $this->searchSpareParts($request, $query);

            case 'workshops':
                return $this->searchWorkshops($request, $query);

            default:
                abort(404);
        }
    }

    // ================= CAR SEARCH =================
protected function searchCars(Request $request, $query)
{
    $cars = CarListingModel::with(['user', 'images']);

    // البحث العام
    if ($query) {
        $cars->where(function($q) use ($query) {
            $q->where('listing_type', 'like', "%{$query}%")
              ->orWhere('listing_model', 'like', "%{$query}%")
              ->orWhere('car_color', 'like', "%{$query}%");
        });
    }

    // الفلاتر
    $filters = [
        'make' => 'listing_type',
        'model' => 'listing_model',
        'city' => 'city',
        'body_type' => 'body_type',
        'regionalSpecs' => 'regional_specs',
        'year' => 'listing_year'
    ];

    foreach ($filters as $input => $column) {
        if ($request->filled($input)) {
            $cars->where($column, $request->$input);
        }
    }

    // السعر
    if ($request->filled('priceFrom') && $request->filled('priceTo')) {
        $cars->whereBetween('listing_price', [$request->priceFrom, $request->priceTo]);
    }

    // الحالة
    if ($request->filled('car_type')) {
        if ($request->car_type === 'UsedOrNew') {
            $cars->whereIn('car_type', ['Used', 'New']);
        } else {
            $cars->where('car_type', $request->car_type);
        }
    }

    $carlisting = $cars->paginate(12)->withQueryString();

    // ✅ هنا الحل
    if ($request->ajax()) {
        // ارجعي فقط الكروت
        return view('cars.load_more', compact('carlisting'))->render();
    }

    // باقي البيانات (للأول تحميل فقط)
    $cities        = CarListingModel::select('city')->distinct()->pluck('city');
    $makes         = CarListingModel::select('listing_type')->distinct()->pluck('listing_type');
    $models        = CarListingModel::select('listing_model')->distinct()->pluck('listing_model');
    $years         = CarListingModel::select('listing_year')->distinct()->pluck('listing_year');
    $bodyTypes     = CarListingModel::select('body_type')->distinct()->pluck('body_type');
    $regionalSpecs = CarListingModel::select('regional_specs')->distinct()->pluck('regional_specs');
    $conditions    = CarListingModel::select('car_type')->distinct()->pluck('car_type');
    $minPrice      = CarListingModel::min('listing_price');
    $maxPrice      = CarListingModel::max('listing_price');

    $brands = $cars->select('listing_type as name')->distinct()->get();
    $currentMake = $request->make;

    return view('cars.index', compact(
        'carlisting', 'cities', 'makes', 'models', 'years',
        'bodyTypes', 'regionalSpecs', 'minPrice', 'maxPrice', 'conditions',
        'brands', 'currentMake'
    ));
}



    // ================= SPARE PARTS SEARCH =================
public function searchSpareParts(Request $request)
{
    $q = $request->get('q');

    // ابحث داخل جدول car_dealers
    $dealers = CarDealer::query()
        ->when($q, function ($query) use ($q) {
            $query->where('company_name', 'like', "%{$q}%")
                  ->orWhere('company_address', 'like', "%{$q}%")
                  ->orWhere('is_top_dealer', 'like', "%{$q}%");
        })
        ->orderByDesc('is_top_dealer')
        ->paginate(12)
        ->withQueryString();

    // تحميل باقي بيانات الفلاتر من spare_parts كالمعتاد
    $makes = SparePart::select('brand')->distinct()->orderBy('brand')->pluck('brand');
    $models = SparePart::select('model')->distinct()->orderBy('model')->pluck('model');
    $conditions = SparePart::select('part_type')->distinct()->orderBy('part_type')->pluck('part_type');
    $cities = SparePart::select('city')->distinct()->orderBy('city')->pluck('city');

    $category_ids = SparePart::distinct()->pluck('category_id')->toArray();
    // $categories = SparepartCategory::whereNull('parent_id')
    //     ->whereIn('id', $category_ids)
    //     ->distinct()
    //     ->pluck('name')
    //     ->toArray();

    $categories = SparepartCategory::whereNull('parent_id')
    ->whereIn('id', $category_ids)
    ->distinct()
    ->get(['id', 'name', 'image']);


    $years = SparePart::select('year')
        ->distinct()
        ->pluck('year')
        ->filter(fn($year) => is_numeric($year))
        ->map(fn($year) => (int) $year)
        ->unique()
        ->sort()
        ->values()
        ->toArray();

    return view('spareparts.index', compact(
        'dealers', 'cities', 'makes', 'models', 'years', 'categories', 'conditions'
    ));
}



    // ================= WORKSHOPS SEARCH =================
protected function searchWorkshops(Request $request, $query)
{
    $workshops = WorkshopProvider::query();

    // 🔍 Search by name or branch
    if ($query) {
        $workshops->where(function($q) use ($query) {
            $q->where('workshop_name', 'like', "%{$query}%")
              ->orWhere('branch', 'like', "%{$query}%");
        });
    }

    // 🔧 Dynamic Filters: city, area, rating
    foreach (['city'=>'branch', 'area'=>'area', 'rating'=>'rating'] as $input => $column) {
        if ($request->filled($input)) {
            if ($column === 'rating') {
                $workshops->where($column, '>=', $request->$input);
            } else {
                $workshops->where($column, $request->$input);
            }
        }
    }

    // 🚘 Brand Filter
    if ($request->filled('brand_id')) {
        $brand = CarBrand::find($request->brand_id);
        if ($brand) {
            $ids = $brand->providers()->pluck('workshop_provider_id')->toArray();
            $workshops->whereIn('id', $ids);
        }
    }

    // 🛠 Category Filter
    if ($request->filled('category_id')) {
        $category = WorkshopCategory::find($request->category_id);
        if ($category) {
            $ids = $category->providers()->pluck('workshop_provider_id')->toArray();
            $workshops->whereIn('id', $ids);
        }
    }

    // 🔄 Sorting
    switch ($request->input('sortBy', 'random')) {
        case 'rating_high': $workshops->orderBy('rating','desc'); break;
        case 'rating_low':  $workshops->orderBy('rating','asc'); break;
        case 'name_asc':    $workshops->orderBy('workshop_name','asc'); break;
        case 'name_desc':   $workshops->orderBy('workshop_name','desc'); break;
        case 'latest':      $workshops->latest(); break;
        case 'oldest':      $workshops->orderBy('created_at','asc'); break;
        default:            $workshops->inRandomOrder(); break;
    }

    // 📌 Paginate results
    $results = $workshops->paginate(12)->withQueryString();

    // ==================== SIDEBAR FILTERS ====================

    // Cities list
    $cities = WorkshopProvider::select('branch')->distinct()->pluck('branch');

    // Brands list
    $brands = CarBrand::whereIn(
                    'id',
                    DB::table('car_brand_workshop_provider')->distinct()->pluck('car_brand_id')
                )
                ->pluck('name','id');

    // Categories list (✔️ FIXED — return id + name + image)
    $categories = WorkshopCategory::whereIn(
                        'id',
                        DB::table('workshop_category_provider')->distinct()->pluck('workshop_category_id')
                   )
                   ->select('id','name','image')
                   ->get();

    $workshops = $results;

    return view('workshops.index', compact('workshops', 'cities', 'brands', 'categories'));
}

}
