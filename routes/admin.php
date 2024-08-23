<?php

use App\Http\Controllers\Admin\ProductSizeController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')
->as('admin.')
->group(function () {
    Route::resource('productsizes',ProductSizeController::class);
});
