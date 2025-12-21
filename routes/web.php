<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkshopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🚨 CRITICAL: Deep Linking Association Files - MUST be at the top
// ✅ iOS Universal Links - apple-app-site-association
Route::get('/.well-known/apple-app-site-association', function () {
    $aasa = [
        "applinks" => [
            "details" => [
                [
                    "appIDs" => [
                        "NDF299S2JC.com.carllymotors.carllyuser"
                    ],
                    "components" => [
                        [
                            "/" => "/car-listing/*",
                            "comment" => "Car listing deep links - matches /car-listing/123"
                        ],
                        [
                            "/" => "/spare-part/*",
                            "comment" => "Spare part deep links - matches /spare-part/456"
                        ],
                 
                    ]
                ]
            ]
        ],
        "webcredentials" => [
            "apps" => [
                "NDF299S2JC.com.carllymotors.carllyuser"
            ]
        ]
    ];

    return response()->json($aasa, 200, [
        'Content-Type' => 'application/json',
        'Cache-Control' => 'public, max-age=3600'
    ]);
});

// ✅ Android App Links - assetlinks.json
Route::get('/.well-known/assetlinks.json', function () {
    $assetlinks = [
        [
            "relation" => ["delegate_permission/common.handle_all_urls"],
            "target" => [
                "namespace" => "android_app",
                "package_name" => "com.carllymotors.carllyuser",
                "sha256_cert_fingerprints" => [
                    "10:45:A1:61:3A:18:5E:8B:F9:F4:67:DD:E4:15:60:8A:97:3A:62:D6:53:5A:74:55:3E:4C:7F:70:00:AB:4B:0C",
                    "DD:CE:CB:BE:5E:C5:B0:DD:77:53:7D:A0:4D:0D:AD:95:2A:60:80:09:1C:DB:00:DB:84:85:58:31:79:65:76:1D",
                    "DE:20:AD:41:6D:A7:89:0F:E7:FD:8B:5B:63:98:A5:A3:14:F0:E7:37:FE:B7:0D:7B:AB:C4:B0:D9:23:40:00:41",
                    "D2:B4:82:CC:E3:67:7A:32:D8:09:7E:6C:A4:6C:D9:1A:C6:AD:0B:EB:91:D1:C5:70:AE:30:09:4B:08:A9:7E:1E",
                    "14:7C:2E:50:8C:40:3C:94:D6:D2:25:96:49:9B:85:17:C0:F9:6F:EF:43:38:3D:11:E1:19:A0:45:F8:36:97:A8",
                    "53:99:98:30:C4:8C:28:B1:63:AA:94:76:8C:58:97:CA:F6:9F:05:27:F2:8A:CA:FA:06:9B:AF:AB:2B:ED:DB:F4",
                    "38:C0:93:44:6F:AE:2E:5C:9B:43:BE:F7:30:24:AD:95:28:30:37:DA:F2:1E:F8:8C:D4:48:B1:F7:D3:77:C6:01"
                ]
            ]
        ]
    ];

    return response()->json($assetlinks, 200, [
        'Content-Type' => 'application/json',
        'Cache-Control' => 'public, max-age=3600'
    ]);
});

//  Legacy iOS support (some older versions check this location)
Route::get('/apple-app-site-association', function () {
    return redirect('/.well-known/apple-app-site-association', 301);
});

// Static Pages
Route::get('/upcomming', fn() => view('upcomming'))->name('upcomming');
Route::get('/try', fn() => view('try'))->name('try');
Route::get('/about-us', fn() => view('aboutus'))->name('aboutus');
Route::get('/terms', fn() => view('terms'))->name('terms');
// Route::get('/privacy', fn() => view('privacy'))->name('privacy');
Route::get('/faqs', fn() => view('faqs'))->name('faqs');




Route::get('/test-apicar', function () {

    $response = Http::get('https://admin.apicar.store/home');

    return [
        'status'  => $response->status(),
        'headers' => $response->headers(),
        'body'    => substr($response->body(), 0, 500), // أول 500 حرف
    ];
});



