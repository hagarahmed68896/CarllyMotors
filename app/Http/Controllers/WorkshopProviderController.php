<?php

namespace App\Http\Controllers;

use App\Models\CarBrand; 
use Illuminate\Http\Request;
use App\Models\WorkshopDay;
use Illuminate\Support\Facades\Storage;
use App\Models\WorkshopProvider;
use DB;
use App\Models\WorkshopCategory;

class WorkshopProviderController extends Controller
{
       public function login()
{
    // لو أي يوزر مسجل دخول
    if (auth()->check()) {

        // جلب نوع اليوزر من جدول allusers
        $user = auth()->user(); // أو حسب الـ model اللي مربوط بالجدول allusers
        $userType = $user->usertype; // افترضنا إن العمود اسمه 'usertype'

        if ($userType === 'workshop_provider') {
            // لو اليوزر provider → روح للـ dashboard الخاص بالـ provider
            return redirect()->route('workshops.dashboard');
        } else {
            // لو user من نوع مختلف → اعمل logout
            auth()->logout();
            session()->flush();
            return redirect()->route('providers.workshops.login'); // صفحة login للـ provider
        }
    }

    // لو مش مسجل دخول → عرض صفحة login للـ provider
    return view('providers.workshops.login');
}
public function index() {
    $user = auth()->user();

    // Get the workshop linked to the user
    $workshop = $user->workshop_provider;

    if (!$workshop) {
        return redirect()->back()->with('error', 'No workshop found for this user.');
    }

    return view('providers.workshops.dashboard', compact('workshop'));
}




 public function myWorkshop(Request $request)
{
    $user = auth()->user();

    // نجيب الورشة المرتبطة باليوزر
    $workshop = $user->workshop_provider;

    if (!$workshop) {
        return redirect()->back()->with('error', 'No workshop found for this user.');
    }

    // ⭐ Load all categories
    $categories = \App\Models\WorkshopCategory::latest('id')->get();

    // ⭐ Load all car brands
    $brands = CarBrand::orderBy('name')->get();

    // ⭐ Load selected brands for this workshop
    $selectedBrands = $workshop->brands->map(function($b) {
        return ['id' => $b->id, 'name' => $b->name];
    });

    // ⭐ Load working days
    $workingDaysRecords = WorkshopDay::where('workshop_provider_id', $workshop->id)->get();

    $saved_days_for_js = $workingDaysRecords->mapWithKeys(function ($item) {
        return [
            $item->day => [
                'from' => $item->from,
                'to' => $item->to,
            ]
        ];
    })->toArray();

    return view('providers.workshops.my_workshop', compact(
        'workshop',
        'categories',
        'brands',
        'selectedBrands',
        'saved_days_for_js'
    ));
}


