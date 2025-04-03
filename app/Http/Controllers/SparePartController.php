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
        $perPage    = request('perPage', 8);
        $currentUrl = url()->current();

        $users = SparePart::select('user_id')
            ->distinct()
            ->inRandomOrder()
            ->limit(8)
            ->pluck('user_id');
            
        if ($request->has('dealer_id')) {
            $dealers = CarDealer::where('id', $request->dealer_id)->get();
        } else {
            $dealers = CarDealer::whereIn('user_id', $users)->paginate(8);

        }
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

        // Return view with grouped data and other filter data
        return view('spareparts.index', compact('dealers', 'cities', 'makes', 'models', 'years', 'categories', 'conditions'));

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
        $categories   = SparePartCategory::select('id', 'name')->whereIn('id', $category_ids)->distinct()->pluck('name')->toArray();
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
            $category = SparePartCategory::select('id')->where('name', $request->category)->first();
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
        $categories   = SparePartCategory::where('parent_id', null)->whereIn('id', $category_ids)->distinct()->pluck('name')->toArray();

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

        // Apply filters
        if ($request->has('make') && $request->make != '') {
            $query->where('brand', $request->make);
        }
        if ($request->has('model') && $request->model != '') {
            $query->where('car_model', 'like', '%' . $request->model . '%');
        }

        if ($request->has('city') && $request->city != '') {
            $query->where('city', $request->city);
        }

        if ($request->has('subCategory') && $request->subCategory != '') {
            $subCategory = SparePartCategory::select('id')->where(['name' => $request->subCategory])->first();
            // dd($subCategory->id);
            $query->where('category_id', $subCategory->id);
        }

        if ($request->has('year') && $request->year != '') {
            $query->where('year', 'like', '%' . $request->year . '%');
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
        $category      = SparePartCategory::where(['name' => $request->category, 'parent_id' => null])->first();
        $subCategories = SparePartCategory::where('parent_id', $category->id)->distinct()->pluck('name');

        return response()->json(['subCategories' => $subCategories], 200);
    }
}
