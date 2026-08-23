<x-dashboard-layout>
    <h2 class="h4 mb-4">Appointment Details</h2>

    <div class="dash-panel">
        <table class="table table-borderless mb-0">
            <tr><th style="width:200px">Patient</th><td>{{ $appointment->patient->user->name ?? 'N/A' }}</td></tr>
            <tr><th>Doctor</th><td>{{ $appointment->doctor->user->name ?? 'N/A' }}</td></tr>
            <tr><th>Department</th><td>{{ $appointment->department->name ?? '—' }}</td></tr>
            <tr><th>Date &amp; Time</th><td>{{ $appointment->appointment_time->format('d M Y, H:i') }}</td></tr>
            <tr><th>Status</th><td><span class="badge bg-secondary">{{ ucfirst(str_replace('_',' ',$appointment->status)) }}</span></td></tr>
            <tr><th>Notes</th><td>{{ $appointment->notes ?? '—' }}</td></tr>
            @if($appointment->diagnosis || $appointment->consultation_notes || $appointment->prescription)
                <tr><th>Diagnosis</th><td>{{ $appointment->diagnosis ?? '—' }}</td></tr>
                <tr><th>Consultation Notes</th><td>{{ $appointment->consultation_notes ?? '—' }}</td></tr>
                <tr><th>Prescription</th><td>{{ $appointment->prescription ?? '—' }}</td></tr>
            @endif
            <tr><th>Payment</th><td>
                @if($appointment->payment)
                    UGX {{ number_format($appointment->payment->amount, UGX {{ number_format($income, 0) }}) }} — {{ ucfirst($appointment->payment->status) }}
                @else
                    <a href="{{ route('payments.create') }}?appointment_id={{ $appointment->id }}">Record payment</a>
                @endif
            </td></tr>
        </table>
    </div>

    <div class="mt-3">
        @if(auth()->user()->role === 'doctor' && $appointment->doctor_id === (auth()->user()->doctor->id ?? null))
            <a href="{{ route('appointments.consultation.edit', $appointment) }}" class="btn btn-primary">Complete Consultation</a>
        @endif
        @if(in_array(auth()->user()->role, ['admin','receptionist']))
            <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-outline-primary">Edit</a>
        @endif
        <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">Back to List</a>
    </div>

</x-dashboard-layout>