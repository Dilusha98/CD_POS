<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\viewController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ActionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'check_permissions'])->group(function () {


    /*
    |--------------------------------------------------------------------------
    | View Routes
    |--------------------------------------------------------------------------
    |
    */
    Route::get('/dashboard',[viewController::class,'index'])->name('dashboard');
    Route::get('/brand',[viewController::class,'brand'])->name('brand_list');
    //user role view
    Route::get('/UserRole', [viewController::class, 'userRole'])->name('user_role');
    //create user view
    Route::get('/CreateUser', [viewController::class, 'createUser'])->name('create_user');



    /*
    |--------------------------------------------------------------------------
    | Ajax Routes
    |--------------------------------------------------------------------------
    |
    */
    Route::post('/add-brand', [AjaxController::class, 'addNewBrand'])->name('add-brand');
    //user role action
    Route::post('/CreateUserRole', [AjaxController::class, 'createUserRole'])->name('create_user_role');
    Route::post('/add-brand',[AjaxController::class,'addNewBrand'])->name('create_brand');

    /*
    |--------------------------------------------------------------------------
    | Action Routes
    |--------------------------------------------------------------------------
    |
    */
});


Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Ajax Routes
    |--------------------------------------------------------------------------
    |
    */
    Route::get('/get-brand-data',[AjaxController::class,'brandList'])->name('get_brand_list');

});


require __DIR__.'/auth.php';
