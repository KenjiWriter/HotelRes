<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/search-results', [HomeController::class, 'searchResults'])->name('search.results');
Route::get('/room/{id}', [RoomController::class, 'show'])->name('room.show');
Route::post('/room/{id}/reserve', [RoomController::class, 'reserve'])->name('room.reserve');
Route::get('/reservation/{id}/confirmation', [ReservationController::class, 'confirmation'])->name('reservation.confirmation');