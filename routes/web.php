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
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShippingAddressController;
use App\Models\Payment;
use Illuminate\Routing\RouteGroup;

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

//User Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'create']);
    Route::post('/register', [UserController::class, 'store']);

    Route::get('/login', [UserController::class, 'login'])->name('login');

    Route::post('/login', [UserController::class, 'authenticate']);
});

Route::middleware(['auth', 'admin_only'])->group(function () {
    Route::post('/user/updateAccountStatus', [UserController::class, 'updateAccountStatus'])->name('users.updateAccStatus');
    Route::post('/user/getDetails', [UserController::class, 'getSellerDetails'])->name('users.getDetails');
});

Route::put('/user/updateDetails',[UserController::class,'updateDetails'])->name('user.updateDetails');
Route::put('/user/updatePass',[UserController::class,'updatePassword'])->name('user.updatePassword');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

//Paginate the Data on Index Page
Route::get('/product_data',[PageController::class,'paginateData']);

//Paginate the Data on Index Page
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

Route::get('/products/getDetails',[ProductController::class,'getDetails'])->middleware(['auth','buyer_only','ajax'])->name('products.details');

Route::post('/products/updateStatus',[ProductController::class,'updateProductStatus'])->middleware(['auth','admin_only'])->name('products.updateStatus');

//Note: Wild Card route must be the last one
Route::get('/products/{product}',[ProductController::class,'show'])->name('products.show');


Route::get('/search', [SearchController::class, 'show']);

//Category Routes
Route::get('/categories/{category}', [PageController::class, 'categoryPage']);


//Profile Routes
Route::get('/profile', [PageController::class, 'showProfile'])->middleware('auth')->name('profile');
Route::get('/redirectToOrderPage',[OrderController::class,'view'])->middleware('auth')->name('view.order');

Route::middleware(['auth','seller_only'])->group(function(){
    Route::get('/profile/updateBank',[UserController::class,'createBankDetails'])->name('profile.createBankDetails');
    Route::post('profile/updateBank',[UserController::class,'updateBankDetails'])->name('profile.updateBankDetails');
});
Route::get('/ajax/profile_control',[PageController::class,'showProfileControl'])
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
    Route::get('/ajax/sales_report/graphData', [PageController::class, 'getReportData'])->name('ajax.reportData');
    Route::get('/ajax/sales_report/tableData', [PageController::class, 'getSalesTableData'])->name('ajax.salesTableData');
    Route::get('/ajax/sales_report/allProductSalesData',[PageController::class,'getAllProductSalesData'])->name('ajax.allProductSalesData');
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

Route::middleware(['auth','buyer_only'])->group(function(){
    Route::put('/orders/comments',[OrderController::class,'updateComment'])->name('order.leaveComment');
});

//Buyer Update Order Status
Route::post('/orders/receive',[OrderController::class,'receiveOrder'])->middleware(['auth','buyer_only'])->name('order.receiveOrder');

//Payment Route
Route::post('/payments',[PaymentController::class,'create'])->name('payments.create');
Route::get('/payments/testcallback',[PaymentController::class,'showTestCallBack']);
Route::post('/payments/callback',[PaymentController::class,'callback'])->name('payments.callback');
Route::post('/payments/payToSeller',[PaymentController::class,'updateIsPaidStatus'])->middleware(['auth','admin_only'])->name('payments.updateIsPaid');
//Admin Route
Route::middleware(['auth', 'admin_only'])->group(function () {
    Route::get('/admin',[PageController::class,'adminIndex'])->name('admin');
}); 

Route::middleware(['auth','ajax','admin_only'])->group(function(){
    Route::get('/adminAjax/AccApprovalPanel',[PageController::class,'getAccApprovalPanel'])->name('admin.accApprovePanel');
    Route::get('/adminAjax/ProductApprovalPanel',[PageController::class,'getProductApprovalPanel'])->name('admin.productApprovePanel');
    Route::get('/adminAjax/salesPaybackPanel',[PageController::class,'getSalesPaybackPanel'])->name('admin.salesPaybackPanel');
});
//Payment Route
Route::post('/payments', [PaymentController::class, 'create'])->name('payments.create');
Route::get('/payments/testcallback', [PaymentController::class, 'showTestCallBack']);
Route::post('/payments/callback', [PaymentController::class, 'callback'])->name('payments.callback');



Route::middleware(['auth', 'buyer_only'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/updateQuantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::delete('/cart', [CartController::class, 'destroy'])->name('cart.destroy');
});


//Address Route
Route::middleware(['auth', 'buyer_only'])->group(function () {
    Route::post('/address/create', [ShippingAddressController::class, 'store'])->name('address.create');
    Route::delete('/address/delete', [ShippingAddressController::class, 'destroy'])->name('address.destroy');
    Route::get('/address/details', [ShippingAddressController::class, 'getDetails'])->name('address.details');
    Route::put('/address/update', [ShippingAddressController::class, 'update'])->name('address.update');
    Route::put('/address/setDefault', [ShippingAddressController::class, 'setAsDefault'])->name('address.setDefault');
});
