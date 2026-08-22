<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController; //from breeze
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;


// Home page
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes (Login/Register) - Provided by Breeze
require __DIR__.'/auth.php';

// Protected Routes (Requires Login)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard (Simple view for now)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Department Routes
    Route::resource('departments', DepartmentController::class);

    // Doctor Routes
    Route::resource('doctors', DoctorController::class);

    // Patient Routes
    Route::resource('patients', PatientController::class);
    Route::get('/api/patients/search', [PatientController::class, 'search'])->name('patients.search');

    // Appointment Routes
    Route::resource('appointments', AppointmentController::class);

    // Payment Routes
    Route::resource('payments', PaymentController::class);

    Route::get('/api/doctors/{doctor}/available-slots', [DoctorController::class, 'availableSlots'])->name('doctors.available-slots');
    
    Route::patch('/payments/{payment}/mark-paid', [PaymentController::class, 'markPaid'])->name('payments.mark-paid');
});
