<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Models\AllUsersModel;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/upcomming', function () {
    return view('/upcomming');
})->name('upcomming');

Route::get('/try', function () {
    return view('/try');
})->name('try');

Route::get('/about-us', function () {
    return view('/aboutus');
})->name('aboutus');

Route::get('/terms', function () {
    return view('/terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('/privacy');
})->name('privacy');

Route::get('/faqs', function () {
    return view('/faqs');
})->name('faqs');

Route::get('/', [HomeController::class, 'index'])->name('home');

//Cars
Route::get('filters', [HomeController::class, 'filters'])->name('home.filters');
Route::get('listing', [HomeController::class, 'carListing'])->name('carlisting');
Route::get('filter-cars', [HomeController::class, 'filter'])->name('filter.cars');
Route::get('grid',[HomeController::class,'carListing'])->name('listing.grid');
Route::resource('cars', CarController::class);
Route::get('/car/{id}', [HomeController::class, 'detail'])->name('car.detail');
Route::post('/addTofav/{carId}', [CarController::class, 'addTofav'])->name('cars.addTofav')->middleware('auth');;
Route::get('/favList', [CarController::class, 'favList'])->name('cars.favList')->middleware('auth');;
Route::get('/myCarListing', [CarController::class, 'myCarListing'])->name('myCarListing')->middleware('auth');
Route::get('cars/homeSection', [CarController::class, 'homeSection'])->name('cars.homeSection');
Route::post('getModels', [CarController::class, 'getModels'])->name('getModels');

// SpareParts
Route::resource('spareParts', SparePartController::class);
Route::get('spareparts/homeSection', [SparePartController::class, 'homeSection'])->name('spareparts.homeSection');
Route::get('filter-sparePart', [SparePartController::class, 'filter'])->name('filter.spareParts');
Route::post('getSubCategories', [SparePartController::class, 'getSubCategories'])->name('getSubCategories');

// Setting
Route::post('contact-us', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contacts.index');
// 


Route::get('/terms', [SettingController::class, 'terms'])->name('terms');
Route::get('/privacy_policy', [SettingController::class, 'privacy'])->name('privacy');

// User
Auth::routes();
Route::post('/verify-token', [AuthController::class, 'verifyToken']);
Route::get('/profile/{id}', [AuthController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/users/edit/{id}', [AuthController::class, 'edit'])->name('users.edit')->middleware('auth');
Route::put('/users/{id}', [AuthController::class, 'update'])->name('users.update')->middleware('auth');;

// Route::post('/cars/{carId}/addTofav', [CarController::class, 'addTofav'])->name('cars.addTofav');
