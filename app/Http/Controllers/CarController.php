<?php
namespace App\Http\Controllers;

use App\Models\BodyType;
use App\Models\CarBrand;
use App\Models\CarListingModel;
use App\Models\Color;
use App\Models\RegionalSpec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
        $requiredSpecs = ['gear', 'mileage', 'color', 'warranty', 'fuelType', 'seats'];
        $errors = [];

        // Validate required specs
 foreach ($requiredSpecs as $spec) {
    $value = $request->input($spec);
    if ($value === null || $value === '') {
        $errors[$spec] = ucfirst($spec) . ' is required.';
    }
}


        // Validate location
        if (empty($request->input('location')) || empty($request->input('latitude')) || empty($request->input('longitude'))) {
            $errors['location'] = 'Please select a location on the map.';
        }

        // Validate title + phone
        if (empty($request->input('name'))) {
            $errors['name'] = 'Name is required.';
        }
        if (empty($request->input('phone'))) {
            $errors['phone'] = 'Phone is required.';
        }

        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'errors' => $errors
            ]);
        }

        // -----------------------------------------
        // ✅ CREATE CAR
        // -----------------------------------------
        $car = new CarListingModel();
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
        $car->features_door         = $request->door;


        // Save features_others
        $features = $request->features ?? '';
        $car->features_others = json_encode(
            array_filter(array_map('trim', explode(',', $features)))
        );

        $car->location = $request->location;
        $car->lat      = $request->latitude;
        $car->lng      = $request->longitude;

        $car->max = 10;
        $car->save();


        // -----------------------------------------
        // ✅ HANDLE IMAGES (same as UPDATE)
        // -----------------------------------------
        if ($request->hasFile('images')) {

            $maxImages = 8;
            $images = $request->file('images');
            $images = array_slice($images, 0, $maxImages);

            $i = 1;
            foreach ($images as $index => $uploadedImage) {

                // Store image in Cloudflare R2
                $imgName = time() . '_' . $index . '.' . $uploadedImage->getClientOriginalExtension();
                $path = $uploadedImage->storeAs('listings', $imgName, 'r2');

                // Save image relation
                $car->images()->create(['image' => $path]);

                // First 5 go to listing_img1..5
                if ($i <= 5) {
                    $column = "listing_img{$i}";
                    $car->$column = $path;
                    $i++;
                }
            }
        }

        // Update current image count
        $car->current = $car->images()->count();
        $car->save();

        return response()->json([
            'success' => true,
            'car_id'  => $car->id
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'errors' => ['general' => $e->getMessage()]
        ]);
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
        $errors = [];

        // ✅ Validate required specifications
        $requiredSpecs = ['gear', 'mileage', 'color', 'warranty', 'fuelType', 'seats'];
   foreach ($requiredSpecs as $spec) {
    $value = $request->input($spec);
    if ($value === null || $value === '') {
        $errors[$spec] = ucfirst($spec) . ' is required.';
    }
}


        // ✅ Individual validation for Location
        if (empty($request->input('location')) || empty($request->input('latitude')) || empty($request->input('longitude'))) {
            $errors['location'] = 'Please select a location on the map.';
        }

        // ✅ Validate basic fields
        if (empty($request->input('name'))) {
            $errors['name'] = 'Name is required.';
        }
        if (empty($request->input('phone'))) {
            $errors['phone'] = 'Phone is required.';
        }

        // Return errors if any
        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'errors' => $errors
            ]);
        }

        // ✅ Update car data
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
        $car->listing_desc          = $request->description;
        $car->location              = $request->location;
        $car->lat                   = $request->latitude;
        $car->lng                   = $request->longitude;
        $car->features_door         = $request->door;

        // ✅ Handle features_others
        $features = $request->features ?? [];
        if (is_string($features)) {
            $features = json_decode($features, true) ?: [];
        }
        $features = array_filter(array_map('trim', $features));
        $car->features_others = json_encode($features);

        $car->save();

        // ✅ Handle images
        $existingImageIds = $request->input('existing_images', []);
        $imagesToDelete = $car->images()->whereNotIn('id', $existingImageIds)->get();

        foreach ($imagesToDelete as $img) {
            Storage::disk('r2')->delete($img->image);
            $img->delete();
        }

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

        return response()->json([
            'success' => true,
            'car_id' => $car->id,
            'message' => 'Car updated successfully'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'errors' => ['general' => 'Something went wrong. Please try again.']
        ]);
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
    // ... جلب السيارات ($cars) ...
    $cars = CarlistingModel::with(['user', 'images'])
        ->orderBy('id', 'desc')
        ->paginate(9);
        
    // ... معالجة الصور ...

    // 🚨 الخطوة الحاسمة: جلب وتمرير $favCars
    if (auth()->check()) {
        $favCars = auth()->user()->favCars()->pluck('id')->toArray();
    } else {
        $favCars = []; // قائمة فارغة إذا لم يسجل دخول
    }
    
    return response()->json([
        // تمرير $favCars ضمن الـView
        'cars' => view('partials.car_card', compact('cars', 'favCars'))->render(),
    ]);
}

 // app/Http/Controllers/YourController.php

public function addTofav(Request $request, $carId)
{
    // التأكد من تسجيل الدخول
    if (!auth()->check()) {
        return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
    }
    
    // 🚨 الخطوة 1: تسجيل الـID لنرى هل تم استقباله
    \Log::info("Attempting to toggle favorite for Car ID: " . $carId);

    $user = auth()->user();
    $carId = (int) $carId; 
    
    try {
        // 2. تنفيذ العملية ومحاولة التقاط النتيجة
        $result = $user->favCars()->toggle($carId);
        
        // 3. التحقق من الحالة الجديدة
        $isAdded = !empty($result['attached']); 

        // 🚨 الخطوة 2: تسجيل نتيجة العملية في اللوغ
        \Log::info("Toggle result for Car ID {$carId}: " . json_encode($result));

        // 4. الرد بنجاح
        return response()->json([
            'success' => true,
            'is_favorite' => $isAdded,
            'car_id' => $carId
        ]);

    } catch (\Exception $e) {
        // 🚨 الخطوة 3: تسجيل أي خطأ غير متوقع
        \Log::error("Favorite Toggle Error: " . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Database error'], 500);
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
