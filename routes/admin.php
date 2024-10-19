<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ProductColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductSizeController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WareHouseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SupplierController;

Route::prefix('admin')
->as('admin.')
->middleware(['auth', 'is_admin'])
->group(function () {
    Route::resource('catalogues', CatalogueController::class);
    Route::resource('productcolors',ProductColorController::class);
    Route::resource('productsizes',ProductSizeController::class);
    Route::resource('users', UserController::class);
    Route::resource('tags', TagController::class);
    Route::resource('products', ProductController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('warehouses', WareHouseController::class);
    Route::resource('inventories', controller: InventoryController::class);
    Route::get('/', [CatalogueController::class, 'index']);
    Route::resource('orders',OrderController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('suppliers', SupplierController::class);

    Route::prefix('restore')->group(function(){
        Route::get('trash', function(){
            return view('admin.layouts.trash');
        })->name('trash');
    });
});
