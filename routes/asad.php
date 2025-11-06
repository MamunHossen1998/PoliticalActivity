<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\AppointmentStatusController;
use App\Http\Controllers\Backend\LeaveReasonController;
use App\Http\Controllers\Backend\ExportAppointmentController;

Route::pattern('segment', '[A-Za-z0-9_-]+');
Route::middleware(['web', 'auth', 'ensure.segment'])->prefix('{segment}')->group(function () {
    ### Admin Appointment Statuses
    Route::prefix('appointment-status')->name('appointment-status.')->controller(AppointmentStatusController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{appointment_status}/edit', 'edit')->name('edit');
        Route::put('/{appointment_status}', 'update')->name('update');
        Route::delete('/{appointment_status}', 'destroy')->name('destroy');
    });
    Route::prefix('leave-reason')->name('leave-reason.')->controller(LeaveReasonController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{leave_reason}/edit', 'edit')->name('edit');
        Route::put('/{leave_reason}', 'update')->name('update');
        Route::delete('/{leave_reason}', 'destroy')->name('destroy');
    });
    Route::prefix('export-appointment')->name('export-appointment.')->controller(ExportAppointmentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::get('/export-pdf', 'exportPdf')->name('exportPdf');
    });
});
