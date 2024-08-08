<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\viewController;
use App\Http\Controllers\actionController;
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
    Route::get('/dashboard',[viewController::class,'index'])->name('dashboard');
    Route::get('/brand',[viewController::class,'brand'])->name('brand');



    /*
    |--------------------------------------------------------------------------
    | Ajax Routes
    |--------------------------------------------------------------------------
    |
    */



    /*
    |--------------------------------------------------------------------------
    | Action Routes
    |--------------------------------------------------------------------------
    |
    */
});

require __DIR__.'/auth.php';