// providers about us
Route::get('/providers/about-us', fn() => view('providers.aboutus'))->name('providers.aboutus');
Route::get('/providers/privacy', [SettingController::class, 'providerPrivacy'])->name('providers.privacy');
Route::get('/providers/terms', [SettingController::class, 'providerTerms'])->name('providers.terms');
Route::get('/providers/contact-us', [ContactController::class, 'providerIndex'])->name('providers.contacts.index');

// providers terms
// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('filters', [HomeController::class, 'filters'])->name('home.filters');
Route::get('listing', [HomeController::class, 'carListing'])->name('carlisting');
Route::get('filter-cars', [HomeController::class, 'filter'])->name('filter.cars');
Route::get('grid', [HomeController::class, 'carListing'])->name('listing.grid');
Route::get('/cars/dashboard', [\App\Http\Controllers\CarsProviderController::class, 'index'])->name('cars.dashboard');

    // لوحة التحكم حسب carType
    Route::get('/my-cars/{carType}', [\App\Http\Controllers\CarsProviderController::class, 'myCarListing'])->name('my.cars');

// Cars
Route::resource('cars', CarController::class);
Route::get('/car/{id}', [HomeController::class, 'detail'])->name('car.detail');

    Route::get('/provider/cars/create/{type}', [\App\Http\Controllers\CarsProviderController::class, 'create'])
    ->name('provider.cars.create');

    Route::post('/provider/cars/store', [\App\Http\Controllers\CarsProviderController::class, 'store'])
    ->name('provider.cars.store');
Route::get('/provider/cars/{car}/edit', [\App\Http\Controllers\CarsProviderController::class, 'edit'])
    ->name('provider.cars.edit');
// Also ensure your POST route uses {car} for consistency:
Route::put('/provider/cars/{car}/update', 
    [\App\Http\Controllers\CarsProviderController::class, 'update']
)->name('provider.cars.update');
Route::get('/provider/cars/{id}/detail', 
    [\App\Http\Controllers\CarsProviderController::class, 'detail']
)->name('provider.cars.detail');



// Route::post('/cars/addTofav/{carId}', [CarController::class, 'addTofav'])
//     ->name('cars.addTofav')
//     ->middleware('auth');
    // في ملف routes/web.php أو routes/api.php 
Route::post('/cars/{carId}/favorite', [CarController::class, 'addTofav'])->name('cars.addTofav');
Route::get('/favList', [CarController::class, 'favList'])->name('cars.favList')->middleware('auth');
Route::get('/myCarListing', [CarController::class, 'myCarListing'])->name('myCarListing')->middleware('auth');
Route::get('cars/homeSection', [CarController::class, 'homeSection'])->name('cars.homeSection');
Route::get('getModels', [CarController::class, 'getModels'])->name('getModels');
Route::get('/my-cars', [CarController::class, 'myCarListing'])->name('cars.my');

 // Edit & Update car
    Route::get('{car}/edit', [CarController::class, 'edit'])->name('car.edit');
    Route::put('{car}', [CarController::class, 'update'])->name('car.update');

    // Delete car
    Route::delete('{car}', [CarController::class, 'destroy'])->name('car.destroy');

//  Car Listing Deep Links
Route::get('/car-listing/{id}', [HomeController::class, 'detail'])->name('carlisting.detail')->where('id', '[0-9]+');
Route::get('/car-listing', [HomeController::class, 'detailFromQuery'])->name('carlisting.query');

// Spare Parts
Route::resource('spareParts', SparePartController::class);
Route::get('spareparts/homeSection', [SparePartController::class, 'homeSection'])->name('spareparts.homeSection');
Route::get('filter-sparePart', [SparePartController::class, 'filter'])->name('filter.spareParts');
Route::post('getSubCategories', [SparePartController::class, 'getSubCategories'])->name('getSubCategories');
// Route لجلب الموديلات بناءً على الماركة المختارة (Ajax)
Route::get('/get-models', [SparePartController::class, 'getModels']);

//  Spare Part Deep Links
Route::get('/spare-part/{id}', [SparePartController::class, 'show'])->name('sparepart.detail')->where('id', '[0-9]+');
Route::get('/spare-part', [SparePartController::class, 'showFromQuery'])->name('sparepart.query');

