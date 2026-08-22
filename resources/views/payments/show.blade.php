<x-dashboard-layout>
    <h2 class="h4 mb-4">Payment Details</h2>

    <div class="dash-panel">
        <table class="table table-borderless mb-0">
            <tr><th style="width:200px">Patient</th><td>{{ $payment->patient->user->name ?? 'N/A' }}</td></tr>
            <tr><th>Doctor</th><td>{{ $payment->appointment->doctor->user->name ?? 'N/A' }}</td></tr>
            <tr><th>Appointment Date</th><td>{{ $payment->appointment?->appointment_time?->format('d M Y, H:i') ?? '—' }}</td></tr>
            <tr><th>Amount</th><td>UGX {{ number_format($payment->amount, 0) }}</td></tr>
            <tr><th>Method</th><td>{{ $payment->payment_method ?? '—' }}</td></tr>
            <tr><th>Status</th><td><span class="badge bg-secondary">{{ ucfirst(str_replace('_',' ',$payment->status)) }}</span></td></tr>
            <tr><th>Notes</th><td>{{ $payment->notes ?? '—' }}</td></tr>
        </table>
    </div>

    <div class="mt-3">
        @if(in_array(auth()->user()->role, ['admin','cashier']))
            <a href="{{ route('payments.edit', $payment) }}" class="btn btn-outline-primary">Edit</a>
        @endif
        <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Back to List</a>
    </div>
</x-dashboard-layout>