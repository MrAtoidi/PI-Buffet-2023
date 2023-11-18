<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\BuffetTimingController;
use App\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\Frontend\MenuController as FrontendMenuController;
use App\Http\Controllers\Frontend\ReservationController as FrontendReservationController;
use App\Http\Controllers\Frontend\DashboardController as FrontendDashboardController;
use App\Http\Controllers\Frontend\GuestController as FrontendGuestController;
use App\Http\Controllers\Frontend\ProfileController as FrontendProfileController;
use App\Http\Controllers\Frontend\WelcomeController;
use Illuminate\Support\Facades\Route;

//Páginas principais
Route::get('/', [WelcomeController::class, 'index']);
Route::get('/categories', [FrontendCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [FrontendCategoryController::class, 'show'])->name('categories.show');
Route::get('/menus', [FrontendMenuController::class, 'index'])->name('menus.index');
Route::get('/reservation/step-one', [FrontendReservationController::class, 'stepOne'])->name('reservations.step.one');
Route::post('/reservation/step-one', [FrontendReservationController::class, 'storeStepOne'])->name('reservations.store.step.one');
Route::get('/reservation/step-two', [FrontendReservationController::class, 'stepTwo'])->name('reservations.step.two');
Route::post('/reservation/step-two', [FrontendReservationController::class, 'storeStepTwo'])->name('reservations.store.step.two');
Route::get('/reservation/verificar/{email}', [FrontendReservationController::class, 'verify'])->name('reservations.verify');
Route::get('/reservation/editar/{id}', [FrontendReservationController::class, 'edit'])->name('reservations.guest-edit');
Route::get('/reservation/deleted', [FrontendReservationController::class, 'deleted'])->name('reservations.deleted');
Route::delete('/reservation/deletar/{id}', [FrontendReservationController::class, 'destroy'])->name('reservations.destroy');
Route::put('/reservation/{id}', [FrontendReservationController::class, 'update'])->name('reservations.update');
Route::post('/reservations/{reservation}/pending', [FrontendReservationController::class, 'pending'])->name('reservations.pending');
Route::post('/reservations/{reservation}/confirm', [FrontendReservationController::class, 'confirm'])->name('reservations.confirm');
Route::post('/reservations/{reservation}/cancel', [FrontendReservationController::class, 'cancel'])->name('reservations.cancel');
Route::post('/reservations/{reservation}/start', [FrontendReservationController::class, 'start'])->name('reservations.start');
Route::post('/reservations/{reservation}/finish', [FrontendReservationController::class, 'finish'])->name('reservations.finish');

Route::resource('buffet_timings', BuffetTimingController::class)->only(['index', 'show']);
Route::get('/buffet-timings', [BuffetTimingController::class, 'indexGuest'])->name('reservations.timings');
Route::post('/check-availability', [FrontendReservationController::class, 'checkAvailability'])->name('checkAvailability');

Route::get('/admin/buffet-timings', [BuffetTimingController::class, 'index'])->name('admin.buffettimings.index');
Route::get('/admin/buffet-timings/create', [BuffetTimingController::class, 'create'])->name('admin.buffettimings.create');
Route::post('/admin/buffet-timings', [BuffetTimingController::class, 'store'])->name('admin.buffettimings.store');
Route::get('/admin/buffet-timings/{id}/edit', [BuffetTimingController::class, 'edit'])->name('admin.buffettimings.edit');
Route::put('/admin/buffet-timings/{id}', [BuffetTimingController::class, 'update'])->name('admin.buffettimings.update');
Route::delete('/admin/buffet-timings/{buffet_timing}', [BuffetTimingController::class, 'destroy'])->name('admin.buffettimings.destroy');
Route::get('/admin/buffet-timings/{id}/edit', [BuffetTimingController::class, 'edit'])->name('admin.buffettimings.edit');
Route::put('/admin/buffet-timings/{id}', [BuffetTimingController::class, 'update'])->name('admin.buffettimings.update');

Route::get('/reservation/check', [FrontendReservationController::class, 'getEmailForm'])->name('reservations.check.form');
Route::get('/thankyou', [WelcomeController::class, 'thankyou'])->name('thankyou');

Route::get('/dashboard', [FrontendDashboardController::class, 'index'])->name('dashboard');

Route::get('/dashboard/my-reservations', [FrontendProfileController::class, 'index'])->name('profile.reservations');
Route::get('/dashboard/guest-at', [FrontendProfileController::class, 'guestAt'])->name('profile.guest-at');

Route::get('/reservations/{reservation}/confirmed-guests', [FrontendReservationController::class, 'confirmedGuests'])
    ->name('reservations.confirmed-guests');
Route::delete('/cancel-guest/{id}', [FrontendGuestController::class, 'cancelGuest'])->name('cancel-guest');

Route::middleware('auth')->group(function () {
Route::get('/confirmation/{reservation_id}', [FrontendGuestController::class, 'form'])->name('confirmation.form');
Route::get('/admin/confirmation/{reservation_id}', [FrontendGuestController::class, 'adminForm'])->name('admin.confirmation.form');
Route::post('/confirmation/{reservation_id}/save', [FrontendGuestController::class, 'save'])->name('confirmation.save');
Route::post('/confirmation/{reservation_id}/save', [FrontendGuestController::class, 'adminSave'])->name('admin.confirmation.save');
Route::delete('/guests/{guest}', [FrontendGuestController::class, 'removeGuest'])->name('guests.remove');
Route::post('/confirm-presence/{id}', [FrontendGuestController::class, 'confirmPresence'])->name('confirm-presence');
Route::get('/reservations/{reservation}/confirmed-guests', [ReservationController::class, 'confirmedGuests'])
    ->name('reservations.confirmed-guests');
Route::get('/admin/reservations/{reservation}/confirmed-guests', [ReservationController::class, 'adminConfirmedGuests'])
    ->name('admin.reservations.confirmed-guests');

});

Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::resource('/categories', CategoryController::class);
    Route::resource('/menus', MenuController::class);
    Route::resource('/tables', TableController::class);
    Route::resource('/reservations', ReservationController::class);
    Route::post('/reservations/{reservation}/pending', [ReservationController::class, 'pending'])->name('reservations.pending');
    Route::post('/reservations/{reservation}/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');
    Route::post('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::post('/reservations/{reservation}/start', [ReservationController::class, 'start'])->name('reservations.start');
    Route::post('/reservations/{reservation}/finish', [ReservationController::class, 'finish'])->name('reservations.finish');

});

require __DIR__ . '/auth.php';
