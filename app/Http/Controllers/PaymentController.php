<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['appointment', 'patient.user']);

        $user = auth()->user();
        if ($user->role === 'patient' && $user->patient) {
            $query->where('patient_id', $user->patient->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient.user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
        }

        $payments = $query->orderByDesc('created_at')->paginate(10)->appends($request->query());

        return view('payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->whereDoesntHave('payment')
            ->orderByDesc('appointment_time')
            ->get();

        $selectedAppointmentId = $request->query('appointment_id');

        return view('payments.create', compact('appointments', 'selectedAppointmentId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'status' => 'required|in:pending,paid,partially_paid,refunded',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::findOrFail($validated['appointment_id']);

        Payment::create([
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load(['appointment.doctor.user', 'patient.user']);
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return view('payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'status' => 'required|in:pending,paid,partially_paid,refunded',
            'notes' => 'nullable|string',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }

    public function markPaid(Payment $payment)
    {
        $payment->update(['status' => 'paid']);
        return redirect()->route('payments.index')->with('success', 'Payment marked as paid.');
    }
}