// Settings
Route::post('contact-us', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contacts.index');

// Terms and Privacy
Route::get('/terms', [SettingController::class, 'terms'])->name('terms');
Route::get('/privacy', [SettingController::class, 'privacy'])->name('privacy');

// User Authentication
Auth::routes();
Route::post('/verify-token', [AuthController::class, 'verifyToken']);
Route::get('/profile/{id}', [AuthController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/users/edit/{id}', [AuthController::class, 'edit'])->name('users.edit')->middleware('auth');
Route::put('/users/{id}', [AuthController::class, 'update'])->name('users.update')->middleware('auth');
Route::post('/users/{id}/update-image', [AuthController::class, 'updateImage'])
     ->name('users.updateImage');
// routes/web.php
Route::post('/verify-login-token', [AuthController::class, 'verifyLoginToken']);
Route::post('/check-phone-exists', function (Illuminate\Http\Request $request) {
    $exists = \App\Models\allUsersModel::where('phone', $request->phone)->exists();
    return response()->json(['exists' => $exists]);
});

// This should typically be protected by 'auth' middleware
Route::delete('/profile/{id}', [AuthController::class, 'deleteProfile'])->name('delete.profile');
// Workshops
Route::resource('workshops', WorkshopController::class)->except(['index', 'show']);

// Workshop Routes - Properly ordered for deep linking
Route::get('/workshops-list', [WorkshopController::class, 'index'])->name('workshops.index');


// ✅ Workshop Deep Links - CRITICAL ORDER: Specific routes BEFORE wildcard routes
Route::get('/workshops/my-workshops', [WorkshopController::class, 'myWorkshops'])->name('workshops.my')->middleware('auth');
Route::get('/workshops/favorites', [WorkshopController::class, 'favorites'])->name('workshops.favorites')->middleware('auth');
Route::get('/workshops/search', [WorkshopController::class, 'search'])->name('workshops.search');

// ✅ Deep Link Workshop Details (This handles /workshops/43)
Route::get('web/ws/{workshop}', [WorkshopController::class, 'show'])->name('workshops.show')->where('workshop', '[0-9]+');
// الرابط الجديد اللي يفتح ويب فقط
Route::get('/web-only/ws/{workshop}', [WorkshopController::class, 'show'])
     ->name('workshops.show.web');




//  Workshop Query Handler (This handles /workshops?id=43)
Route::get('/workshops', [WorkshopController::class, 'showFromQuery'])->name('workshops.query');

// Additional Workshop Routes
Route::post('/workshops/{workshop}/review', [WorkshopController::class, 'addReview'])->name('workshops.review')->middleware('auth');
Route::post('/workshops/{workshop}/favorite', [WorkshopController::class, 'toggleFavorite'])->name('workshops.favorite')->middleware('auth');

// Cars Provider Login
Route::get('/provider/cars/login', [\App\Http\Controllers\CarsProviderController::class, 'login'])->name('providers.cars.login');
Route::post('/verify-token-provider', [\App\Http\Controllers\AuthProviderController::class, 'verifyToken']);

Route::post('/verify-login-token-dealer', [\App\Http\Controllers\AuthProviderController::class, 'verifyCarsLoginToken']);
// Route::get('/dealer/dashboard', [\App\Http\Controllers\CarsProviderController::class, 'index'])->name('cars.dashboard');
// Cars Provider Register

Route::get('/providers/cars/register', function () {
    return view('providers.cars.register');
})->name('providers.cars.register');
// عرض بروفايل المزود
Route::get('/provider/profile/{id}', [\App\Http\Controllers\AuthProviderController::class, 'profile'])
    ->name('provider.profile');
// صفحة تعديل بيانات المزود
Route::get('/provider/edit/{id}', [\App\Http\Controllers\AuthProviderController::class, 'edit'])
    ->name('provider.edit');

// تحديث بيانات المزود
Route::put('/provider/{id}', [\App\Http\Controllers\AuthProviderController::class, 'update'])
    ->name('provider.update');

// تحديث صورة المزود
Route::post('/provider/{id}/update-image', [\App\Http\Controllers\AuthProviderController::class, 'updateImage'])
    ->name('provider.updateImage');
Route::post('/providers/logout', [\App\Http\Controllers\AuthProviderController::class, 'logout'])->name('providers.logout');

// -------------------------
// Workshops Provider Login
// -------------------------
Route::get('/provider/workshops/login', 
    [\App\Http\Controllers\AuthWorkshopProviderController::class, 'login']
)->name('providers.workshops.login');

Route::post('/verify-login-token-workshop', 
    [\App\Http\Controllers\AuthWorkshopProviderController::class, 'verifyWorkshopLoginToken']
);

// -------------------------
// Workshops Provider Register
// -------------------------
Route::get('/providers/workshops/register', function () {
    return view('providers.workshops.register');
})->name('providers.workshops.register');
Route::post('/verify-token-workshop', [\App\Http\Controllers\AuthWorkshopProviderController::class, 'verifyToken']);

// -------------------------
//my Workshop
// -------------------------

Route::get('/provider/workshop/my-workshop', [\App\Http\Controllers\WorkshopProviderController::class, 'myWorkshop'])
    ->name('workshops.myWorkshop');
Route::post('/workshops/update/{workshop}', 
    [\App\Http\Controllers\WorkshopProviderController::class, 'update']
)->name('workshops.update');

//profile 
Route::get('/workshop/profile/{id}', [\App\Http\Controllers\AuthWorkshopProviderController::class, 'profile'])
    ->name('workshop.profile');
// تحديث بيانات المزود
Route::put('/workshop/{id}', [\App\Http\Controllers\AuthWorkshopProviderController::class, 'update'])
    ->name('workshop.update');
 Route::post('/wsUploadImgs', [\App\Http\Controllers\WorkshopProviderController::class, 'wsUploadImgs'])->name('ws.uploadImgs');
    Route::delete('/wsDelImg/{id}', [\App\Http\Controllers\WorkshopProviderController::class, 'wsDelImg'])->name('ws.delImg');
// تحديث صورة المزود
Route::post('/workshop/{id}/update-image', [\App\Http\Controllers\AuthWorkshopProviderController::class, 'updateImage'])
    ->name('workshop.updateImage');
// -------------------------
// Workshops Provider Logout
// -------------------------
Route::post('/providers/workshops/logout', 
    [\App\Http\Controllers\AuthWorkshopProviderController::class, 'logout']
)->name('providers.workshops.logout');

Route::get('/workshops/dashboard', [\App\Http\Controllers\WorkshopProviderController::class, 'index'])->name('workshops.dashboard');
Route::get('/provider/{workshop}', [\App\Http\Controllers\WorkshopProviderController::class, 'show'])
     ->name('workshops.show.provider');


// --------------------------
// spareparts Provider 
//---------------------------
Route::get('/provider/spareparts/login', [\App\Http\Controllers\SparepartsProviderController::class, 'login'])->name('providers.spareparts.login');
Route::post('/verify-token-spareparts', [\App\Http\Controllers\AuthsparepartsProviderController::class, 'verifyToken']);

Route::post('/verify-login-token-spareparts', [\App\Http\Controllers\AuthsparepartsProviderController::class, 'verifyCarsLoginToken']);


Route::get('/providers/spareparts/register', function () {
    return view('providers.spareParts.register');
})->name('providers.spareparts.register');
// عرض بروفايل المزود
Route::get('/spareparts/profile/{id}', [\App\Http\Controllers\AuthsparepartsProviderController::class, 'profile'])
    ->name('spareparts.profile');
// تحديث بيانات المزود
Route::put('/spareparts/provider/{id}', [\App\Http\Controllers\AuthsparepartsProviderController::class, 'update'])
    ->name('spareparts.update');

// تحديث صورة المزود
Route::post('/spareparts/{id}/update-image', [\App\Http\Controllers\AuthsparepartsProviderController::class, 'updateImage'])
    ->name('spareparts.updateImage');
Route::post('/spareparts/providers/logout', [\App\Http\Controllers\AuthsparepartsProviderController::class, 'logout'])->name('spareparts.logout');

Route::get('/spareparts/dashboard', [\App\Http\Controllers\SparepartsProviderController::class, 'index'])->name('spareparts.dashboard');
Route::get('/provider/spareparts/create', [\App\Http\Controllers\SparepartsProviderController::class, 'create'])->name('spareparts.create');
Route::post('/provider/spareparts/store', [\App\Http\Controllers\SparepartsProviderController::class, 'store'])->name('spareparts.store');
Route::post('/dealer/location', [\App\Http\Controllers\SparepartsProviderController::class, 'updateLocation'])->name('dealer.update.location');

// صفحة تعديل السبير بار
Route::get('/provider/spareparts/{id}/edit',
    [\App\Http\Controllers\SparepartsProviderController::class, 'edit']
)->name('spareparts.edit');

// حفظ التعديل (Update)
Route::put('/provider/spareparts/{id}/update',
    [\App\Http\Controllers\SparepartsProviderController::class, 'update']
)->name('spareparts.update');

// حذف السبير بار
Route::delete('/provider/spareparts/{id}',
    [\App\Http\Controllers\SparepartsProviderController::class, 'destroy']
)->name('spareparts.delete');






/*
|--------------------------------------------------------------------------
| 📱 App Redirect Routes - For WhatsApp/Social Media Deep Links
|--------------------------------------------------------------------------
| These routes create clickable HTTPS links for WhatsApp that redirect to the app
| WhatsApp doesn't make custom schemes clickable, so we use these redirect pages
*/

// 🚗 Car listing app redirect
Route::get('/app/car/{id}', function ($id) {
    $appUrl = "carllymotors://car-listing?id=" . $id;
    
    return view('app-redirect', [
        'appUrl' => $appUrl,
        'title' => 'Car Details - Carlly',
        'description' => 'View this amazing car on Carlly app',
        'image' => asset('images/carlly-logo.png'),
        'fallbackUrl' => route('carlisting.detail', $id),
        'type' => 'car'
    ]);
})->name('app.car')->where('id', '[0-9]+');

// 🔧 Spare parts app redirect  
Route::get('/app/spare-part', function (Request $request) {
    $shopId = $request->get('shop_id');
    $carType = $request->get('car_type', '');
    $carModel = $request->get('car_model', '');
    $year = $request->get('year', '');
    $category = $request->get('category', '');
    $subCategory = $request->get('sub-category', '');
    $vinNumber = $request->get('vin-number');
    
    // Build the app URL with all parameters
    $params = http_build_query(array_filter([
        'shop_id' => $shopId,
        'car_type' => $carType,
        'car_model' => $carModel, 
        'year' => $year,
        'category' => $category,
        'sub-category' => $subCategory,
        'vin-number' => $vinNumber,
    ]));
    
    $appUrl = "carllymotors://spare-part?" . $params;
    
    // Build user-friendly title and description
    $title = 'Spare Parts - Carlly';
    $description = 'Find spare parts';
    if ($carType && $carModel) {
        $description = "Find spare parts for {$carType} {$carModel}";
    }
    if ($category) {
        $description .= " - {$category}";
    }
    $description .= ' on Carlly app';
    
    return view('app-redirect', [
        'appUrl' => $appUrl,
        'title' => $title,
        'description' => $description,
        'image' => asset('images/carlly-logo.png'),
        'fallbackUrl' => route('sparepart.query', $request->all()),
        'type' => 'spare-part'
    ]);
})->name('app.spare-part');

// 🔨 Workshop app redirect
// Route::get('/app/workshop/{id}', function ($id) {
//     $appUrl = "carllymotors://workshops?id=" . $id;
    
//     return view('app-redirect', [
//         'appUrl' => $appUrl,
//         'title' => 'Workshop Details - Carlly',
//         'description' => 'View this workshop on Carlly app',
//         'image' => asset('images/carlly-logo.png'),
//         'fallbackUrl' => route('workshops.show', $id),
//         'type' => 'workshop'
//     ]);
// })->name('app.workshop')->where('id', '[0-9]+');
// 🔍 Global Search Route
Route::get('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('global.search');
