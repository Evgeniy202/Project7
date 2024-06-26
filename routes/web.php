<?php

use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::match(['get', 'post'], '/search', [\App\Http\Controllers\Open\ProductController::class, 'searchAll'])->name('searchAll');

Route::middleware(['verified'])->group(function () {
    Route::get('/selected', [\App\Http\Controllers\Open\SelectedProductsController::class, 'show'])
        ->name('selected-product-public');

    Route::get('/remove-selected/{productId}', [\App\Http\Controllers\Open\SelectedProductsController::class, 'remove'])
        ->name('remove-selected');

    Route::get('/cart', [\App\Http\Controllers\Open\CartProductsController::class, 'show'])
        ->name('cart-view');
    Route::post('/change-quantity/{cartProductId}', [\App\Http\Controllers\Open\CartProductsController::class, 'changeQuantity'])
        ->name('change-quantity');
    Route::get('/add-product-to-cart/{productId}', [\App\Http\Controllers\Open\CartProductsController::class, 'add'])
        ->name('add-to-cart');
    Route::get('/remove-product-from-cart/{cartProductId}', [\App\Http\Controllers\Open\CartProductsController::class, 'remove'])
        ->name('remove-from-cart');
    Route::get('/all-remove-from-cart', [\App\Http\Controllers\Open\CartProductsController::class, 'cleanCart'])
        ->name('all-remove-from-cart');
    Route::get('/redirect-to-product/{productId}', [\App\Http\Controllers\Open\CartProductsController::class, 'redirectToProduct'])
        ->name('redirect-to-product');

    Route::post('/check-order', [\App\Http\Controllers\Open\OrderController::class, 'checkOrder'])
        ->name('check-order');
    Route::get('/orders', [\App\Http\Controllers\Open\OrderController::class, 'orderView'])
        ->name('order-view');

    Route::get('/support', [\App\Http\Controllers\Open\SupportController::class, 'show'])->name('support-public');
    Route::post('/create-support', [\App\Http\Controllers\Open\SupportController::class, 'create'])
        ->name('create-support');

    Route::post('/add-comment/{productId}', [\App\Http\Controllers\Open\ProductController::class, 'addComment'])
        ->name('add-comment');
    Route::post('/add-rating/{productId}', [\App\Http\Controllers\Open\ProductController::class, 'addRating'])
        ->name('add-rating');
});

Route::prefix('category')->group(function () {
    Route::get('/{categoryId}/sort/{sort}', [\App\Http\Controllers\Open\SortController::class, 'productsOfCategory'])
        ->name('filterCategoryPublic');
});

Route::resource('category', \App\Http\Controllers\Open\CategoriesController::class);
Route::resource('product', \App\Http\Controllers\Open\ProductController::class);

Route::get('/about', function (){
    return view('public.other.about');
})->name('about');

//Ajax
Route::post('/select-product', [\App\Http\Controllers\Open\SelectedProductsController::class, 'action'])
    ->name('select-product');

//Admin//
Route::group(['middleware' => ['role:admin']], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\MainPageController::class, 'index'])
            ->name('mainAdmin');
        Route::get('/forget-categories-session',
            [\App\Http\Controllers\Admin\MainPageController::class, 'forgetCategoriesSession'])
            ->name('forgetCategoriesSession');

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

        Route::get('/user/search', [\App\Http\Controllers\Admin\UserController::class, 'searchForm'])->name('searchUserById');
        Route::get('/user/{id}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('showUser');
        Route::get('/user/{id}/edit-role', [\App\Http\Controllers\Admin\UserController::class, 'editRoleForm'])->name('editUserRoleForm');
        Route::put('/user/{id}/edit-role', [\App\Http\Controllers\Admin\UserController::class, 'editRole'])->name('editUserRole');
        Route::delete('/user/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('deleteUser');

        Route::prefix('products')->group(function () {
            Route::post('/search', [\App\Http\Controllers\Admin\ProductController::class, 'search'])
                ->name('searchProductsAdmin');

            Route::post('/{productId}/addImage',
                [\App\Http\Controllers\Admin\ProductController::class, 'addImage'])
                ->name('addProductImage');
            Route::post('/{productId}/changeImage/{imageId}',
                [\App\Http\Controllers\Admin\ProductController::class, 'changeImage'])
                ->name('changeProductImage');
            Route::get('/deleteImage/{imageId}',
                [\App\Http\Controllers\Admin\ProductController::class, 'destroyImage'])
                ->name('destroyProductImage');

            Route::post('/{productId}/addFeature',
                [\App\Http\Controllers\Admin\ProductController::class, 'addCharOfProduct'])
                ->name('addProductFeature');
            Route::post('/changeFeature/{prodCharId}',
                [\App\Http\Controllers\Admin\ProductController::class, 'changeCharOfProduct'])
                ->name('changeProductFeature');
            Route::get('/deleteFeature/{prodCharId}',
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

        Route::prefix('orders')->group(function () {
            Route::get('/search', [\App\Http\Controllers\Admin\OrderController::class, 'search'])
                ->name('search-order');
            Route::get('/detail/{orderId}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])
                ->name('order-detail');
            Route::get('/{status}', [\App\Http\Controllers\Admin\OrderController::class, 'ordersList'])
                ->name('orders-status');
        });
        Route::get('/change-status/{orderId}/{status}', [\App\Http\Controllers\Admin\OrderController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('/remove-number/{orderProductId}', [\App\Http\Controllers\Admin\OrderController::class, 'removeProduct'])
            ->name('remove-orderProduct');
        Route::post('/change-number/{orderProductId}', [\App\Http\Controllers\Admin\OrderController::class, 'changeNumber'])
            ->name('change-number');
        Route::post('/add-product/{orderId}', [\App\Http\Controllers\Admin\OrderController::class, 'addProduct'])
            ->name('add-product');

        Route::get('remove-comment/{commentId}', [\App\Http\Controllers\Open\ProductController::class, 'commentDestroy'])
            ->name('remove-comment');

        Route::resource('categories', \App\Http\Controllers\Admin\CategoriesController::class);
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        Route::resource('banner', \App\Http\Controllers\Admin\BannerController::class);
        Route::resource('sections', \App\Http\Controllers\Admin\SectionController::class);
    });

    //Ajax
    Route::get('/get-values-for-char/{charId}', [\App\Http\Controllers\Ajax\AjaxController::class, 'getValuesForChar']);
});
