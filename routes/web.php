<?php

use App\Models\Reservation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmation;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RoomsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\VouchersController;
use App\Http\Controllers\Admin\DashboardController;
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

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/rooms', [RoomsController::class, 'index'])->name('rooms.index');
        Route::get('/rooms/create', [RoomsController::class, 'create'])->name('rooms.create');
        Route::post('/rooms/store', [RoomsController::class, 'store'])->name('rooms.store');

        Route::get('/rooms/{id}/edit', [RoomsController::class, 'edit'])->name('rooms.edit');
        Route::put('/rooms/{id}', [RoomsController::class, 'update'])->name('rooms.update');
        Route::delete('/rooms/images/{id}', [RoomsController::class, 'deleteImage'])->name('rooms.delete-image');

        Route::delete('/rooms/{id}', [RoomsController::class, 'destroy'])->name('rooms.destroy');

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/reservations', function () {
            return view('admin.reservations.reservations');
        })->name('reservations');

        Route::get('/vouchers', [VouchersController::class, 'index'])->name('vouchers.index');
        Route::get('/vouchers/create', [VouchersController::class, 'create'])->name('vouchers.create');
        Route::get('/vouchers/{voucher}/edit', [VouchersController::class, 'edit'])->name('vouchers.edit');
    });
});

Route::get('/setup-production', function () {
    Artisan::call('key:generate', ['--force' => true]);
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');

    return 'Production setup completed!';
});

Route::post('/locale', [LocaleController::class, 'change'])->name('locale.change');
