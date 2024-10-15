<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController;
use Illuminate\Support\Facades\Route;
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

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/shop-details/{slug}', [HomeController::class, 'detail'])->name('shop.detail');

Route::get('contact', function () {
    return view('client.contact');
})->name('contact');

Route::get('blog', function () {
    return view('client.blog');
})->name('blog');

Route::get('about', function () {
    return view('client.about');
})->name('about');

Route::get('/orders', [OrderController::class, 'list'])->name('orders.list');

Route::post('/orders/cancel/{id}', [OrderController::class, 'cancel'])->name('orders.cancel');


Route::get('check-out', [OrderController::class , 'showCheckout'])->name('checkout');
Route::post('order/save', [OrderController::class, 'save'])->name('order.save');

// mã giảm giá
Route::post('apply/coupon', [OrderController::class, 'applyCoupon'])->name('apply.coupon');
Route::post('remove/coupon', [OrderController::class, 'removeCoupon'])->name('remove.coupon');


Route::get('cart/list', [CartController::class, 'list'])->name('cart.list');
Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{variantId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update/{variantId}', [CartController::class, 'update'])->name('cart.update');


Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
