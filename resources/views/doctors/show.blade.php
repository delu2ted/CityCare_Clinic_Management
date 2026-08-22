<x-dashboard-layout>
    <h2 class="h4 mb-4">Doctor Details</h2>

    <div class="dash-panel mb-3">
        <table class="table table-borderless mb-0">
            <tr><th style="width:200px">Name</th><td>{{ $doctor->user->name ?? 'N/A' }}</td></tr>
            <tr><th>Email</th><td>{{ $doctor->user->email ?? '—' }}</td></tr>
            <tr><th>Department</th><td>{{ $doctor->department->name ?? '—' }}</td></tr>
            <tr><th>Specialization</th><td>{{ $doctor->specialization }}</td></tr>
            <tr><th>Phone</th><td>{{ $doctor->phone ?? '—' }}</td></tr>
        </table>
    </div>

    <div class="dash-panel">
        <h6 class="mb-3">Upcoming Appointments</h6>
        @if($upcomingAppointments->count())
            <table class="table">
                <thead><tr><th>Patient</th><th>Date &amp; Time</th><th>Status</th></tr></thead>
                <tbody>
                    @foreach($upcomingAppointments as $appt)
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

    <div class="mt-3">
        <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-outline-primary">Edit</a>
        <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary">Back to List</a>
    </div>
</x-dashboard-layout>