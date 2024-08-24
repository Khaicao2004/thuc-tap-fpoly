<?php


use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\ProductSizeController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')
->as('admin.')
->group(function () {
    Route::resource('categories', CatalogueController::class);
    Route::resource('productsizes',ProductSizeController::class);
});
