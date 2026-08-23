<x-dashboard-layout>
    <h2 class="h4 mb-4">My Dashboard</h2>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card tone-2">
                <div><div class="stat-label">Upcoming Appointments</div><div class="stat-value">{{ $upcoming->count() }}</div></div>
                <div class="stat-icon">📅</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card tone-1">
                <div><div class="stat-label">Past Visits</div><div class="stat-value">{{ $visitHistoryCount }}</div></div>
                <div class="stat-icon">🗂️</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card tone-4">
                <div><div class="stat-label">Balance Due</div><div class="stat-value">UGX {{ number_format($balanceDue, 0) }}</div></div>
                <div class="stat-icon">💳</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3"><a href="{{ route('appointments.create') }}" class="quick-action"><div class="qa-icon">➕</div>Book Appointment</a></div>
        <div class="col-6 col-md-3"><a href="{{ route('payments.index') }}" class="quick-action"><div class="qa-icon">💳</div>My Payments</a></div>
    </div>

    <div class="dash-panel">
    <h6 class="mb-3">Upcoming Appointments</h6>
    @if($upcoming->count())
        <table class="table">
            <thead><tr><th>Doctor</th><th>Date &amp; Time</th><th>Status</th><th>Payment</th></tr></thead>
            <tbody>
                @foreach($upcoming as $appt)
                    <tr>
                        <td>{{ $appt->doctor->user->name ?? 'N/A' }}</td>
                        <td>{{ $appt->appointment_time->format('d M Y, H:i') }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($appt->status) }}</span></td>
                        <td>
                            @if($appt->payment)
                                UGX{{ number_format($appt->payment->amount, 2) }} —
                                <span class="badge {{ $appt->payment->status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ ucfirst(str_replace('_',' ',$appt->payment->status)) }}
                                </span>
                            @else
                                <span class="text-muted">Not recorded</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted mb-0">No upcoming appointments. <a href="{{ route('appointments.create') }}">Book one now.</a></p>
    @endif
</div>

</x-dashboard-layout>