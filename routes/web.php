<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LinerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(UserController::class)->group(function() {
    Route::get('users', 'index');
    Route::get('users-export', 'export')->name('users.export');
});

Route::controller(LinerController::class)->group(function() {
    Route::get('liners', 'index');
    Route::get('liners-panel', 'panel');
    Route::get('liners-export/{code}', 'export')->name('liners.export');
});
