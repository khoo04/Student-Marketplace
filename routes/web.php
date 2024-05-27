<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;

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
Route::get('/', [PageController::class,'index']);


Route::middleware('guest')->group(function(){
    Route::get('/register', [UserController::class,'create']);
    Route::post('/register',[UserController::class,'store']);

    Route::get('/login', [UserController::class,'login'])->name('login');

    Route::post('/login',[UserController::class,'authenticate']);
});

Route::post('/logout',[UserController::class,'logout']);

Route::get('/product_data',[PageController::class,'paginateData']);


//Product Routes
Route::get('/products/{product}',[ProductController::class,'show']);

Route::get('/search',[SearchController::class,'show']);

//Category Routes
Route::get('/categories/{category}',[PageController::class,'categoryPage']);

Route::get('/profile',[PageController::class,'showProfile'])->middleware('auth');

//Route::get('/payments',[PaymentController::class,'show']);

//Route::get('/payments/pay',[PaymentController::class,'create']);


//Profile Routes
Route::get('/ajax/profile_control',[PageController::class,'showProfileControl'])
    ->name('ajax.profile-control')
    ->middleware(['auth','ajax']);


 Route::get('/ajax/address_control',[PageController::class,'showAddressControl'])
     ->name('ajax.address-control')
     ->middleware(['auth','ajax','buyer_only']);
