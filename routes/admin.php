<?php


use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductSizeController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')
->as('admin.')
->group(function () {
    Route::resource('categories', CatalogueController::class);
    Route::resource('productsizes',ProductSizeController::class);
    Route::resource('users', UserController::class);
    Route::resource('tags', TagController::class);
    Route::resource('products', ProductController::class);
});
