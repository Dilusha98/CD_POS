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
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | View Routes
    |--------------------------------------------------------------------------
    |
    */
    Route::get('/dashboard', [viewController::class, 'index'])->name('dashboard');
    Route::get('/brand', [viewController::class, 'brand'])->name('brand');
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

    /*
    |--------------------------------------------------------------------------
    | Action Routes
    |--------------------------------------------------------------------------
    |
    */
});

require __DIR__ . '/auth.php';
