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
use App\Http\Controllers\User\ForgotPasswordController;

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

Route::get('/forgot-password', [ForgotPasswordController::class, 'index']);
Route::post('/search-mobile-no', [ForgotPasswordController::class, 'searchMobile'])->name('search-mobile-no');
Route::post('/save-pwd', [ForgotPasswordController::class, 'savePwd'])->name('save-pwd');

Route::get('/invoices', [DesignController::class, 'invoice']);
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



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


