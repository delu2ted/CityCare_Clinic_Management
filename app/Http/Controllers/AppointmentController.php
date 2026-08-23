<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient.user', 'doctor.user', 'department']);

        $user = auth()->user();
        if ($user->role === 'doctor' && $user->doctor) {
            $query->where('doctor_id', $user->doctor->id);
        } elseif ($user->role === 'patient' && $user->patient) {
            $query->where('patient_id', $user->patient->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_time', $request->date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient.user', fn ($u) => $u->where('name', 'like', "%{$search}%"))
                ->orWhereHas('doctor.user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $appointments = $query->orderByDesc('appointment_time')->paginate(10)->appends($request->query());

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        $departments = Department::all();

        return view('appointments.create', compact('patients', 'doctors', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'department_id' => 'required|exists:departments,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'notes' => 'nullable|string',
            'amount' => 'required|numeric|min:50,000',
            'payment_method' => 'required|string',
        ]);

        $dateTime = Carbon::parse($validated['appointment_date'] . ' ' . $validated['appointment_time']);
        $bufferMinutes = 5;

        $doctorId = $validated['doctor_id'] ?? null;

        if (!$doctorId) {
            $doctor = $this->findBestDoctor($validated['department_id'], $dateTime, $bufferMinutes);

            if (!$doctor) {
                return back()->withInput()->withErrors([
                    'appointment_time' => 'No doctors are available in this department at that time. Please try a different time or select a specific doctor.',
                ]);
            }

            $doctorId = $doctor->id;
        } else {
            $windowStart = (clone $dateTime)->subMinutes($bufferMinutes);
            $windowEnd = (clone $dateTime)->addMinutes($bufferMinutes);

            $clash = Appointment::where('doctor_id', $doctorId)
                ->where('status', '!=', 'cancelled')
                ->whereBetween('appointment_time', [$windowStart, $windowEnd])
                ->exists();

            if ($clash) {
                return back()->withInput()->withErrors([
                    'appointment_time' => 'This doctor already has an appointment too close to that time (a ' . $bufferMinutes . '-minute buffer is required between appointments). Please choose another slot.',
                ]);
            }
        }

        $appointment = Appointment::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $doctorId,
            'department_id' => $validated['department_id'],
            'appointment_time' => $dateTime,
            'status' => 'scheduled',
            'notes' => $validated['notes'] ?? null,
        ]);

        Payment::create([
            'appointment_id' => $appointment->id,
            'patient_id' => $validated['patient_id'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
        ]);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Appointment booked successfully! Your assigned doctor is ' . ($appointment->doctor->user->name ?? 'to be confirmed') . '. Payment status: pending.');
    }

    //Helper method to auto-pick the best doctor
    private function findBestDoctor($departmentId, $dateTime, $bufferMinutes = 5)
    {
        $doctors = Doctor::where('department_id', $departmentId)->get();

        $windowStart = (clone $dateTime)->subMinutes($bufferMinutes);
        $windowEnd = (clone $dateTime)->addMinutes($bufferMinutes);

        $eligible = [];

        foreach ($doctors as $doctor) {
            $clash = Appointment::where('doctor_id', $doctor->id)
                ->where('status', '!=', 'cancelled')
                ->whereBetween('appointment_time', [$windowStart, $windowEnd])
                ->exists();

            if (!$clash) {
                $todayCount = Appointment::where('doctor_id', $doctor->id)
                    ->whereDate('appointment_time', $dateTime->toDateString())
                    ->where('status', '!=', 'cancelled')
                    ->count();

                $eligible[] = ['doctor' => $doctor, 'count' => $todayCount];
            }
        }

        if (empty($eligible)) {
            return null;
        }

        usort($eligible, fn ($a, $b) => $a['count'] <=> $b['count']);

        return $eligible[0]['doctor'];
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'doctor.user', 'department', 'payment']);
        return view('appointments.show', compact('appointment'));
    }

    public function editConsultation(Appointment $appointment)
{
    abort_if(auth()->user()->role !== 'doctor', 403);
    abort_if($appointment->doctor_id !== auth()->user()->doctor->id, 403);

    return view('appointments.consultation', compact('appointment'));
}

    public function updateConsultation(Request $request, Appointment $appointment)
    {
        abort_if(auth()->user()->role !== 'doctor', 403);
        abort_if($appointment->doctor_id !== auth()->user()->doctor->id, 403);

        $validated = $request->validate([
            'diagnosis' => 'nullable|string',
            'consultation_notes' => 'nullable|string',
            'prescription' => 'nullable|string',
            'status' => 'required|in:scheduled,completed,cancelled,no_show',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Consultation notes saved.');
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        $departments = Department::all();

        return view('appointments.edit', compact('appointment', 'patients', 'doctors', 'departments'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'department_id' => 'nullable|exists:departments,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|in:scheduled,completed,cancelled,no_show',
            'notes' => 'nullable|string',
        ]);

        $dateTime = Carbon::parse($validated['appointment_date'] . ' ' . $validated['appointment_time']);

        $clash = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_time', $dateTime)
            ->where('status', '!=', 'cancelled')
            ->where('id', '!=', $appointment->id)
            ->exists();

        if ($clash) {
            return back()->withInput()->withErrors([
                'appointment_time' => 'This doctor already has another appointment at that time.',
            ]);
        }

        $appointment->update([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'department_id' => $validated['department_id'] ?? null,
            'appointment_time' => $dateTime,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment cancelled and removed.');
    }
}
