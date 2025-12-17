<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarBrand;
use App\Models\CarDealer;
use App\Models\SparePart;
use App\Models\SparepartCategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\CarListingModel;


class SparepartsProviderController extends Controller
{
    
    public function login()
{
    // لو أي يوزر مسجل دخول
    if (auth()->check()) {

        // جلب نوع اليوزر من جدول allusers
        $user = auth()->user(); // أو حسب الـ model اللي مربوط بالجدول allusers
        $userType = $user->usertype; // افترضنا إن العمود اسمه 'usertype'

        if ($userType === 'shop_dealer') {
            // لو اليوزر provider → روح للـ dashboard الخاص بالـ provider
            return redirect()->route('spareparts.dashboard');
        } else {
            // لو user من نوع مختلف → اعمل logout
            auth()->logout();
            session()->flush();
            return redirect()->route('providers.spareparts.login'); // صفحة login للـ provider
        }
    }

    // لو مش مسجل دخول → عرض صفحة login للـ provider
    return view('providers.spareParts.login');
}

public function index() {
    $user = auth()->user();

    // Get spare parts that belong to this user
    $spareParts = SparePart::where('user_id', $user->id)->latest()
    ->paginate(12);


    // Optional: if you want the shop info as well
    $sparepartsShop = $user->dealer; // if you have a dealer relationship

    if (!$sparepartsShop) {
        return redirect()->back()->with('error', 'No spare parts shop found for this user.');
    }

    return view('providers.spareParts.dashboard', compact('sparepartsShop', 'spareParts'));
}


public function create()
{
    /* -----------------------------------------------
    | 1) MAIN & SUB CATEGORIES
    ----------------------------------------------- */
    $mainCategories = DB::table('sparepart_categories')
        ->whereNull('parent_id')
        ->get();

    $subCategories = DB::table('sparepart_categories')
        ->whereNotNull('parent_id')
        ->get();

    foreach ($mainCategories as $cat) {
        $cat->subcategories = $subCategories->where('parent_id', $cat->id)->values();
    }

    /* -----------------------------------------------
    | 2) CITIES (زي index)
    ----------------------------------------------- */
$cities = CarListingModel::select('city')
    ->whereNotNull('city')
    ->where('city', '!=', '')
    ->where('city', '!=', 'null')  // ← أهم شرط
    ->distinct()
    ->orderBy('city')
    ->pluck('city');

    /* -----------------------------------------------
    | 3) CONDITIONS
    ----------------------------------------------- */
    $conditions = CarListingModel::select('car_type')
        ->distinct()
        ->orderBy('car_type')
        ->pluck('car_type');

    /* -----------------------------------------------
    | 4) MAKES (BRANDS)
    ----------------------------------------------- */
    $makes = CarListingModel::select('listing_type')
        ->distinct()
        ->orderBy('listing_type')
        ->pluck('listing_type');

    $sortedMakes = collect($makes)->sort()->values();

    /* -----------------------------------------------
    | 5) MODELS (زي index)
    ----------------------------------------------- */
  // BRAND → MODELS RELATIONS
  $brandModels = DB::table('brand_models')
    ->join('car_brands', 'brand_models.brand_id', '=', 'car_brands.id')
    ->select('brand_models.name as model_name', 'car_brands.name as brand_name')
    ->get()
    ->groupBy(function ($item) {
        // بنحول اسم الماركة لـ lowercase عشان يطابق الـ JavaScript اللي عندك
        return strtolower(trim($item->brand_name));
    })
    ->map(function ($group) {
        // بنجيب أسماء الموديلات فقط وبنمسح التكرار
        return $group->pluck('model_name')->unique()->values();
    });


    /* -----------------------------------------------
    | 6) YEARS (زي index)
    ----------------------------------------------- */
    $years = CarListingModel::select('listing_year')
        ->distinct()
        ->orderBy('listing_year', 'desc')
        ->pluck('listing_year');

    /* -----------------------------------------------
    | 7) RETURN VIEW
    ----------------------------------------------- */
    return view('providers.spareParts.create', compact(
        'mainCategories',
        'cities',
        'conditions',
        'sortedMakes',
        'years',
        'brandModels'
    ));
}

public function store(Request $request)
{
    // 1. التحقق من البيانات (خارج الـ try-catch)
    // إذا فشل التحقق، سيقوم Laravel تلقائياً بالتحويل للخلف مع رسائل الخطأ
    $validated = $request->validate([
        'brand'       => 'required|string',
        'model'       => 'required|array|min:1',
        'model.*'     => 'string',
        'year'        => 'required|array|min:1',
        'year.*'      => 'string',
        'city'        => 'required|string',
        'part_type'   => 'required|string|in:New,Used',
        'vin_number'  => $request->part_type === 'New' ? 'required|string' : 'nullable|string',
        'category'    => 'required|integer|exists:sparepart_categories,id',
    ], [
        // رسائل مخصصة اختيارية لجعل التنبيهات أوضح للمستخدم
        'model.required' => 'Please select at least one car model.',
        'year.required'  => 'Please select at least one year.',
        'vin_number.required' => 'VIN Number is required for new parts.',
    ]);

    try {
        /* -----------------------------------------------
         | 2) CATEGORY NAME (للـ Title)
         ----------------------------------------------- */
        $category = SparepartCategory::find($validated['category']);
        $categoryName = $category ? $category->name : '';

        /* -----------------------------------------------
         | 3) INITIALIZE OBJECT
         ----------------------------------------------- */
        $sparePart = new SparePart();
        $sparePart->user_id = auth()->id();
        $sparePart->brand = $validated['brand'];
        $sparePart->category_id = $validated['category'];

        /* =================================================
         | 4) MODELS LOGIC
         ================================================= */
        $models = $validated['model'];
        if (in_array('select_all_models', $models)) {
            $brandName = strtolower(trim($validated['brand']));
            $models = CarListingModel::whereNotNull('listing_model')
                ->whereRaw('LOWER(TRIM(listing_type)) = ?', [$brandName])
                ->pluck('listing_model')
                ->unique()
                ->values()
                ->toArray();
        } else {
            $models = array_filter($models, fn($m) => $m !== 'select_all_models');
        }
        $sparePart->car_model = json_encode(array_values($models));

        /* =================================================
         | 5) YEARS LOGIC
         ================================================= */
        $years = $validated['year'];
        if (in_array('select_all_years', $years)) {
            $currentYear = date('Y') + 1;
            $years = range($currentYear, 1984);
            $years = array_map('strval', $years); // تحويل السنوات لنصوص لتوحيد النوع
        } else {
            $years = array_filter($years, fn($y) => $y !== 'select_all_years');
        }
        $sparePart->year = json_encode(array_values($years));

        /* -----------------------------------------------
         | 6) FINAL FIELDS & SAVE
         ----------------------------------------------- */
        $sparePart->city       = $validated['city'];
        $sparePart->part_type  = $validated['part_type'];
        $sparePart->vin_number = $validated['vin_number'] ?? null;
        $sparePart->title      = $validated['brand'] . ($categoryName ? " - {$categoryName}" : '');

        $sparePart->save();

        return redirect()
            ->route('spareparts.dashboard')
            ->with('success', 'Spare part has been added successfully!');

    } catch (\Exception $e) {
        // في حال حدوث خطأ في قاعدة البيانات أو السيرفر
        return back()
            ->withInput() // الحفاظ على ما كتبه المستخدم في الحقول
            ->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}


public function edit($id)
{
    $part = SparePart::findOrFail($id);

    /* نفس الأكواد الموجودة في create */

    $mainCategories = DB::table('sparepart_categories')
        ->whereNull('parent_id')
        ->get();

    $subCategories = DB::table('sparepart_categories')
        ->whereNotNull('parent_id')
        ->get();

    foreach ($mainCategories as $cat) {
        $cat->subcategories = $subCategories->where('parent_id', $cat->id)->values();
    }

    $cities = CarListingModel::select('city')
        ->whereNotNull('city')
        ->where('city', '!=', '')
        ->where('city', '!=', 'null')
        ->distinct()
        ->orderBy('city')
        ->pluck('city');

    $conditions = CarListingModel::select('car_type')
        ->distinct()
        ->orderBy('car_type')
        ->pluck('car_type');

    $makes = CarListingModel::select('listing_type')
        ->distinct()
        ->orderBy('listing_type')
        ->pluck('listing_type');

    $sortedMakes = collect($makes)->sort()->values();

    $brandModels = CarListingModel::select('listing_type', 'listing_model')
        ->whereNotNull('listing_type')
        ->whereNotNull('listing_model')
        ->get()
        ->groupBy(fn($i) => strtolower(trim($i->listing_type)))
        ->map(fn($g) => $g->pluck('listing_model')->unique()->values());

    $years = CarListingModel::select('listing_year')
        ->distinct()
        ->orderBy('listing_year', 'desc')
        ->pluck('listing_year');

    return view('providers.spareParts.edit', compact(
        'part',
        'mainCategories',
        'cities',
        'conditions',
        'sortedMakes',
        'years',
        'brandModels'
    ));
}


public function update(Request $request, $id)
{
    // 1. Find the record
    $sparePart = SparePart::findOrFail($id);

    // 2. Validation (Strictly Required)
    // Note: We move this OUTSIDE the try-catch so Laravel handles errors normally
    $validated = $request->validate([
        'brand'     => 'required|string',
        'model'     => 'required|array|min:1', // Must select at least one
        'model.*'   => 'string',
        'year'      => 'required|array|min:1', // Must select at least one
        'year.*'    => 'string',
        'city'      => 'required|string',
        'part_type' => 'required|string|in:New,Used',
        'category'  => 'required|integer|exists:sparepart_categories,id',
        'vin_number'=> $request->part_type === 'New' ? 'required|string' : 'nullable|string',
    ]);

    try {
        /* -----------------------------------------------
         | 3) CATEGORY & BRAND
         ----------------------------------------------- */
        $category = SparepartCategory::find($validated['category']);
        $categoryName = $category ? $category->name : '';

        $sparePart->brand = $validated['brand'];
        $sparePart->category_id = $validated['category'];

        /* =================================================
         | 4) MODELS
         ================================================= */
        $models = $validated['model'];

        if (in_array('select_all_models', $models)) {
            $brand = strtolower(trim($validated['brand']));
            $models = CarListingModel::whereNotNull('listing_model')
                ->whereRaw('LOWER(TRIM(listing_type)) = ?', [$brand])
                ->pluck('listing_model')
                ->unique()
                ->values()
                ->toArray();
        } else {
            $models = array_filter($models, fn($m) => $m !== 'select_all_models');
        }
        $sparePart->car_model = json_encode(array_values($models));

        /* =================================================
         | 5) YEARS
         ================================================= */
        $years = $validated['year'];

        if (in_array('select_all_years', $years)) {
            $currentYear = date('Y') + 1;
            $years = range($currentYear, 1984);
            $years = array_map('strval', $years);
        } else {
            $years = array_filter($years, fn($y) => $y !== 'select_all_years');
        }
        $sparePart->year = json_encode(array_values($years));

        /* -----------------------------------------------
         | 6) OTHER FIELDS
         ----------------------------------------------- */
        $sparePart->city       = $validated['city'];
        $sparePart->part_type  = $validated['part_type'];
        $sparePart->vin_number = $validated['vin_number'] ?? null;

        /* -----------------------------------------------
         | 7) TITLE
         ----------------------------------------------- */
        $sparePart->title = $validated['brand'] . ($categoryName ? " - $categoryName" : '');

        /* -----------------------------------------------
         | 8) SAVE
         ----------------------------------------------- */
        $sparePart->save();

        return redirect()
            ->route('spareparts.dashboard')
            ->with('success', 'Spare part updated successfully!');

    } catch (\Exception $e) {
        // Only catch actual system/database errors here
        return back()
            ->withInput()
            ->with('error', 'System Error: ' . $e->getMessage());
    }
}



public function destroy($id)
{
    $sparePart = SparePart::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $sparePart->delete();

    return redirect()
        ->route('spareparts.dashboard')
        ->with('success', 'Spare part deleted successfully!');
}

}