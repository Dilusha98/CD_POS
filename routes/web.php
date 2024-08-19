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
    Route::get('/dashboard', [viewController::class, 'index'])->name('dashboard');
    Route::get('/brand', [viewController::class, 'brand'])->name('brand_list');
    //user role view
    Route::get('/UserRole', [viewController::class, 'userRole'])->name('create_user_role');
    //create user view
    Route::get('/CreateUser', [viewController::class, 'createUser'])->name('create_user');
    Route::get('/UserList', [viewController::class, 'userList'])->name('user_list');
    Route::get('/UserEdit', [viewController::class, 'userEdit'])->name('user_edit');




    /*
    |--------------------------------------------------------------------------
    | Ajax Routes
    |--------------------------------------------------------------------------
    |
    */
    // Route::post('/add-brand', [AjaxController::class, 'addNewBrand'])->name('add-brand');
    //user role action
    Route::post('/CreateUserRole', [AjaxController::class, 'createUserRole'])->name('create_user_role');
    Route::post('/add-brand',[AjaxController::class,'addNewBrand'])->name('create_brand');
    Route::post('/edit-brand/{id}',[AjaxController::class,'editNewBrand'])->name('edit_brand');

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
    Route::get('/get-brand-data',           [AjaxController::class,'brandList'])->name('get_brand_list');
    Route::get('/get-brand-details/{id}',   [AjaxController::class,'getBrand'])->name('getBrand');

    Route::get('/user-phone-uniq-validation', [AjaxController::class, 'phoneNumberValidation'])->name('user_phone_uniq_validation');
    Route::get('/user-user-name-uniq-validation', [AjaxController::class, 'userNameValidation'])->name('user_user_name_uniq_validation');
    Route::get('/user-email-uniq-validation', [AjaxController::class, 'userEmailValidation'])->name('user_email_uniq_validation');
    Route::post('/SaveUser', [AjaxController::class, 'saveUser'])->name('save_user');
    Route::get('/get-user-list', [AjaxController::class, 'getUserList'])->name('get_user_list');

    Route::get('/current-password-match-validation', [AjaxController::class, 'currentPasswordCheckValidation'])->name('current_password_match_validation');
    Route::post('/SaveResetPassword', [AjaxController::class, 'saveResetPassword'])->name('save_reset_password');
});



// chandima
Route::middleware(['auth', 'check_permissions'])->group(function () {


});


Route::middleware(['auth'])->group(function () {

});


require __DIR__ . '/auth.php';
