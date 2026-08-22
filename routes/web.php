<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController; //from breeze
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;


// Home page
Route::get('/', function () {
    return view('welcome', [
        'departments' => \App\Models\Department::all(),
        'doctors' => \App\Models\Doctor::with('user')->limit(6)->get(),
    ]);
});

// Auth Routes (Login/Register) - Provided by Breeze
require __DIR__.'/auth.php';

// Protected Routes (Requires Login)
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Departments — admin only
    Route::middleware('role:admin')->group(function () {
        Route::resource('departments', DepartmentController::class);
    });

    // Doctors — admin and receptionist manage; doctor/patient can view their own via dashboard, not full list
    Route::middleware('role:admin')->group(function () {
    Route::get('/doctors/create', [DoctorController::class, 'create'])->name('doctors.create');
    Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');
    Route::get('/doctors/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
    Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
    Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
    });

    Route::middleware('role:admin,receptionist,doctor')->group(function () {
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
    });

    // Patients — admin and receptionist manage; doctor can view; patient can view their own
    Route::middleware('role:admin,receptionist')->group(function () {
        Route::resource('patients', PatientController::class)->except(['show']);
    });
    Route::middleware('role:admin,receptionist,doctor,patient')->group(function () {
        Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
    });

    // Appointments — admin, receptionist, doctor, patient all interact with these
    Route::middleware('role:admin,receptionist,doctor,patient')->group(function () {
        Route::resource('appointments', AppointmentController::class);
    });

    // Payments — admin and cashier manage; patient can view their own
    Route::middleware('role:admin,cashier')->group(function () {
        Route::resource('payments', PaymentController::class)->except(['index', 'show']);
        Route::patch('/payments/{payment}/mark-paid', [PaymentController::class, 'markPaid'])->name('payments.mark-paid');
    });
    Route::middleware('role:admin,cashier,patient')->group(function () {
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    });

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // AJAX / API-style endpoints
    Route::get('/api/doctors/{doctor}/available-slots', [DoctorController::class, 'availableSlots'])->name('doctors.available-slots');
    Route::get('/api/patients/search', [PatientController::class, 'search'])->name('patients.search');


    //report routes
    Route::middleware('role:admin,cashier,receptionist,doctor')->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/appointments', [ReportController::class, 'appointments'])->name('reports.appointments');
    Route::get('/reports/doctor-schedule', [ReportController::class, 'doctorSchedule'])->name('reports.doctor-schedule');
    Route::get('/reports/payments', [ReportController::class, 'payments'])->name('reports.payments');
    Route::get('/reports/patient-visits', [ReportController::class, 'patientVisits'])->name('reports.patient-visits');
        });

    
});
