<x-dashboard-layout>
    <h2 class="h4 mb-4">Doctor Dashboard</h2>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card tone-2">
                <div><div class="stat-label">Today's Appointments</div><div class="stat-value">{{ $todayCount }}</div></div>
                <div class="stat-icon">📅</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card tone-1">
                <div><div class="stat-label">Completed Visits</div><div class="stat-value">{{ $completedCount }}</div></div>
                <div class="stat-icon">✅</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card tone-4">
                <div><div class="stat-label">Upcoming</div><div class="stat-value">{{ $upcoming->count() }}</div></div>
                <div class="stat-icon">⏭️</div>
            </div>
        </div>
    </div>

    <div class="dash-panel">
        <h6 class="mb-3">Upcoming Appointments</h6>
        @if($upcoming->count())
            <table class="table">
                <thead><tr><th>Patient</th><th>Date &amp; Time</th><th>Status</th></tr></thead>
                <tbody>
                    @foreach($upcoming as $appt)
                        <tr>
                            <td>{{ $appt->patient->user->name ?? 'N/A' }}</td>
                            <td>{{ $appt->appointment_time->format('d M Y, H:i') }}</td>
                            <td><span class="badge bg-secondary">{{ ucfirst($appt->status) }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted mb-0">No upcoming appointments.</p>
        @endif
    </div>
</x-dashboard-layout>
