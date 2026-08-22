<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Payment;
use App\Models\Patient;
use App\Models\Department;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AppointmentsExport;
use App\Exports\PaymentsExport;
use App\Exports\DoctorScheduleExport;
use App\Exports\PatientVisitsExport;

class ReportController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        $doctors = Doctor::with('user')->get();

        return view('reports.index', compact('departments', 'doctors'));
    }

    public function appointments(Request $request)
    {
        $query = Appointment::with(['patient.user', 'doctor.user', 'department']);

        if ($request->filled('date_from')) {
            $query->whereDate('appointment_time', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('appointment_time', '<=', $request->date_to);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $appointments = $query->orderBy('appointment_time')->get();
        $format = $request->query('format', 'view');

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdf.appointments', compact('appointments'));
            return $pdf->download('appointments-report-' . now()->format('Y-m-d') . '.pdf');
        }

        if ($format === 'excel') {
            return Excel::download(new AppointmentsExport($appointments), 'appointments-report-' . now()->format('Y-m-d') . '.xlsx');
        }

        if ($format === 'csv') {
            return Excel::download(new AppointmentsExport($appointments), 'appointments-report-' . now()->format('Y-m-d') . '.csv');
        }

        return view('reports.appointments', compact('appointments'));
    }

    public function doctorSchedule(Request $request)
    {
        $doctorId = $request->query('doctor_id');
        $date = $request->query('date', now()->toDateString());

        $doctor = Doctor::with('user')->findOrFail($doctorId);

        $appointments = Appointment::with(['patient.user'])
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_time', $date)
            ->orderBy('appointment_time')
            ->get();

        $format = $request->query('format', 'view');

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdf.doctor-schedule', compact('doctor', 'appointments', 'date'));
            return $pdf->download('doctor-schedule-' . $date . '.pdf');
        }

        if ($format === 'excel' || $format === 'csv') {
            $ext = $format === 'excel' ? 'xlsx' : 'csv';
            return Excel::download(new DoctorScheduleExport($appointments), 'doctor-schedule-' . $date . '.' . $ext);
        }

        return view('reports.doctor-schedule', compact('doctor', 'appointments', 'date'));
    }

    public function payments(Request $request)
    {
        $query = Payment::with(['patient.user', 'appointment']);

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->orderByDesc('created_at')->get();
        $totalAmount = $payments->where('status', 'paid')->sum('amount');
        $format = $request->query('format', 'view');

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdf.payments', compact('payments', 'totalAmount'));
            return $pdf->download('payments-report-' . now()->format('Y-m-d') . '.pdf');
        }

        if ($format === 'excel' || $format === 'csv') {
            $ext = $format === 'excel' ? 'xlsx' : 'csv';
            return Excel::download(new PaymentsExport($payments), 'payments-report-' . now()->format('Y-m-d') . '.' . $ext);
        }

        return view('reports.payments', compact('payments', 'totalAmount'));
    }

    public function patientVisits(Request $request)
    {
        $patientId = $request->query('patient_id');
        $patient = Patient::with('user')->findOrFail($patientId);

        $visits = Appointment::with(['doctor.user', 'department', 'payment'])
            ->where('patient_id', $patientId)
            ->orderByDesc('appointment_time')
            ->get();

        $format = $request->query('format', 'view');

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdf.patient-visits', compact('patient', 'visits'));
            return $pdf->download('patient-visits-' . $patient->id . '.pdf');
        }

        if ($format === 'excel' || $format === 'csv') {
            $ext = $format === 'excel' ? 'xlsx' : 'csv';
            return Excel::download(new PatientVisitsExport($visits), 'patient-visits-' . $patient->id . '.' . $ext);
        }

        return view('reports.patient-visits', compact('patient', 'visits'));
    }
}