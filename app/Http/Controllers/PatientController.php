<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhere('phone', 'like', "%{$search}%");
        }

        $patients = $query->orderBy('id', 'desc')->paginate(10)->appends($request->query());

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string|max:10',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
            'medical_history' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'patient',
        ]);

        Patient::create([
            'user_id' => $user->id,
            'phone' => $validated['phone'],
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'blood_group' => $validated['blood_group'] ?? null,
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'emergency_phone' => $validated['emergency_phone'] ?? null,
            'medical_history' => $validated['medical_history'] ?? null,
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient registered successfully.');
    }

    public function show(Patient $patient)
    {
        $patient->load('user');

        $visitHistory = Appointment::with('doctor.user')
            ->where('patient_id', $patient->id)
            ->orderByDesc('appointment_time')
            ->limit(15)
            ->get();

        $payments = $patient->payments()->orderByDesc('created_at')->limit(10)->get();

        return view('patients.show', compact('patient', 'visitHistory', 'payments'));
    }

    public function edit(Patient $patient)
    {
        $patient->load('user');
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $patient->user_id,
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string|max:10',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
            'medical_history' => 'nullable|string',
        ]);

        $patient->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $patient->update([
            'phone' => $validated['phone'],
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'blood_group' => $validated['blood_group'] ?? null,
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'emergency_phone' => $validated['emergency_phone'] ?? null,
            'medical_history' => $validated['medical_history'] ?? null,
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $user = $patient->user;
        $patient->delete();
        $user?->delete();

        return redirect()->route('patients.index')->with('success', 'Patient removed successfully.');
    }

    /**
     * AJAX instant search endpoint
     */
    public function search(Request $request)
    {
        $q = $request->query('q');

        $patients = Patient::with('user')
            ->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$q}%"))
            ->orWhere('phone', 'like', "%{$q}%")
            ->limit(8)
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'full_name' => $p->user->name ?? 'Unknown',
                'phone' => $p->phone,
            ]);

        return response()->json($patients);
    }
}