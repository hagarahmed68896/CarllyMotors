<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;

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

Auth::routes();

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
Route::get('filters', [HomeController::class, 'filters'])->name('home.filters');
Route::get('listing', [HomeController::class, 'carListing'])->name('carlisting');
Route::get('filter-cars', [HomeController::class, 'filter'])->name('filter.cars');
Route::get('grid',[HomeController::class,'carListing'])->name('listing.grid');
Route::get('/car/{id}', [HomeController::class, 'detail'])->name('car.detail');

Route::resource('cars', CarController::class);
Route::get('cars/homeSection', [CarController::class, 'homeSection'])->name('cars.homeSection');
Route::post('getModels', [CarController::class, 'getModels'])->name('getModels');


Route::resource('spareParts', SparePartController::class);
Route::get('spareparts/homeSection', [SparePartController::class, 'homeSection'])->name('spareparts.homeSection');
Route::get('filter-sparePart', [SparePartController::class, 'filter'])->name('filter.spareParts');
Route::post('getSubCategories', [SparePartController::class, 'getSubCategories'])->name('getSubCategories');

// Setting
Route::post('contact-us', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contacts.index');

Route::get('/terms', [SettingController::class, 'terms'])->name('terms');
Route::get('/privacy_policy', [SettingController::class, 'privacy'])->name('privacy');


Route::post('/verify-token', [AuthController::class, 'verifyToken']);
Route::get('/dashboard', function () {
    return "Welcome to your dashboard!";
})->middleware('auth');
