<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'admin'         => $this->admin(),
            'doctor'        => $this->doctor(),
            'patient'       => $this->patient(),
            'cashier'       => $this->cashier(),
            'receptionist'  => $this->receptionist(),
            default         => view('dashboard.admin', ['doctorCount' => 0, 'patientCount' => 0, 'appointmentCount' => 0, 'income' => 0]),
        };
    }

    protected function admin()
    {
        $doctorCount = Doctor::count();
        $patientCount = Patient::count();
        $appointmentCount = Appointment::whereDate('appointment_time', today())->count();
        $income = Payment::where('status', 'paid')->sum('amount');

        $monthlyTraffic = Appointment::selectRaw('MONTH(appointment_time) as m, COUNT(*) as total')
            ->whereYear('appointment_time', now()->year)
            ->groupBy('m')->pluck('total', 'm');

        return view('dashboard.admin', compact('doctorCount', 'patientCount', 'appointmentCount', 'income', 'monthlyTraffic'));
    }

    protected function doctor()
    {
        $doctor = Auth::user()->doctor;
        $todayCount = $doctor ? Appointment::where('doctor_id', $doctor->id)->whereDate('appointment_time', today())->count() : 0;
        $upcoming = $doctor ? Appointment::where('doctor_id', $doctor->id)->where('appointment_time', '>=', now())->orderBy('appointment_time')->limit(5)->get() : collect();
        $completedCount = $doctor ? Appointment::where('doctor_id', $doctor->id)->where('status', 'completed')->count() : 0;

        return view('dashboard.doctor', compact('todayCount', 'upcoming', 'completedCount'));
    }

    protected function patient()
    {
        $patient = Auth::user()->patient;
        $upcoming = $patient ? Appointment::with(['doctor.user', 'payment'])->where('patient_id', $patient->id)->where('appointment_time', '>=', now())->orderBy('appointment_time')->limit(5)->get() : collect();
        $visitHistoryCount = $patient ? Appointment::where('patient_id', $patient->id)->where('status', 'completed')->count() : 0;
        $balanceDue = $patient ? Payment::where('patient_id', $patient->id)->where('status', 'pending')->sum('amount') : 0;

        return view('dashboard.patient', compact('upcoming', 'visitHistoryCount', 'balanceDue'));
    }

    protected function cashier()
    {
        $pendingCount = Payment::where('status', 'pending')->count();
        $pendingTotal = Payment::where('status', 'pending')->sum('amount');
        $todayCollected = Payment::where('status', 'paid')->whereDate('updated_at', today())->sum('amount');

        return view('dashboard.cashier', compact('pendingCount', 'pendingTotal', 'todayCollected'));
    }

    protected function receptionist()
    {
        $todayCount = Appointment::whereDate('appointment_time', today())->count();
        $todayList = Appointment::whereDate('appointment_time', today())->orderBy('appointment_time')->limit(6)->get();

        return view('dashboard.receptionist', compact('todayCount', 'todayList'));
    }
}