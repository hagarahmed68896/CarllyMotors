<?php
namespace App\Http\Controllers;

use App\Models\BodyType;
use App\Models\CarBrand;
use App\Models\CarListingModel;
use App\Models\Color;
use App\Models\RegionalSpec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
public function index(Request $request)
{
    // Filters
    $cities        = CarListingModel::select('city')->distinct()->orderBy('city')->pluck('city');
    $conditions    = CarListingModel::select('car_type')->distinct()->orderBy('car_type')->pluck('car_type');
    $makes         = CarListingModel::select('listing_type')->distinct()->orderBy('listing_type')->pluck('listing_type');
    $models        = CarListingModel::select('listing_model')->distinct()->orderBy('listing_model')->pluck('listing_model');
    $years         = CarListingModel::select('listing_year')->distinct()->orderBy('listing_year', 'desc')->pluck('listing_year');
    $bodyTypes     = CarListingModel::select('body_type')->distinct()->orderBy('body_type')->pluck('body_type');
    $regionalSpecs = CarListingModel::select('regional_specs')->distinct()->orderBy('regional_specs')->pluck('regional_specs');
    $minPrice      = CarListingModel::min('listing_price');
    $maxPrice      = CarListingModel::max('listing_price');

    // Base query
    $carlisting = CarListingModel::with(['user', 'images']);

    // Apply search
    if ($request->filled('q')) {
        $carlisting->where(function($query) use ($request) {
            $query->where('listing_type', 'like', '%' . $request->q . '%')
                  ->orWhere('listing_model', 'like', '%' . $request->q . '%')
                  ->orWhere('city', 'like', '%' . $request->q . '%');
        });
    }

    // Apply filters
    if ($request->filled('make')) {
        $carlisting->where('listing_type', $request->make);
    }
    if ($request->filled('city')) {
        $carlisting->where('city', $request->city);
    }
    if ($request->filled('body_type')) {
        $carlisting->where('body_type', $request->body_type);
    }
    if ($request->filled('regionalSpec')) {
        $carlisting->where('regional_specs', $request->regionalSpec);
    }
    if ($request->filled('model')) {
        $carlisting->where('listing_model', $request->model);
    }
    if ($request->filled('priceFrom') && $request->filled('priceTo')) {
        $carlisting->whereBetween('listing_price', [$request->priceFrom, $request->priceTo]);
    }
    if ($request->filled('year')) {
        $carlisting->where('listing_year', $request->year);
    }
    if ($request->filled('car_type')) {
        if ($request->car_type == "UsedOrNew") {
            $carlisting->whereIn('car_type', ["Used", "New"]);
        } else {
            $carlisting->where('car_type', $request->car_type);
        }
    }

// Get all results
$carlisting = $carlisting->paginate(12)->withQueryString();

// Map first valid image for each car (without breaking pagination)
$carlisting->getCollection()->transform(function ($car) {
    $firstValidImage = $car->images->first(function ($image) {
        return Storage::disk('r2')->exists($image->image);
    });

    $car->image = $firstValidImage ?? null;
    return $car;
});


    // Other filters
    $fueltypes = CarListingModel::select('features_fuel_type')->distinct()->orderBy('features_fuel_type')->pluck('features_fuel_type');
    $gears     = CarListingModel::select('features_gear')->distinct()->orderBy('features_gear')->pluck('features_gear');
    $doors     = CarListingModel::select('features_door')->distinct()->orderby('features_door', 'asc')->pluck('features_door');
    $cylinders = CarListingModel::select('features_cylinders')->distinct()->orderby('features_cylinders', 'asc')->pluck('features_cylinders');
    $colors    = CarListingModel::select('car_color')->distinct()->orderby('car_color', 'asc')->pluck('car_color');

    // Return view
    return view('cars.index', compact(
        'carlisting', 'cities', 'makes', 'models', 'years',
        'bodyTypes', 'regionalSpecs', 'minPrice', 'maxPrice',
        'fueltypes', 'gears', 'doors', 'cylinders', 'colors', 'conditions'
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
            $car->max                   = 10;
            $car->save();

            // uploading Image
            if ($request->images) {

                $uploadedImages = $request->images;
                foreach ($uploadedImages as $index => $uploadedImage) {
                    if ($index >= $car->max) {
                        break;
                    }
    
                    $imgName = time() . '_' . $index . '.' . $uploadedImage->getClientOriginalExtension();
    
                    $path = Storage::disk('r2')->put('listings/' . $imgName, file_get_contents($uploadedImage));   
                    
                    // $uploadedImage->move(public_path('listings'), $imgName);
                    $imagePath = 'listings/' . $imgName;
    
                    $car->images()->create([
                        'image' => $imagePath,
                    ]);
                }
                $car->current = count($car->images);
                $car->save();
            }

            return redirect()->route('car.detail', $car->id)->with('success', 'Car Added successfully');

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
    public function loadMoreCars(Request $request)
    {
        $cars = CarlistingModel::with(['user', 'images'])->orderBy('id', 'desc')->paginate(9); // تحميل 8 سيارات في كل مرة

        $cars->getCollection()->transform(function ($car) {
            $firstValidImage = $car->images->first(function ($image) {
                return Storage::disk('r2')->exists($image->image);
            });
        
            $car->image = $firstValidImage;
            return $car;
        });

        return response()->json([
            'cars' => view('partials.car_card', compact('cars'))->render(),
        ]);
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
  
  // ✅ Add this for deep linking support
public function detailFromQuery(Request $request)
{
    $carId = $request->query('id');

    if (!$carId || !is_numeric($carId)) {
        abort(404);
    }

    return redirect()->route('car.detail', ['id' => $carId]);
}


}
