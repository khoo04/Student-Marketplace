<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

    Route::get('/login', [UserController::class,'login']);

    Route::post('/login',[UserController::class,'authenticate']);
});

Route::post('/logout',[UserController::class,'logout']);

Route::get('/product',function(){
    return view('product');
});

Route::get('/product_data',[PageController::class,'paginateData']);
