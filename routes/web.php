<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Auth\VendorLoginController;
use App\Http\Controllers\Auth\VendorRegisterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;


// Vendor Controller
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Vendor\ServiceController;

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\DesignController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\BookServiceController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});
Route::get('/clothing', function () {
    return view('/clothing');
});
Route::get('/detail_view', function () {
    return view('/detail_view');
});
Route::get('/womens', function () {
    return view('/womens');
});
Route::get('/electronics', function () {
    return view('/electronics');
});
Route::get('/contact', function () {
    return view('/contact');
});
Route::get('/checkout', function () {
    $cartCollection = \Cart::getContent();
    return view('/checkout', compact('cartCollection'));
});

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate');
    return 'DONE'; //Return anything
});

Route::get('/routeList', function () {
    $exitCode = Artisan::call('route:list');
    return Artisan::output(); //Return anything
});

Route::get('/seed', function () {
    $exitCode = Artisan::call('db:seed');
    return 'DONE'; //Return anything
});

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::post('/submit-login-form', [LoginController::class, 'submitLoginForm'])->name('submit-login-form');
Route::post('/submit-register-form', [RegisterController::class, 'submitRegisterForm'])->name('submit-register-form');
Route::post('/submit-otp-form', [RegisterController::class, 'submitOtpForm'])->name('submit-otp-form');

Route::post('/add', [CartController::class, 'add'])->name('cart.store');
Route::post('/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('filter-index-product', [DesignController::class, 'filterIndexProduct'])->name('filter.index-product');
Route::get('product-view/{id}', [DesignController::class, 'singleProduct'])->name('single.product');
Route::get('/products', [DesignController::class, 'allProducts']);
Route::post('filter-product', [DesignController::class, 'filterProduct'])->name('filter.product');
Route::post('/placeOrder', [OrderController::class, 'placedOrder'])->name('placed.order');
Route::get('/orderDetails/{id}', [OrderController::class, 'orderDetails'])->name('order.details');
Route::post('/user-info/store', [OrderController::class, 'storeUserInfo'])->name('save.user-info');
Route::post('/payment/{id}', [OrderController::class, 'payment'])->name('payment');
Route::post('/success', [OrderController::class, 'paymentSuccess'])->name('success');
Route::get('/payment-success/{id}', [OrderController::class, 'paymentDetail'])->name('payment-success');
Route::get('/placed-order', [OrderController::class, 'placedOrderDetails']);
Route::get('/payment-details', [OrderController::class, 'userPaymentDetails']);
Route::resource('/book-service', BookServiceController::class);
Route::get('/search-available-date', [BookServiceController::class, 'searchAvailableDate'])->name('search.available-date');
Route::post('get-book-service', [BookServiceController::class, 'getBookService'])->name('get-book-service');

Route::get('/services', [DesignController::class, 'allServices']);
Route::post('filter-service', [DesignController::class, 'filterService'])->name('filter.service');


// Route::prefix('admin')->name('admin.')->group(function() {
//     // Admin Authentication Route
//     Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
//     Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
//     Route::get('/', [AdminController::class, 'index'])->name('dashboard');
//     Route::get('/logout', [AdminLoginController::class, 'logout'])->name('logout');
//     Route::resource('/vendors', VendorController::class);
//     Route::resource('/services', App\Http\Controllers\Admin\ServiceController::class);
//     Route::resource('categories', CategoryController::class);
//     Route::post('/get-category', [CategoryController::class, 'getCategory'])->name('get.category');
//     Route::post('/category/update', [CategoryController::class, 'updateCategory']);
//     Route::resource('/sub-category', SubCategoryController::class);
//     Route::post('/get-sub-category', [SubCategoryController::class, 'getSubCategory'])->name('get.sub-category');
//     Route::post('/sub-category/update', [SubCategoryController::class, 'updateSubCategory']);
//     Route::resource('/products', App\Http\Controllers\Admin\ProductController::class);
//     Route::get('/get-category-list', [App\Http\Controllers\Admin\ProductController::class, 'getCategoryList']);
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::prefix('vendors')->name('vendor.')->group(function() {
//     // Admin Authentication Route
//     Route::get('/login', [VendorLoginController::class, 'showLoginForm'])->name('login');
//     Route::post('/login', [VendorLoginController::class, 'login'])->name('login.submit');
//     Route::get('/register', [VendorRegisterController::class, 'showRegisterForm'])->name('register');
//     Route::post('/register', [VendorRegisterController::class, 'register'])->name('register.submit');
//     Route::get('/', [App\Http\Controllers\Auth\VendorController::class, 'index'])->name('dashboard');
//     Route::get('/logout', [VendorLoginController::class, 'logout'])->name('logout');
//     Route::resource('product', ProductController::class);
//     Route::get('/get-sub-category-list', [ProductController::class, 'getSubCategoryList']);
//     Route::resource('/service', ServiceController::class);
//     Route::post('/available-date/store', [ServiceController::class, 'storeAvailableDate'])->name('available-date.store');
//     Route::get('/get-date/{id}', [ServiceController::class, 'getDate'])->name('service.getDate');
//     Route::delete('/available-date/{id}', [ServiceController::class, 'deleteAvailableDate']);
// });
