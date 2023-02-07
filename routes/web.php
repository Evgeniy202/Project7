<?php

use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Admin//
Route::group(['middleware' => ['role:admin']], function () {
    Route::prefix('admin')->group(function () {
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
        Route::get('/categories/{category}/features/{featureId}/values',
            [\App\Http\Controllers\Admin\ValueOfFeaturesController::class, 'index'])
            ->name('valuesOfFeature');
        Route::post('/categories/{category}/features/{featureId}/values/create',
            [\App\Http\Controllers\Admin\ValueOfFeaturesController::class, 'create'])
            ->name('createValuesOfFeature');
        Route::post('/categories/{category}/features/{featureId}/values/{valueId}/update',
            [\App\Http\Controllers\Admin\ValueOfFeaturesController::class, 'update'])
            ->name('updateValuesOfFeature');
        Route::get('/categories/{category}/features/{featureId}/values/{valueId}/delete',
            [\App\Http\Controllers\Admin\ValueOfFeaturesController::class, 'remove'])
            ->name('removeValuesOfFeature');

        Route::resource('categories', \App\Http\Controllers\Admin\CategoriesController::class);
    });
});
