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

        Route::prefix('products')->group(function () {
            Route::post('/{productId}/addImage',
                [\App\Http\Controllers\Admin\ProductController::class, 'addImage'])
                ->name('addProductImage');
            Route::post('/{productId}/changeImage/{imageId}',
                [\App\Http\Controllers\Admin\ProductController::class, 'changeImage'])
                ->name('changeProductImage');
            Route::get('/{productId}/deleteImage/{imageId}',
                [\App\Http\Controllers\Admin\ProductController::class, 'destroyImage'])
                ->name('destroyProductImage');

            Route::post('/{productId}/addFeature',
                [\App\Http\Controllers\Admin\ProductController::class, 'addCharOfProduct'])
                ->name('addProductFeature');
            Route::post('/{productId}/changeFeature/{prodCharId}',
                [\App\Http\Controllers\Admin\ProductController::class, 'changeCharOfProduct'])
                ->name('changeProductFeature');
            Route::get('/{productId}/deleteFeature/{prodCharId}',
                [\App\Http\Controllers\Admin\ProductController::class, 'removeCharOfProduct'])
                ->name('destroyProductFeature');

            Route::post('/create-discount/{productId}',
                [\App\Http\Controllers\Admin\ProductController::class, 'createDiscount'])
                ->name('create-discount');
            Route::post('/change-discount/{discountId}',
                [\App\Http\Controllers\Admin\ProductController::class, 'changeDiscount'])
                ->name('change-discount');
            Route::get('/remove-discount/{discountId}',
                [\App\Http\Controllers\Admin\ProductController::class, 'removeDiscount'])
                ->name('remove-discount');
        });

        Route::resource('categories', \App\Http\Controllers\Admin\CategoriesController::class);
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    });

    //Ajax
    Route::get('/get-values-for-char/{charId}', [\App\Http\Controllers\Ajax\AjaxController::class, 'getValuesForChar']);
});
