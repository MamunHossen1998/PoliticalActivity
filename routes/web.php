<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\LoginController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\BranchController;
use App\Http\Controllers\Backend\SpecializationController;
use App\Http\Controllers\Backend\DoctorController;
use App\Http\Controllers\Backend\AppoinmentController;

// Constrain dynamic segment
Route::pattern('segment', '[A-Za-z0-9_-]+');

// Legacy /dashboard redirect → segmented dashboard
Route::middleware('web')->get('dashboard', function () {
    $segment = session('route_segment');
    if ($segment) {
        return redirect()->route('dashboard', ['segment' => $segment]);
    }
    return redirect()->route('login');
});
Route::redirect('/', 'login');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/auth', [LoginController::class, 'authenticate'])->name('auth.authenticate');
Route::post('logout', [LoginController::class, 'logout'])->name('auth.logout');


Route::middleware(['web', 'auth', 'ensure.segment'])->prefix('{segment}')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    ### Admin Users
    Route::prefix('users')->name('users.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{user}/edit', 'edit')->name('edit');
        Route::put('/{user}', 'update')->name('update');
        Route::delete('/{user}', 'destroy')->name('destroy');
    });

    ### Admin Branches
    Route::prefix('branches')->name('branches.')->controller(BranchController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{branch}/edit', 'edit')->name('edit');
        Route::put('/{branch}', 'update')->name('update');
        Route::delete('/{branch}', 'destroy')->name('destroy');
    });

    ### Admin Specializations

    Route::prefix('specializations')->name('specializations.')->controller(SpecializationController::class)
->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{specialization}/edit', 'edit')->name('edit');
        Route::put('/{specialization}', 'update')->name('update');
        Route::delete('/{specialization}', 'destroy')->name('destroy');
    });

    ### Admin Doctors (full-page)
    Route::prefix('doctors')->name('doctors.')->controller(DoctorController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{doctor}/edit', 'edit')->name('edit');
        Route::put('/{doctor}', 'update')->name('update');
        Route::delete('/{doctor}', 'destroy')->name('destroy');
    });

    ### Appointment Setup
    Route::prefix('appoinment')->name('appoinment.')->controller(AppoinmentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/doctors/data', 'doctorsData')->name('doctors.data');
        Route::get('/doctors/{doctor}', 'showDoctor')->name('doctors.show');
        Route::get('/appointments', 'appointmentsList')->name('appointments.list');
        Route::post('/appointments', 'store')->name('appointments.store');
    });
});

