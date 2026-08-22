<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::with(['user', 'department']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhere('specialization', 'like', "%{$search}%");
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $doctors = $query->orderBy('id', 'desc')->paginate(10)->appends($request->query());
        $departments = Department::all();

        return view('doctors.index', compact('doctors', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('doctors.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'department_id' => 'nullable|exists:departments,id',
            'specialization' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'department_id' => $validated['department_id'] ?? null,
            'specialization' => $validated['specialization'],
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'],
        ]);

        return redirect()->route('doctors.index')->with('success', 'Doctor added successfully.');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'department']);
        $upcomingAppointments = Appointment::with('patient.user')
            ->where('doctor_id', $doctor->id)
            ->where('appointment_time', '>=', now())
            ->orderBy('appointment_time')
            ->limit(10)
            ->get();

        return view('doctors.show', compact('doctor', 'upcomingAppointments'));
    }

    public function edit(Doctor $doctor)
    {
        $doctor->load('user');
        $departments = Department::all();
        return view('doctors.edit', compact('doctor', 'departments'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $doctor->user_id,
            'department_id' => 'nullable|exists:departments,id',
            'specialization' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $doctor->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $doctor->update([
            'department_id' => $validated['department_id'] ?? null,
            'specialization' => $validated['specialization'],
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'],
        ]);

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor)
    {
        $user = $doctor->user;
        $doctor->delete();
        $user?->delete();

        return redirect()->route('doctors.index')->with('success', 'Doctor removed successfully.');
    }

    public function availableSlots(Doctor $doctor, Request $request)
    {
        $date = $request->query('date');
        if (!$date) {
            return response()->json(['slots' => []]);
        }

        $start = \Carbon\Carbon::parse($date)->setTime(9, 0);
        $end = \Carbon\Carbon::parse($date)->setTime(17, 0);

        $booked = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_time', $date)
            ->where('status', '!=', 'cancelled')
            ->pluck('appointment_time')
            ->map(fn ($t) => \Carbon\Carbon::parse($t)->format('H:i'))
            ->toArray();

        $slots = [];
        for ($time = $start->copy(); $time->lt($end); $time->addMinutes(30)) {
            $value = $time->format('H:i');
            if (!in_array($value, $booked)) {
                $slots[] = ['value' => $value, 'label' => $time->format('g:i A')];
            }
        }

        return response()->json(['slots' => $slots]);
    }
}