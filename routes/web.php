<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController; //from breeze
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PaymentController;



// Home page
Route::get('/', function () {
    return view('dashboard');
});

// Auth Routes (Login/Register) - Provided by Breeze
require __DIR__.'/auth.php';

// Protected Routes (Requires Login)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard (Simple view for now)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Department Routes
    Route::resource('departments', DepartmentController::class);

    // Doctor Routes
    Route::resource('doctors', DoctorController::class);

    // Patient Routes
    Route::resource('patients', PatientController::class);

    // Appointment Routes
    Route::resource('appointments', AppointmentController::class);

    // Payment Routes
    Route::resource('payments', PaymentController::class);
});
