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
        $perPage    = request('perPage', 12);
        $currentUrl = url()->current();

        // Fetch distinct values for filters
        $cities = WorkshopProvider::select('branch')->distinct()->orderBy('branch')->pluck('branch');
        $brands   = DB::table('car_brand_workshop_provider')->distinct()->pluck('car_brand_id')->toArray();
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
            $workshop_ids = $brand->providers()->pluck('id ')->toArray();
            $query->whereIn('id', $workshop_ids);
        }

        if ($request->category_id) {
            $category = WorkshopCategory::find($request->category_id);
            $workshop_ids = $category->providers()->pluck('id ')->toArray();
            $query->whereIn('id', $workshop_ids);
        }

        // Paginate the results
        $workshops = $query->paginate($perPage);
        // foreach($workshops as $workshop){
        //     dd($workshop);
        // }
        // Return view with grouped data and other filter data
        return view('workshops.index', compact('cities', 'workshops','brands', 'categories'));

    }
}
