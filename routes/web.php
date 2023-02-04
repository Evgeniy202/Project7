<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Admin//
Route::group(['middleware' => ['role:admin']], function () {
    Route::prefix('admin')->group(function (){
       Route::get('/', [\App\Http\Controllers\Admin\MainPageController::class, 'index'])
           ->name('mainAdmin');
    });
});
