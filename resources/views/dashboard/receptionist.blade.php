<x-dashboard-layout>
    <h2 class="h4 mb-4">Reception Dashboard</h2>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card tone-2">
                <div><div class="stat-label">Appointments Today</div><div class="stat-value">{{ $todayCount }}</div></div>
                <div class="stat-icon">📅</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3"><a href="{{ route('appointments.create') }}" class="quick-action"><div class="qa-icon">➕</div>Book Appointment</a></div>
        <div class="col-6 col-md-3"><a href="{{ route('patients.create') }}" class="quick-action"><div class="qa-icon">🧑‍🤝‍🧑</div>New Patient</a></div>
        <div class="col-6 col-md-3"><a href="{{ route('appointments.index') }}" class="quick-action"><div class="qa-icon">📋</div>All Appointments</a></div>
    </div>

    <div class="dash-panel">
        <h6 class="mb-3">Today's Schedule</h6>
        @if($todayList->count())
            <table class="table">
                <thead><tr><th>Time</th><th>Patient</th><th>Doctor</th><th>Status</th></tr></thead>
                <tbody>
                    @foreach($todayList as $appt)
                        <tr>
                            <td>{{ $appt->appointment_time->format('H:i') }}</td>
                            <td>{{ $appt->patient->user->name ?? 'N/A' }}</td>
                            <td>{{ $appt->doctor->user->name ?? 'N/A' }}</td>
                            <td><span class="badge bg-secondary">{{ ucfirst($appt->status) }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted mb-0">No appointments scheduled for today.</p>
        @endif
    </div>
</x-dashboard-layout>