<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\CouponController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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


Auth::routes();


//fontend
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/product/details/{product_id}', [FrontendController::class, 'product_details'])->name('product.details');
Route::get('/profile', [FrontendController::class, 'profile'])->name('profile');
Route::post('/profile/update', [FrontendController::class, 'profile_update']);


//Users
Route::get('/users', [HomeController::class, 'users'])->name('users');
Route::get('/user/delete/{user_id}', [HomeController::class, 'user_delete'])->name('user.delete');

//Category
Route::get('/category', [CategoryController::class, 'index'])->name('category');
Route::post('/category/insert', [CategoryController::class, 'insert']);
Route::get('/category/soft/delete/{category_id}', [CategoryController::class, 'soft_delete'])->name('category.softdelete');
Route::get('/category/retore/{category_id}', [CategoryController::class, 'category_restore'])->name('category.restore');
Route::get('/category/harddelete/{category_id}', [CategoryController::class, 'category_harddelete'])->name('category.harddelete');
Route::get('/category/edit/{category_id}', [CategoryController::class, 'category_edit'])->name('category.edit');
Route::post('/category/update', [CategoryController::class, 'category_update']);
Route::get('/category/trashed', [CategoryController::class, 'category_trashed'])->name('trashed');
Route::post('/category/mark/delete', [CategoryController::class, 'category_mark_delete']);


//Sub Category
Route::get('/subcategory', [SubcategoryController::class, 'index'])->name('subcategory');
Route::post('/subcategory/insert', [SubcategoryController::class, 'insert']);
Route::get('/subcategory/delete/{subcategory_id}', [SubcategoryController::class, 'delete'])->name('subcategory.delete');
Route::get('/subcategory/edit/{subcategory_id}', [SubcategoryController::class, 'edit'])->name('subcategory.edit');
Route::post('/subcategory/update', [SubcategoryController::class, 'update']);

//Products
Route::get('/product', [ProductController::class, 'index'])->name('add.product');
Route::post('/product/insert', [ProductController::class, 'insert']);
Route::get('/product/view', [ProductController::class, 'view_product'])->name('view.product');
Route::get('/product/delete/{product_id}', [ProductController::class, 'product_delete'])->name('product.delete');
Route::post('/getcategory', [ProductController::class, 'getcategory']);

//Cart
Route::post('cart/insert', [CartController::class, 'cart_insert']);
Route::get('/cart/delete/{cart_id}', [CartController::class, 'cart_delete'])->name('cart.delete');
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::get('/cart/{coupon_code}', [CartController::class, 'cart']);
Route::post('/cart/update', [CartController::class, 'cart_update']);


//Customer Login
Route::post('/customer/login', [CustomerLoginController::class, 'customer_login']);
Route::get('/customer/logout', [CustomerLoginController::class, 'customer_logout'])->name('customer_logout');
Route::post('/customer/register', [CustomerRegisterController::class, 'customer_register']);

//Coupon
Route::get('/coupon', [CouponController::class, 'coupon'])->name('add.coupon');
Route::post('/coupon/insert', [CouponController::class, 'coupon_insert']);

//Checkout
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/getCity', [CheckoutController::class, 'getCity']);
Route::post('/order/insert', [CheckoutController::class, 'order_insert']);
Route::get('/order_confirm', [CheckoutController::class, 'order_confirm'])->name('order_confirm');



// SSLCOMMERZ Start
Route::get('/ssl/payment', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END