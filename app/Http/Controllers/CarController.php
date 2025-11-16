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

    // ✅ لو الطلب Ajax، رجّعي partial view فقط
    if ($request->ajax()) {
        return view('cars.load_more', compact('carlisting'))->render();
    }

    // Other filters
    $fueltypes = CarListingModel::select('features_fuel_type')->distinct()->orderBy('features_fuel_type')->pluck('features_fuel_type');
    $gears     = CarListingModel::select('features_gear')->distinct()->orderBy('features_gear')->pluck('features_gear');
    $doors     = CarListingModel::select('features_door')->distinct()->orderby('features_door', 'asc')->pluck('features_door');
    $cylinders = CarListingModel::select('features_cylinders')->distinct()->orderby('features_cylinders', 'asc')->pluck('features_cylinders');
    $colors    = CarListingModel::select('car_color')->distinct()->orderby('car_color', 'asc')->pluck('car_color');

     $brands = CarBrand::select('id', 'name')
        ->whereHas('cars')
        ->withCount('cars')
        ->having('cars_count', '>', 2)
        ->orderBy('name')
        ->get();
    // Return view
    return view('cars.index', compact(
        'carlisting', 'cities', 'makes', 'models', 'years',
        'bodyTypes', 'regionalSpecs', 'minPrice', 'maxPrice',
        'fueltypes', 'gears', 'doors', 'cylinders', 'colors', 'conditions','brands'
    ));
}



    public function create()
    {
        $brands        = CarBrand::pluck('name')->toArray();
        $bodyTypes = collect(BodyType::pluck('name'));
        $regionalSpecs = RegionalSpec::pluck('name')->toArray();
        $colors        = Color::get();

        return view('cars.create', compact('brands', 'bodyTypes', 'regionalSpecs', 'colors'));
    }

public function store(Request $request)
{
    try {
        // Required specifications
        $requiredSpecs = ['gear', 'mileage', 'color', 'warranty', 'fuelType', 'seats'];
        $missingSpecs = array_filter($requiredSpecs, fn($spec) => empty($request->input($spec)));

        if (!empty($missingSpecs)) {
            return redirect()->back()
                             ->with('spec_error', 'Please fill all specifications')
                             ->withInput();
        }

        $car = new CarListingModel();

        // Basic details
        $car->user_id               = $request->user_id;
        $car->listing_type          = $request->make;
        $car->listing_model         = $request->model;
        $car->listing_year          = $request->year;
        $car->body_type             = $request->bodyType;
        $car->regional_specs        = $request->regionalSpec;
        $car->city                  = $request->city ?? auth()->user()->city ?? null;
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
        $car->listing_desc          = $request->description;

        // Features Others
        $features = $request->features ?? '';
        $featuresArray = array_filter(array_map('trim', explode(',', $features)));
        $car->features_others = json_encode($featuresArray);

        // Location
        $car->location = $request->location ?? null;
        $car->lat = $request->latitude ?: null;
        $car->lng = $request->longitude ?: null;

        $car->max = 10;
        $car->save();

        // Upload Images
        if ($request->hasFile('images')) {
            $i = 1;
            foreach ($request->file('images') as $index => $uploadedImage) {
                if ($index >= $car->max) break;

                $imgName = time() . '_' . $index . '.' . $uploadedImage->getClientOriginalExtension();
                $path = $uploadedImage->storeAs('listings', $imgName, 'r2');

                // Save in images table
                $car->images()->create(['image' => $path]);

                // Save first 5 images in carlisting columns
                if ($i <= 5) {
                    $column = "listing_img{$i}";
                    $car->$column = $path;
                    $i++;
                }
            }

            $car->current = $car->images()->count();
            $car->save();
        }

        return redirect()->route('car.detail', $car->id)
                         ->with('success', 'Car added successfully');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
}





public function edit(CarListingModel $car)
{
    $brands        = CarBrand::pluck('name')->toArray(); // array من أسماء الماركات
    $bodyTypes     = BodyType::pluck('name');            // Collection زي ما هي
    $bodyTypesArray = $bodyTypes->toArray();            // نسخة array للـ Blade فقط
    $regionalSpecs = RegionalSpec::pluck('name')->toArray();
    $colors        = Color::get();

    return view('cars.edit', compact('car', 'brands', 'bodyTypes', 'bodyTypesArray', 'regionalSpecs', 'colors'));
}



public function update(Request $request, CarListingModel $car)
{
    try {
        // ✅ Validate required specs
        $requiredSpecs = ['gear', 'mileage', 'color', 'warranty', 'fuelType', 'seats'];
        $missingSpecs = array_filter($requiredSpecs, fn($spec) => empty($request->input($spec)));

        if (!empty($missingSpecs)) {
            return redirect()->back()
                             ->with('spec_error', 'Please fill all specifications')
                             ->withInput();
        }

        // ✅ Update car basic info
        $car->listing_type          = $request->make;
        $car->listing_model         = $request->model;
        $car->listing_year          = $request->year;
        $car->body_type             = $request->bodyType;
        $car->regional_specs        = $request->regionalSpec;
        $car->city                  = auth()->user()->city ?? null;
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
        $car->listing_desc          = $request->description;

        // ✅ Features Others (تصحيح الـ JSON)
        $features = $request->features ?? '[]';

        // إذا كانت string، حاول تحويلها لـ array
        if (is_string($features)) {
            $features = json_decode($features, true);
        }

        // تأكد إنها array
        if (!is_array($features)) {
            $features = [];
        }

        // إزالة الفراغات والعناصر الفارغة
        $features = array_filter(array_map('trim', $features));

        $car->features_others = json_encode($features);

        $car->save();

        // ✅ Handle images

        // 1. Delete images that are not in existing_images[]
        $existingImageIds = $request->input('existing_images', []); // IDs of images to keep
        $imagesToDelete = $car->images()->whereNotIn('id', $existingImageIds)->get();

        foreach ($imagesToDelete as $img) {
            Storage::disk('r2')->delete($img->image);
            $img->delete();
        }

        // 2. Upload new images
        if ($request->hasFile('images')) {
            $currentCount = $car->images()->count();
            $maxImages = 8;
            $remainingSlots = $maxImages - $currentCount;

            $i = 1;
            foreach ($request->file('images') as $index => $uploadedImage) {
                if ($index >= $remainingSlots) break;

                $imgName = time() . '_' . $index . '.' . $uploadedImage->getClientOriginalExtension();
                $path = $uploadedImage->storeAs('listings', $imgName, 'r2');

                $car->images()->create(['image' => $path]);

                if ($i <= 5) {
                    $column = "listing_img{$i}";
                    $car->$column = $path;
                    $i++;
                }
            }
        }

        $car->current = $car->images()->count();
        $car->save();

        return redirect()->route('car.detail', $car->id)
                         ->with('success', 'Car updated successfully');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
}




public function destroy(CarListingModel $car)
{
    // Delete all images from storage
    foreach ($car->images as $image) {
        Storage::disk('r2')->delete($image->image);
    }

    $car->images()->delete();
    $car->delete();

    return redirect()->route('myCarListing')->with('success', 'Car deleted successfully');
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
    $user = auth()->user();
    $carlisting = $user->cars()->with('images')->latest()->get();

    return view('cars.my_listings', compact('carlisting'));
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
