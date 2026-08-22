<x-dashboard-layout>
    <h2 class="h4 mb-4">Patient Profile</h2>

    <div class="dash-panel mb-3">
        <table class="table table-borderless mb-0">
            <tr><th style="width:200px">Name</th><td>{{ $patient->user->name ?? 'N/A' }}</td></tr>
            <tr><th>Email</th><td>{{ $patient->user->email ?? '—' }}</td></tr>
            <tr><th>Phone</th><td>{{ $patient->phone }}</td></tr>
            <tr><th>Date of Birth</th><td>{{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('d M Y') : '—' }}</td></tr>
            <tr><th>Blood Group</th><td>{{ $patient->blood_group ?? '—' }}</td></tr>
            <tr><th>Emergency Contact</th><td>{{ $patient->emergency_contact ?? '—' }} ({{ $patient->emergency_phone ?? '—' }})</td></tr>
            <tr><th>Medical History</th><td>{{ $patient->medical_history ?? '—' }}</td></tr>
        </table>
    </div>

    <div class="dash-panel mb-3">
        <h6 class="mb-3">Visit History</h6>
        @if($visitHistory->count())
            <table class="table">
                <thead><tr><th>Doctor</th><th>Date &amp; Time</th><th>Status</th></tr></thead>
                <tbody>
                    @foreach($visitHistory as $appt)
                        <tr>
                            <td>{{ $appt->doctor->user->name ?? 'N/A' }}</td>
                            <td>{{ $appt->appointment_time->format('d M Y, H:i') }}</td>
                            <td><span class="badge bg-secondary">{{ ucfirst($appt->status) }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted mb-0">No visit history.</p>
        @endif
    </div>

    <div class="dash-panel">
        <h6 class="mb-3">Payment History</h6>
        @if($payments->count())
            <table class="table">
                <thead><tr><th>Amount</th><th>Method</th><th>Status</th><th>Date</th></tr></thead>
                <tbody>
                    @foreach($payments as $pay)
                        <tr>
                            <td>${{ number_format($pay->amount, UGX {{ number_format($income, 0) }}) }}</td>
                            <td>{{ $pay->payment_method ?? '—' }}</td>
                            <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_',' ',$pay->status)) }}</span></td>
                            <td>{{ $pay->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted mb-0">No payment records.</p>
        @endif
    </div>

    <div class="mt-3">
        <a href="{{ route('patients.edit', $patient) }}" class="btn btn-outline-primary">Edit</a>
        <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">Back to List</a>
    </div>
</x-dashboard-layout>