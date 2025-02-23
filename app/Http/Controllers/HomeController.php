<?php
namespace App\Http\Controllers;

use App\Models\CarBrand;
use App\Models\CarListingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Fetch brands that have more than 2 cars
        // Fetch brands that have more than 2 cars
        $brands = CarBrand::select('id', 'name')
            ->whereHas('cars')
            ->withCount('cars')
            ->having('cars_count', '>', 2)
            ->orderBy('name')
            ->get();

        // Define filter columns

        //
        // Fetch distinct values for filters
        $cities        = CarListingModel::select('city')->distinct()->orderBy('city')->pluck('city');
        $makes         = CarListingModel::select('listing_type')->distinct()->orderBy('listing_type')->pluck('listing_type');
        $models        = CarListingModel::select('listing_model')->distinct()->orderBy('listing_model')->pluck('listing_model');
        $years         = CarListingModel::select('listing_year')->distinct()->orderBy('listing_year', 'desc')->pluck('listing_year');
        $bodyTypes     = CarListingModel::select('body_type')->distinct()->orderBy('body_type')->pluck('body_type');
        $regionalSpecs = CarListingModel::select('regional_specs')->distinct()->orderBy('regional_specs')->pluck('regional_specs');
        $minPrice = CarListingModel::min('listing_price');
        $maxPrice = CarListingModel::max('listing_price');

        // Get min and max price
        $minPrice = CarListingModel::min('listing_price');
        $maxPrice = CarListingModel::max('listing_price');

        // Get min and max year
        $minYear = CarListingModel::min('listing_year');
        $maxYear = CarListingModel::max('listing_year');

                                                 // Pagination and sorting
        $perPage = request('perPage', 9);        // Default to 9 if no value is selected
        $sortBy  = request('sortBy', 'default'); // Default to 'default' if no sorting is selected

        // Start the base query
        $carlisting = CarListingModel::with('user');

        // Apply sorting based on the selected option
        if ($sortBy == 'Price: Low to High') {
            $carlisting = $carlisting->orderBy('listing_price', 'asc');
        } elseif ($sortBy == 'Price: High to Low') {
            $carlisting = $carlisting->orderBy('listing_price', 'desc');
        } elseif ($sortBy == 'Newest') {
            $carlisting = $carlisting->orderBy('created_at', 'desc');
        } elseif ($sortBy == 'Oldest') {
            $carlisting = $carlisting->orderBy('created_at', 'asc');
        } else {
            // Default sorting (Newest by ID)
            $carlisting = $carlisting->orderBy('id', 'desc');
        }

        // Apply pagination with the selected perPage value
        $carlisting = $carlisting->paginate($perPage);

        // Fetch other distinct values for filters
        $fueltypes = CarListingModel::select('features_fuel_type')->distinct()->orderBy('features_fuel_type')->pluck('features_fuel_type');
        $gears     = CarListingModel::select('features_gear')->distinct()->orderBy('features_gear')->pluck('features_gear');
        $doors     = CarListingModel::select('features_door')->distinct()->orderby('features_door', 'asc')->pluck('features_door');
        $cylinders = CarListingModel::select('features_cylinders')->distinct()->orderby('features_cylinders', 'asc')->pluck('features_cylinders');
        $colors    = CarListingModel::select('car_color')->distinct()->orderby('car_color', 'asc')->pluck('car_color');

        
        // Return view with filter data
        return view('home', compact(
            'carlisting',
            'cities',
            'makes',
            'models',
            'years',
            'bodyTypes',
            'regionalSpecs',
            
            'minPrice',
            'maxPrice',
            'fueltypes',
            'gears',
            'doors',
            'cylinders',
            'colors',
            'minPrice',
            'maxPrice',
            'minYear',
            'maxYear', 
            'brands'
        ));
    }

    public function filters(Request $request)
    {
        // Fetch brands with more than 2 associated cars
        $brands = CarBrand::withCount('cars')
            ->having('cars_count', '>', 2)
            ->orderBy('name')
            ->get(['id', 'name']);

        // Fetch distinct values for filters
        $filterColumns = [
            'city',
            'listing_type',
            'listing_model',
            'listing_year',
            'body_type',
            'regional_specs',
            'listing_price',
        ];

        $filters = [];
        foreach ($filterColumns as $column) {
            $filters[$column] = CarListingModel::distinct()->orderBy($column)->pluck($column);
        }

        // Initialize the query
        $query = CarListingModel::with('user')->latest()->limit(9);

        // Apply dynamic filters
        foreach ($filterColumns as $column) {
            if ($request->filled($column)) {
                $query->where($column, $request->$column);
            }
        }

        // Fetch car listings
        $carlisting = $query->with('user')
            ->where('car_type', "Used")
            ->orderBy('body_type')
            ->get()
            ->groupBy('body_type');

        // Return the view with data
        return view('home', [
            'carlisting'    => $carlisting,
            'brands'        => $brands,
            'cities'        => $filters['city'] ?? collect(),
            'makes'         => $filters['listing_type'] ?? collect(),
            'models'        => $filters['listing_model'] ?? collect(),
            'years'         => $filters['listing_year'] ?? collect(),
            'bodyTypes'     => $filters['body_type'] ?? collect(),
            'regionalSpecs' => $filters['regional_specs'] ?? collect(),
            'prices'        => $filters['listing_price'] ?? collect(),
        ]);
    }

    public function carListing(Request $request)
    {
        // Fetch distinct values for filters
        $cities        = CarListingModel::select('city')->distinct()->orderBy('city')->pluck('city');
        $makes         = CarListingModel::select('listing_type')->distinct()->orderBy('listing_type')->pluck('listing_type');
        $models        = CarListingModel::select('listing_model')->distinct()->orderBy('listing_model')->pluck('listing_model');
        $years         = CarListingModel::select('listing_year')->distinct()->orderBy('listing_year', 'desc')->pluck('listing_year');
        $bodyTypes     = CarListingModel::select('body_type')->distinct()->orderBy('body_type')->pluck('body_type');
        $regionalSpecs = CarListingModel::select('regional_specs')->distinct()->orderBy('regional_specs')->pluck('regional_specs');
        $prices        = CarListingModel::select('listing_price')->distinct()->orderBy('listing_price')->pluck('listing_price');

        // Get min and max price
        $minPrice = CarListingModel::min('listing_price');
        $maxPrice = CarListingModel::max('listing_price');

        // Get min and max year
        $minYear = CarListingModel::min('listing_year');
        $maxYear = CarListingModel::max('listing_year');

                                                 // Pagination and sorting
        $perPage = request('perPage', 9);        // Default to 9 if no value is selected
        $sortBy  = request('sortBy', 'default'); // Default to 'default' if no sorting is selected

        // Start the base query
        $carlisting = CarListingModel::with('user');

        // Apply sorting based on the selected option
        if ($sortBy == 'Price: Low to High') {
            $carlisting = $carlisting->orderBy('listing_price', 'asc');
        } elseif ($sortBy == 'Price: High to Low') {
            $carlisting = $carlisting->orderBy('listing_price', 'desc');
        } elseif ($sortBy == 'Newest') {
            $carlisting = $carlisting->orderBy('created_at', 'desc');
        } elseif ($sortBy == 'Oldest') {
            $carlisting = $carlisting->orderBy('created_at', 'asc');
        } else {
            // Default sorting (Newest by ID)
            $carlisting = $carlisting->orderBy('id', 'desc');
        }

        // Apply pagination with the selected perPage value
        $carlisting = $carlisting->paginate($perPage);

        // Fetch other distinct values for filters
        $fueltypes = CarListingModel::select('features_fuel_type')->distinct()->orderBy('features_fuel_type')->pluck('features_fuel_type');
        $gears     = CarListingModel::select('features_gear')->distinct()->orderBy('features_gear')->pluck('features_gear');
        $doors     = CarListingModel::select('features_door')->distinct()->orderby('features_door', 'asc')->pluck('features_door');
        $cylinders = CarListingModel::select('features_cylinders')->distinct()->orderby('features_cylinders', 'asc')->pluck('features_cylinders');
        $colors    = CarListingModel::select('car_color')->distinct()->orderby('car_color', 'asc')->pluck('car_color');

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
            'minPrice',
            'maxPrice',
            'minYear',
            'maxYear'
        ));
    }

    public function filter(Request $request)
    {
        // Fetch distinct values for filters
        $makes         = CarListingModel::select('listing_type')->distinct()->orderBy('listing_type')->pluck('listing_type');
        $models        = CarListingModel::select('listing_model')->distinct()->orderBy('listing_model')->pluck('listing_model');
        $years         = CarListingModel::select('listing_year')->distinct()->orderBy('listing_year', 'desc')->pluck('listing_year');
        $bodyTypes     = CarListingModel::select('body_type')->distinct()->orderBy('body_type')->pluck('body_type');
        $regionalSpecs = CarListingModel::select('regional_specs')->distinct()->orderBy('regional_specs')->pluck('regional_specs');
        $prices        = CarListingModel::select('listing_price')->distinct()->orderBy('listing_price')->pluck('listing_price');
        $fueltypes     = CarListingModel::select('features_fuel_type')->distinct()->orderBy('features_fuel_type')->pluck('features_fuel_type');
        $gears         = CarListingModel::select('features_gear')->distinct()->orderBy('features_gear')->pluck('features_gear');
        $doors         = CarListingModel::select('features_door')->distinct()->orderby('features_door', 'asc')->pluck('features_door');
        $cylinders     = CarListingModel::select('features_cylinders')->distinct()->orderby('features_cylinders', 'asc')->pluck('features_cylinders');
        $colors        = CarListingModel::select('car_color')->distinct()->orderby('car_color', 'asc')->pluck('car_color');

        // Get min and max price
        $minPrice = CarListingModel::min('listing_price');
        $maxPrice = CarListingModel::max('listing_price');

        // Get min and max year
        $minYear = CarListingModel::min('listing_year');
        $maxYear = CarListingModel::max('listing_year');

        // Start the base query
        $query = CarListingModel::query();

        // Apply filters
        if ($request->has('make') && $request->make != '') {
            $query->where('listing_type', $request->make);
        }

        if ($request->has('car_type') && $request->car_type != '') {
            if($request->car_type == "UsedOrNew"){
                $query->where('car_type', "Used")->orWhere('car_type', "New");
            }else{
                $query->where('car_type', $request->make);
            }
        }

        if ($request->has('model') && $request->model != '') {
            $query->where('listing_model', $request->model);
        }

        if ($request->has('priceFrom') && $request->has('priceTo')) {
            $query->whereBetween('listing_price', [$request->priceFrom, $request->priceTo]); // Fix typo: $request->rice to $request->price
        }

        if ($request->has('fuel_type') && $request->fuel_type != '') {
            $query->where('features_fuel_type', $request->fuel_type);
        }

        if ($request->has('transmission') && $request->transmission != '') {
            $query->where('features_gear', $request->transmission);
        }

        if ($request->has('door') && $request->door != '') {
            $query->where('features_door', $request->door);
        }

        if ($request->has('cylinder') && $request->cylinder != '') {
            $query->where('features_cylinders', $request->cylinder);
        }

        if ($request->has('color') && $request->color != '') {
            $query->where('car_color', $request->color);
        }

        if ($request->has('year') && $request->year != '') {
            $query->where('listing_year', '>=', $request->year);
        }

        if ($request->has('distance') && $request->distance != '') {
            $query->where('features_speed', '<=', $request->distance);
        }
                                                 // Pagination and sorting
        $perPage = request('perPage',9);        // Default to 9 if no value is selected
        $sortBy  = request('sortBy', 'default'); // Default to 'default' if no sorting is selected

        // Apply sorting based on the selected option
        if ($sortBy == 'Price: Low to High') {
            $query->orderBy('listing_price', 'asc');
        } elseif ($sortBy == 'Price: High to Low') {
            $query->orderBy('listing_price', 'desc');
        } elseif ($sortBy == 'Newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sortBy == 'Oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            // Default sorting (Newest by ID)
            $query->orderBy('id', 'desc');
        }

        // Apply pagination with the selected perPage value
        $carlisting = $query->with('user')->paginate($perPage);

        // Return view with filter data
        return view('cars.index', compact(
            'carlisting',
            'makes',
            'models',
            'years',
            'bodyTypes',
            'regionalSpecs',
            'conditions',
            'prices',
            'fueltypes',
            'gears',
            'doors',
            'cylinders',
            'colors',
            'minPrice',
            'maxPrice',
            'minYear',
            'maxYear'
        ));
    }
    public function detail($id)
    {

        // Decrypt the ID
        $id = Crypt::decrypt($id);

        // Convert listing_modal back to original format
        // $formattedModal = str_replace('-', ' ', $slug);

        // Find the car
        $car             = CarListingModel::where('id', $id)->with('user')->firstOrFail();
        $recommendedCars = CarListingModel::where('listing_type', $car->listing_type)
            ->where(function ($query) use ($car) {
                $query->where('listing_model', $car->listing_model)
                    ->orWhere('car_type', $car->car_type);
            })
            ->whereBetween('listing_price', [$car->listing_price - 2000, $car->listing_price + 2000])
            ->where('id', '!=', $car->id)
            ->take(5)
            ->get();
        return view('cars.show', compact('car', 'recommendedCars'));
    }
}
