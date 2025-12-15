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
    $spareParts = SparePart::where('user_id', $user->id)->get();

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
    $brandModels = CarListingModel::select('listing_type', 'listing_model')
        ->whereNotNull('listing_type')
        ->whereNotNull('listing_model')
        ->get()
        ->groupBy(function($item) {
            return strtolower(trim($item->listing_type));
        })
        ->map(function ($group) {
            return $group->pluck('listing_model')->unique()->values();
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
    /* -----------------------------------------------
     | 1) VALIDATION
     ----------------------------------------------- */
    $validated = $request->validate([
        'brand'       => 'required|string',
        'model'       => 'required|array',
        'model.*'     => 'string',
        'year'        => 'required|array',
        'year.*'      => 'string',
        'city'        => 'required|string',
        'part_type'   => 'required|string|in:New,Used',
        'vin_number'  => 'nullable|string',
        'category'    => 'required|integer',
    ]);

    /* -----------------------------------------------
     | 2) CATEGORY
     ----------------------------------------------- */
    $category = SparepartCategory::find($validated['category']);
    $categoryName = $category ? $category->name : '';

    /* -----------------------------------------------
     | 3) CREATE SPARE PART
     ----------------------------------------------- */
    $sparePart = new SparePart();
    $sparePart->brand = $validated['brand'];

    /* =================================================
     | MODELS (SELECT ALL FIXED)
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
        $models = array_filter(
            $models,
            fn ($m) => $m !== 'select_all_models'
        );
    }

    $sparePart->car_model = json_encode(array_values($models));

    /* =================================================
     | YEARS (MATCHES FORM RANGE EXACTLY)
     ================================================= */
    $years = $validated['year'];

    if (in_array('select_all_years', $years)) {

        // SAME YEARS AS FORM
        $currentYear = date('Y') + 1;
        $years = range($currentYear, 1984);

    } else {
        $years = array_filter(
            $years,
            fn ($y) => $y !== 'select_all_years'
        );
    }

    $sparePart->year = json_encode(array_values($years));

    /* -----------------------------------------------
     | OTHER FIELDS
     ----------------------------------------------- */
    $sparePart->city        = $validated['city'];
    $sparePart->part_type   = $validated['part_type'];
    $sparePart->vin_number  = $validated['vin_number'] ?? null;
    $sparePart->category_id = $validated['category'];

    /* -----------------------------------------------
     | TITLE
     ----------------------------------------------- */
    $sparePart->title = $validated['brand']
        . ($categoryName ? " - {$categoryName}" : '');

    $sparePart->user_id = auth()->id();
    $sparePart->save();

    /* -----------------------------------------------
     | REDIRECT
     ----------------------------------------------- */
    return redirect()
        ->route('spareparts.dashboard')
        ->with('success', 'Spare part has been added successfully!');
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
    try {

        /* -----------------------------------------------
         | 1) FIND SPARE PART
         ----------------------------------------------- */
        $sparePart = SparePart::findOrFail($id);

        /* -----------------------------------------------
         | 2) VALIDATION
         ----------------------------------------------- */
        $validated = $request->validate([
            'brand'       => 'required|string',
            'model'       => 'nullable|array',
            'model.*'     => 'string',
            'year'        => 'nullable|array',
            'year.*'      => 'string',
            'city'        => 'required|string',
            'part_type'   => 'required|string|in:New,Used',
            'vin_number'  => 'nullable|string',
            'category'    => 'required|integer',
        ]);

        /* -----------------------------------------------
         | 3) CATEGORY & BRAND
         ----------------------------------------------- */
        $category = SparepartCategory::find($validated['category']);
        $categoryName = $category ? $category->name : '';

        $sparePart->brand = $validated['brand'];
        $sparePart->category_id = $validated['category'];

        /* =================================================
         | 4) MODELS (ONLY IF SENT)
         ================================================= */
        if ($request->filled('model')) {

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
                $models = array_filter(
                    $models,
                    fn ($m) => $m !== 'select_all_models'
                );
            }

            $sparePart->car_model = json_encode(array_values($models));
        }

        /* =================================================
         | 5) YEARS (ONLY IF SENT)
         ================================================= */
        if ($request->filled('year')) {

            $years = $validated['year'];

            if (in_array('select_all_years', $years)) {

                $currentYear = date('Y') + 1;
                $years = range($currentYear, 1984);
                $years = array_map('strval', $years);

            } else {
                $years = array_filter(
                    $years,
                    fn ($y) => $y !== 'select_all_years'
                );
            }

            $sparePart->year = json_encode(array_values($years));
        }

        /* -----------------------------------------------
         | 6) OTHER FIELDS
         ----------------------------------------------- */
        $sparePart->city       = $validated['city'];
        $sparePart->part_type = $validated['part_type'];
        $sparePart->vin_number = $validated['vin_number'] ?? null;

        /* -----------------------------------------------
         | 7) TITLE
         ----------------------------------------------- */
        $sparePart->title =
            $validated['brand'] . ($categoryName ? " - $categoryName" : '');

        /* -----------------------------------------------
         | 8) SAVE
         ----------------------------------------------- */
        $sparePart->save();

        return redirect()
            ->route('spareparts.dashboard')
            ->with('success', 'Spare part updated successfully!');

    } catch (\Throwable $e) {

        // 🔴 ده هيوريك الايرور الحقيقي
        dd([
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ]);
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