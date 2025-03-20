<?php
namespace App\Http\Controllers;

use App\Models\BodyType;
use App\Models\CarBrand;
use App\Models\CarListingModel;
use App\Models\Color;
use App\Models\RegionalSpec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;


class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // dd($request);
        // Fetch distinct values for filters
        $cities        = CarListingModel::select('city')->distinct()->orderBy('city')->pluck('city');
        $conditions    = CarListingModel::select('car_type')->distinct()->orderBy('car_type')->pluck('car_type');
        $makes         = CarListingModel::select('listing_type')->distinct()->orderBy('listing_type')->pluck('listing_type');
        $models        = CarListingModel::select('listing_model')->distinct()->orderBy('listing_model')->pluck('listing_model');
        $years         = CarListingModel::select('listing_year')->distinct()->orderBy('listing_year', 'desc')->pluck('listing_year');
        $bodyTypes     = CarListingModel::select('body_type')->distinct()->orderBy('body_type')->pluck('body_type');
        $regionalSpecs = CarListingModel::select('regional_specs')->distinct()->orderBy('regional_specs')->pluck('regional_specs');
        // Get min and max price
        $minPrice = CarListingModel::min('listing_price');
        $maxPrice = CarListingModel::max('listing_price');

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

        if ($request->has('priceFrom') && $request->has('priceTo')) {
            $carlisting->whereBetween('listing_price', [$request->priceFrom, $request->priceTo]); // Fix typo: $request->rice to $request->price
        }

        if ($request->has('year') && $request->year != '') {
            $carlisting->where('listing_year', $request->year);
        }

        if ($request->has('car_type') && $request->car_type != '') {
            if ($request->car_type == "UsedOrNew") {
                $carlisting->where('car_type', "Used")->orWhere('car_type', "New");
            } else {
                $carlisting->where('car_type', $request->car_type);
            }
        }

        // Apply pagination with the selected perPage value
        $carlisting = $carlisting->has('user')->paginate(9);

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
            'minPrice',
            'maxPrice',
            'fueltypes',
            'gears',
            'doors',
            'cylinders',
            'colors',
            'conditions',

        ));
    }

    public function create()
    {
        $brands        = CarBrand::pluck('name')->toArray();
        $bodyTypes     = BodyType::pluck('name')->toArray();
        $regionalSpecs = RegionalSpec::pluck('name')->toArray();
        $colors        = Color::get();

        return view('cars.create', compact('brands', 'bodyTypes', 'regionalSpecs', 'colors'));
    }

    public function store(Request $request)
    {
        try {
            $car                        = new CarListingModel();
            $car->user_id               = $request->user_id;
            $car->listing_type          = $request->make;
            $car->listing_model         = $request->model;
            $car->listing_year          = $request->year;
            $car->body_type             = $request->bodyType;
            $car->regional_specs        = $request->regionalSpec;
            $car->city                  = $request->city;
            $car->features_others       = $request->features;
            $car->vin_number            = $request->vin_number;
            $car->features_gear         = $request->gear;
            $car->features_speed        = $request->mileage;
            $car->car_color             = $request->color;
            $car->features_climate_zone = $request->warranty;
            $car->features_fuel_type    = $request->fuelType;
            $car->features_seats        = $request->seats;
            $car->listing_title         = $request->name;
            $car->wa_number             = '+971' . $request->phone;
            $car->listing_price         = $request->price;
            $car->lat                   = $request->latitude;
            $car->lng                   = $request->longitude;
            $car->save();

            // uploading Image
            $carId = $car->id;
            $images = $request->file('images');

            $multipartData = [
                [
                    'name'     => 'car_id',
                    'contents' => $car->id,
                ]
            ];
            
            foreach ($images as $image) {
                $multipartData[] = [
                    'name'     => 'imgs[]',  // <--- Use imgs[] for multiple
                    'contents' => fopen($image->getPathname(), 'r'),
                    'filename' => $image->getClientOriginalName(),
                ];
            }
            
            $client = new Client();
            
            $response = $client->post('https://backend.carllymotors.com/api/uploadImg', [
                'multipart' => $multipartData,
            ]);

        // Optionally, decode the API response
        $body = json_decode($response->getBody(), true);

        // Do something with $body if needed or return it
        dd(response()->json($body));
    // }
        // return redirect()->route('car.detail', $car->id)->with('success', 'Car Added successfully');
        
    } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function getModels(Request $request)
    {
        // dd(gettype($request->brand));
        $brand = CarBrand::where('name', $request->brand)->first();
        // dd($brand);
        $brand_models = $brand->models()->pluck('name');
        // dd($brand_models);
        return response()->json(['models' => $brand_models], 200);
    }

    public function destroy(CarListingModel $carListingModel)
    {
        //
    }

    public function addTofav(Request $request, $carId)
    {
        try {
            $user    = auth()->user();
            $favList = $user->favCars->pluck('id')->toArray();

            if (in_array($carId, $favList)) {
                $user->favCars()->detach($carId);
            } else {
                $user->favCars()->attach($carId);
            }
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function favList()
    {
        $user       = auth()->user();
        $carlisting = $user->favCars;
        return view('cars.favList', compact('carlisting'));
    }

    public function myCarListing()
    {
        $user       = auth()->user();
        $carlisting = $user->cars;
        return view('cars.favList', compact('carlisting'));
    }

}
