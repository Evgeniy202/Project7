<?php

use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Admin//
Route::group(['middleware' => ['role:admin']], function () {
    Route::prefix('admin')->group(function (){
       Route::get('/', [\App\Http\Controllers\Admin\MainPageController::class, 'index'])
           ->name('mainAdmin');

       Route::get('/categories/{category}/features',
           [\App\Http\Controllers\Admin\CharOfCategoriesController::class, 'featuresOfCategory'])
           ->name('featuresOfCategory');
       Route::post('/categories/{category}/features/create',
           [\App\Http\Controllers\Admin\CharOfCategoriesController::class, 'store'])
           ->name('newFeaturesOfCategory');
       Route::post('/categories/{category}/features/{featureId}/update',
           [\App\Http\Controllers\Admin\CharOfCategoriesController::class, 'update'])
           ->name('updateOfCategory');
       Route::post('/categories/{category}/features/{featureId}/delete',
           [\App\Http\Controllers\Admin\CharOfCategoriesController::class, 'destroy'])
           ->name('deleteOfCategory');

       Route::resource('categories', \App\Http\Controllers\Admin\CategoriesController::class);
       Route::resource('charOfCategory', \App\Http\Controllers\Admin\CharOfCategoriesController::class);
    });
});