  public function update(Request $request, $id)
{
    $workshop = \App\Models\WorkshopProvider::findOrFail($id);

    if ($workshop->user_id != auth()->id()) {
        return back()->with('error', 'Unauthorized');
    }

$request->validate([
    'workshop_name' => 'required|string|max:255',
    'owner' => 'nullable|string|max:255',
    'employee' => 'nullable|string|max:255',
    'tax_number' => 'nullable|string|max:255',
    'whatsapp_number' => 'required|string|max:20',

    // brands
    'brands' => 'required|array|min:1',
    'brands.*' => 'exists:car_brands,id',

    // categories (اسمك الحقيقي)
    'workshop_categories' => 'required|array|min:1',
    'workshop_categories.*' => 'exists:workshop_categories,id',

    // working days (hidden json)
    'working_days' => 'required',
]);


    // -------------------------------
    // UPDATE BASIC INFO
    // -------------------------------
    $workshop->update([
        'workshop_name'       => $request->workshop_name,
        'owner'               => $request->owner,
        'employee'            => $request->employee,
        'tax_number'          => $request->tax_number,
        'whatsapp_number'     => $request->whatsapp_number,
        // 'workshop_categories' => implode(',', $request->workshop_categories ?? []),
        'latitude'            => auth()->user()->lat,
        'longitude'           => auth()->user()->lng,
        'branch'              => auth()->user()->city,
    ]);

    // -------------------------------
    // HANDLE SELECTED BRANDS
    // -------------------------------
    $brandIds = $request->input('brands', []);
    $workshop->brands()->sync($brandIds);

    // -------------------------------
    // HANDLE SELECTED CATEGORIES
    // -------------------------------
   
$categoryIds = $request->input('workshop_categories', []); // fallback to empty array
$workshop->categories()->sync($categoryIds);

    // -------------------------------
    // HANDLE WORKING DAYS
    // -------------------------------
    $workingDays = $request->input('working_days');

    if (is_string($workingDays)) {
        $workingDays = json_decode($workingDays, true);
    }

    $workshop->days()->delete();

    if (is_array($workingDays)) {
        foreach ($workingDays as $key => $day) {
            if (!isset($day['day']) && isset($day['from']) && isset($day['to'])) {
                $day = [
                    'day'  => $key,
                    'from' => $day['from'],
                    'to'   => $day['to'],
                ];
            }

            if (!empty($day['day']) && !empty($day['from']) && !empty($day['to'])) {
                WorkshopDay::create([
                    'workshop_provider_id' => $workshop->id,
                    'day'                  => $day['day'],
                    'from'                 => $day['from'],
                    'to'                   => $day['to'],
                ]);
            }
        }
    }
     // ✅ Handle images
        $existingImageIds = $request->input('existing_images', []);
        $imagesToDelete = $workshop->images()->whereNotIn('id', $existingImageIds)->get();

        foreach ($imagesToDelete as $img) {
            Storage::disk('r2')->delete($img->image);
            $img->delete();
        }

        if ($request->hasFile('images')) {
            $currentCount = $workshop->images()->count();
            $maxImages = 8;
            $remainingSlots = $maxImages - $currentCount;

            $i = 1;
            foreach ($request->file('images') as $index => $uploadedImage) {
                if ($index >= $remainingSlots) break;

                $imgName = time() . '_' . $index . '.' . $uploadedImage->getClientOriginalExtension();
                $path = $uploadedImage->storeAs('workshops', $imgName, 'r2');

                $workshop->images()->create(['image' => $path]);

                if ($i <= 5) {
                    $column = "listing_img{$i}";
                    $workshop->$column = $path;
                    $i++;
                }
            }
        }

        $workshop->current = $workshop->images()->count();

    return back()->with('success', 'Workshop updated successfully!');
}


 public function show(WorkshopProvider $workshop)
{
    // ✅ Fetch cities (for filter sidebar, if needed)
    $cities = WorkshopProvider::select('branch')
        ->distinct()
        ->orderBy('branch')
        ->pluck('branch');

    // ✅ Fetch related brands for this workshop
    $brandIds = DB::table('car_brand_workshop_provider')
        ->where('workshop_provider_id', $workshop->id)
        ->pluck('car_brand_id')
        ->toArray();

    $brands = CarBrand::whereIn('id', $brandIds)
        ->pluck('name')
        ->toArray();

    // ✅ Fetch related categories
    $categoryIds = DB::table('workshop_category_provider')
        ->where('workshop_provider_id', $workshop->id)
        ->pluck('workshop_category_id')
        ->toArray();

    $categories = WorkshopCategory::whereIn('id', $categoryIds)
        ->pluck('name')
        ->toArray();

    // ✅ Fetch related workshops in the same city (exclude current)
    $relatedWorkshops = WorkshopProvider::where('id', '!=', $workshop->id)
        ->where('branch', $workshop->branch)
        ->take(6)
        ->get();

    // ✅ Fetch images for the workshop
    $images = \App\Models\Image::where('workshop_provider_id', $workshop->id)
        ->pluck('image')
        ->toArray();

    // ✅ Prepare working days (if you have a relation or table for that)
    $days = [];
    if (method_exists($workshop, 'days')) {
        $days = $workshop->days()
            ->orderByRaw("FIELD(day, 'Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday')")
            ->get(['day', 'from', 'to']);
    }

    // ✅ Return view
    return view('providers.workshops.show', compact(
        'workshop',
        'cities',
        'brands',
        'categories',
        'relatedWorkshops',
        'images',
        'days'
    ));
}



    public function updateLocation(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'details' => 'nullable|string',
            'city' => 'nullable|string',
        ]);

        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Update User
        $user->update([
            'lat' => $request->lat,
            'lng' => $request->lng,
            'city' => $request->city ?? $user->city,
            'location' => $request->details ?? $user->location,
        ]);

        // Update WorkshopProvider if exists
        $workshop = $user->workshop_provider;
        if ($workshop) {
            $workshop->update([
                'latitude' => $request->lat,
                'longitude' => $request->lng,
                'branch' => $request->city ?? $workshop->branch,
                'address' => $request->details ?? $workshop->address,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Location updated successfully!']);
    }
}