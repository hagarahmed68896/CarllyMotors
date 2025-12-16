<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BodyType;
use App\Models\CarBrand;
use App\Models\CarListingModel;
use App\Models\Color;
use App\Models\RegionalSpec;
use Illuminate\Support\Facades\Storage;
class CarsProviderController extends Controller
{

    public function login()
{
    // لو أي يوزر مسجل دخول
    if (auth()->check()) {

        // جلب نوع اليوزر من جدول allusers
        $user = auth()->user(); // أو حسب الـ model اللي مربوط بالجدول allusers
        $userType = $user->usertype; // افترضنا إن العمود اسمه 'usertype'

        if ($userType === 'dealer') {
            // لو اليوزر provider → روح للـ dashboard الخاص بالـ provider
            return redirect()->route('cars.dashboard');
        } else {
            // لو user من نوع مختلف → اعمل logout
            auth()->logout();
            session()->flush();
            return redirect()->route('providers.cars.login'); // صفحة login للـ provider
        }
    }

    // لو مش مسجل دخول → عرض صفحة login للـ provider
    return view('providers.cars.login');
}


    // لوحة تحكم مزود السيارات
public function index() {
    // Default redirect to Used/New cars
    return redirect()->route('my.cars', ['carType' => 'used']);
}

public function myCarListing(Request $request, $carType = 'used')
{
    $user = auth()->user();

    $carlisting = $user->cars()
        ->with('images')
        ->where('car_type', $carType)
        ->latest()
        ->paginate(12); // عدل الرقم حسب التصميم

    return view('providers.cars.dashboard', compact('carlisting', 'carType'));
}

public function create($type)
{
    $brands        = CarBrand::pluck('name')->toArray();
    $bodyTypes     = BodyType::pluck('name');
    $regionalSpecs = RegionalSpec::pluck('name')->toArray();
    $colors        = Color::get();

    return view('providers.cars.create', compact('brands', 'bodyTypes', 'regionalSpecs', 'colors', 'type'));
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
     if (empty($request->input('contact_number'))) {
    $errors['contact_number'] = 'Contact Number is required.';
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
        // Phone info
        $car->contact_number        = $request->contact_number;   // رقم التواصل الخاص بالإعلان
        $car->wa_number             = $request->wa_number;        // رقم الواتساب الخاص بالإعلان
        $car->listing_price         = $request->price;
        $car->listing_desc          = $request->description;
        $car->features_door         = $request->door;
        // ✅ New: car type
        $car->car_type              = $request->input('car_type', 'used'); 


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

    return view('providers.cars.edit', compact('car', 'brands', 'bodyTypes', 'bodyTypesArray', 'regionalSpecs', 'colors'));
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
         if (empty($request->input('contact_number'))) {
    $errors['contact_number'] = 'Contact Number is required.';
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
        // Phone info
        $car->contact_number        = $request->contact_number;   // رقم التواصل الخاص بالإعلان
        $car->wa_number             = $request->wa_number;          $car->listing_price         = $request->price;
        $car->listing_desc          = $request->description;
        $car->location              = $request->location;
        $car->lat                   = $request->latitude;
        $car->lng                   = $request->longitude;
        $car->features_door         = $request->door;
        $car->car_type              = $request->input('car_type', 'used'); 


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

 public function detail($id)
    {
        // Decrypt the ID
        // $id = Crypt::decrypt($id);

        // Convert listing_modal back to original format
        // $formattedModal = str_replace('-', ' ', $slug);

        // Find the car
        $car = CarListingModel::where('id', $id)->with('user')->firstOrFail();
        $recommendedCars = CarListingModel::where('listing_type', $car->listing_type)
            ->where(function ($query) use ($car) {
                $query->where('listing_model', $car->listing_model)
                    ->orWhere('car_type', $car->car_type);
            })
            ->whereBetween('listing_price', [$car->listing_price - 2000, $car->listing_price + 2000])
            ->where('id', '!=', $car->id)
            ->take(5)
            ->get();

        $images = [];
        foreach ($car->images as $image) {
            $path = $image->image;
            if (Storage::disk('r2')->exists($path)) {
                $images[] = Storage::disk('r2')->url($path);
            }
        }

        return view('providers.cars.show', compact('car', 'recommendedCars', 'images'));
    }

}
