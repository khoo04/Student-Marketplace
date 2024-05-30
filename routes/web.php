<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Models\Product;

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
Route::get('/', [PageController::class,'index'])->name('main');


Route::middleware('guest')->group(function(){
    Route::get('/register', [UserController::class,'create']);
    Route::post('/register',[UserController::class,'store']);

    Route::get('/login', [UserController::class,'login'])->name('login');

    Route::post('/login',[UserController::class,'authenticate']);
});

Route::post('/logout',[UserController::class,'logout'])->name('logout');

Route::get('/product_data',[PageController::class,'paginateData']);


//Product Routes
Route::get('/products/create',[ProductController::class,'create'])->middleware(['auth','seller_only'])->name('products.create');

Route::post('/products/store',[ProductController::class,'store'])->middleware(['auth','seller_only'])->name('products.store');

Route::delete('/products/delete',[ProductController::class,'destory'])->middleware(['auth','seller_only'])->name('products.destory');

//Note: Wild Card route must be the last one
Route::get('/products/{product}',[ProductController::class,'show']);


Route::get('/search',[SearchController::class,'show']);

//Category Routes
Route::get('/categories/{category}',[PageController::class,'categoryPage']);


//Profile Routes
Route::get('/profile',[PageController::class,'showProfile'])->middleware('auth')->name('profile');

Route::get('/ajax/profile_control',[PageController::class,'showProfileControl'])
    ->name('ajax.profile-control')
    ->middleware(['auth','ajax']);


 Route::get('/ajax/address_control',[PageController::class,'showAddressControl'])
     ->name('ajax.address-control')
     ->middleware(['auth','ajax','buyer_only']);

Route::get('/ajax/user_order_control',[PageController::class,'showUserOrderControl'])
    ->name('ajax.user-order-control')
    ->middleware(['auth','ajax','buyer_only']);

Route::middleware(['auth','ajax','seller_only'])->group(function(){
    Route::get('/ajax/product_control',[PageController::class,'showProductControl'])->name('ajax.product-control');
    Route::get('/ajax/manage_order_control',[PageController::class,'showManageOrderControl'])->name('ajax.manage-order-control');
    Route::get('/ajax/sales_report_control',[PageController::class,'showSalesReportControl'])->name('ajax.sales-report-control');
});

Route::middleware(['auth'])->group(function(){
    Route::post('/orders',[OrderController::class,'store'])->name('order.store');
    Route::delete('/orders',[OrderController::class,'destroy'])->name('order.delete');
});

Route::post('/payments',[PaymentController::class,'create'])->name('payment.create');
Route::get('/payments/testcallback',[PageController::class,'showTestCallBack']);

