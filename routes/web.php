<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReservationController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
Route::get('/reservation/{id}/cancel', [ReservationController::class, 'showCancelForm'])->name('reservation.cancel');
Route::post('/reservation/{id}/cancel', [ReservationController::class, 'cancelReservation']);
Route::get('/review/create', [ReviewController::class, 'create'])->name('review.create');
Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');

Route::post('/locale', [LocaleController::class, 'change'])->name('locale.change');
