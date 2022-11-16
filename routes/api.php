<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\TournamentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('players', PlayerController::class)->except([
    'update', 'destroy'
]);

Route::get('tournaments',               [TournamentController::class, 'index'])->name('tournaments.index');
Route::post('tournaments-game',          [TournamentController::class, 'game'])->name('tournaments.game');
Route::get('tournaments/{id}',          [TournamentController::class, 'show'])->name('tournaments.show');