<?php
use Illuminate\Support\Facades\Route;


Route::prefix('admin')
->as('admin.')
->group(function () {
    Route::get('category', function () {
        echo 111;
    });
});
