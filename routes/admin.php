<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\CommentController;
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
    Route::get('/', function (){
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('catalogues', CatalogueController::class);
    Route::resource('productcolors',ProductColorController::class);
    Route::resource('productsizes',ProductSizeController::class);
    Route::resource('users', UserController::class);
    Route::resource('tags', TagController::class);
    Route::resource('products', ProductController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('warehouses', WareHouseController::class);
    Route::resource('inventories', controller: InventoryController::class);
    Route::resource('orders',OrderController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('comments', CommentController::class);

    Route::prefix('restore')->group(function(){
        Route::get('trash', function(){
            return view('admin.layouts.trash');
        })->name('trash');
    });

    Route::prefix('restore')->group(function () {
        // restore categories
        Route::get('/categories', [CatalogueController::class, 'getRestore'])->name('restore.categories');
        Route::post('/categories', [CatalogueController::class, 'restore']);
        
        Route::get('/products', [ProductController::class, 'getRestore'])->name('restore.products');
        Route::post('/products', [ProductController::class, 'restore']);

        Route::get('/productColors', [ProductColorController::class, 'getRestore'])->name('restore.productColors');
        Route::post('/productColors', [ProductColorController::class, 'restore']);

        Route::get('/productsizes', [ProductSizeController::class, 'getRestore'])->name('restore.productsizes');
        Route::post('/productsizes', [ProductSizeController::class, 'restore']);

        Route::get('/users', [UserController::class, 'getRestore'])->name('restore.users');
        Route::post('/users', [UserController::class, 'restore']);

        Route::get('/Suppliers', [SupplierController::class, 'getRestore'])->name('restore.Suppliers');
        Route::post('/Suppliers', [SupplierController::class, 'restore']);

        Route::get('/Comments', [CommentController::class, 'getRestore'])->name('restore.Comments');
        Route::post('/Comments', [CommentController::class, 'restore']);


        Route::get('/coupons', [CouponController::class, 'getRestore'])->name('restore.coupons');
        Route::post('/coupons', [CouponController::class, 'restore']);

        Route::get('/orders', [OrderController::class, 'getRestore'])->name('restore.orders');
        Route::post('/orders', [OrderController::class, 'restore']);

        Route::get('/warehouses', [WareHouseController::class, 'getRestore'])->name('restore.warehouses');
        Route::post('/warehouses', [WareHouseController::class, 'restore']);
        
    });
});
