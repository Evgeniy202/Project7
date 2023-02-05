<?php

use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Admin//
Route::group(['middleware' => ['role:admin']], function () {
    Route::prefix('admin')->group(function (){
       Route::get('/', [\App\Http\Controllers\Admin\MainPageController::class, 'index'])
           ->name('mainAdmin');

       Route::resource('categories', \App\Http\Controllers\Admin\CategoriesController::class);
    });
});
