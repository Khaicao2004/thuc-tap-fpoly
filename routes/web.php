<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
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

Route::get('blog-details', function () {
    return view('client.blog-details');
})->name('blogDetails');

Route::get('shop', function () {
    return view('client.shop');
})->name('shop');

Route::get('shopping-cart', function () {
    return view('client.shopping-cart');
})->name('shoppingCart');

Route::get('checkout', function () {
    return view('client.checkout');
})->name('checkout');

Route::get('cart/list', [CartController::class, 'list'])->name('cart.list');
Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{productVariantId}', [CartController::class, 'remove'])->name('cart.remove');
