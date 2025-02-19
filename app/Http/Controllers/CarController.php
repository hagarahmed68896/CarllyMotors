<?php

namespace App\Http\Controllers;

use App\Models\CarListingModel;
use App\Models\CarBrand;
use App\Models\allUsersModel;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // Fetch distinct values for filters
        $cities = CarListingModel::select('city')->distinct()->orderBy('city')->pluck('city');
        $conditions = CarListingModel::select('car_type')->distinct()->orderBy('car_type')->pluck('car_type');
        $makes = CarListingModel::select('listing_type')->distinct()->orderBy('listing_type')->pluck('listing_type');
        $models = CarListingModel::select('listing_model')->distinct()->orderBy('listing_model')->pluck('listing_model');
        $years = CarListingModel::select('listing_year')->distinct()->orderBy('listing_year', 'desc')->pluck('listing_year');
        $bodyTypes = CarListingModel::select('body_type')->distinct()->orderBy('body_type')->pluck('body_type');
        $regionalSpecs = CarListingModel::select('regional_specs')->distinct()->orderBy('regional_specs')->pluck('regional_specs');
        $prices = CarListingModel::select('listing_price')->distinct()->orderBy('listing_price')->pluck('listing_price');

        // Pagination and sorting
        $perPage = 8; // Default to 8 if no value is selected
        // // Apply sorting based on the selected option
        // if ($sortBy == 'Price: Low to High') {
        //     $carlisting = $carlisting->orderBy('listing_price', 'asc');
        // } elseif ($sortBy == 'Price: High to Low') {
        //     $carlisting = $carlisting->orderBy('listing_price', 'desc');
        // } elseif ($sortBy == 'Newest') {
        //     $carlisting = $carlisting->orderBy('created_at', 'desc');
        // } elseif ($sortBy == 'Oldest') {
        //     $carlisting = $carlisting->orderBy('created_at', 'asc');
        // } else {
        //     // Default sorting (Newest by ID)
        //     $carlisting = $carlisting->orderBy('id', 'desc');
        // }

        // Start the base query
        $carlisting = CarListingModel::with('user');


        // Apply filters
        if ($request->has('make') && $request->make != '') {
            $carlisting->where('listing_type', $request->make);
        }

        if ($request->has('city') && $request->city != '') {
            $carlisting->where('city', $request->city);
        }

        if ($request->has('body_type') && $request->body_type != '') {
            $carlisting->where('body_type', $request->body_type);
        }

        if ($request->has('regional_specs') && $request->regionalSpec != '') {
            $carlisting->where('regionalSpec', $request->regionalSpec);
        }

        if ($request->has('model') && $request->model != '') {
            $carlisting->where('listing_model', $request->model);
        }

        if ($request->has('price') && $request->price != '') {
            $carlisting->where('listing_price', $request->price); // Fix typo: $request->rice to $request->price
        }

        if ($request->has('year') && $request->year != '') {
            $carlisting->where('listing_year', $request->year);
        }

        // Apply pagination with the selected perPage value
        $carlisting = $carlisting->has('user')->paginate(9);
        
        // Fetch other distinct values for filters
        $fueltypes = CarListingModel::select('features_fuel_type')->distinct()->orderBy('features_fuel_type')->pluck('features_fuel_type');
        $gears = CarListingModel::select('features_gear')->distinct()->orderBy('features_gear')->pluck('features_gear');
        $doors = CarListingModel::select('features_door')->distinct()->orderby('features_door', 'asc')->pluck('features_door');
        $cylinders = CarListingModel::select('features_cylinders')->distinct()->orderby('features_cylinders', 'asc')->pluck('features_cylinders');
        $colors = CarListingModel::select('car_color')->distinct()->orderby('car_color', 'asc')->pluck('car_color');

        // Return view with filter data
        return view('cars.index', compact(
            'carlisting',
            'cities',
            'makes',
            'models',
            'years',
            'bodyTypes',
            'regionalSpecs',
            'prices',
            'fueltypes',
            'gears',
            'doors',
            'cylinders',
            'colors',
            
            'conditions',
            
        ));
    }

    public function getModels(Request $request)
    {
        // dd($request);
        $brand = CarBrand::where('name',$request->brand)->first();
        // dd($brand);
        $brand_models = $brand->models()->pluck('name');
        // dd($brand_models);
        return response()->json(['models'=>$brand_models], 200);
    }

    
    public function destroy(CarListingModel $carListingModel)
    {
        //
    }
}
