<?php

use App\Models\Product;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShippingAddressController;

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

//Default Entry Point of Website
Route::get('/', [PageController::class, 'index'])->name('main');


Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'create']);
    Route::post('/register', [UserController::class, 'store']);

    Route::get('/login', [UserController::class, 'login'])->name('login');

    Route::post('/login', [UserController::class, 'authenticate']);
});

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/product_data', [PageController::class, 'paginateData']);


//Product Routes
Route::middleware(['auth', 'seller_only'])->group(function () {
    Route::get('/products', [ProductController::class, 'redirectManageProduct'])->name('products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/update/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::put('/products/update/{product}/{index}', [ProductController::class, 'updateImage'])->name('products.updateImage');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/delete', [ProductController::class, 'destory'])->name('products.destory');
});



//Note: Wild Card route must be the last one
Route::get('/products/{product}', [ProductController::class, 'show']);


Route::get('/search', [SearchController::class, 'show']);

//Category Routes
Route::get('/categories/{category}', [PageController::class, 'categoryPage']);


//Profile Routes
Route::get('/profile', [PageController::class, 'showProfile'])->middleware('auth')->name('profile');

Route::get('/ajax/profile_control', [PageController::class, 'showProfileControl'])
    ->name('ajax.profile-control')
    ->middleware(['auth', 'ajax']);


Route::get('/ajax/address_control', [PageController::class, 'showAddressControl'])
    ->name('ajax.address-control')
    ->middleware(['auth', 'ajax', 'buyer_only']);

Route::get('/ajax/user_order_control', [PageController::class, 'showUserOrderControl'])
    ->name('ajax.user-order-control')
    ->middleware(['auth', 'ajax', 'buyer_only']);

Route::middleware(['auth', 'ajax', 'seller_only'])->group(function () {
    Route::get('/ajax/product_control', [PageController::class, 'showProductControl'])->name('ajax.product-control');
    Route::get('/ajax/manage_order_control', [PageController::class, 'showManageOrderControl'])->name('ajax.manage-order-control');
    Route::get('ajax/manage_order_control/filter', [PageController::class, 'manageOrderFilter'])->name('ajax.manage-order-filter');
    Route::get('/ajax/sales_report_control', [PageController::class, 'showSalesReportControl'])->name('ajax.sales-report-control');
});

//Order Route
Route::middleware(['auth'])->group(function () {
    Route::post('/orders', [OrderController::class, 'store'])->name('order.store');
    Route::delete('/orders', [OrderController::class, 'destroy'])->name('order.delete');
});

//Update Order Status Route
Route::middleware(['auth', 'seller_only'])->group(function () {
    Route::put('/orders/updateStatus', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
});

Route::post('/payments', [PaymentController::class, 'create'])->name('payments.create');
Route::get('/payments/testcallback', [PaymentController::class, 'showTestCallBack']);
Route::post('/payments/callback', [PaymentController::class, 'callback'])->name('payments.callback');

