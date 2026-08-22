<x-dashboard-layout>
    <h2 class="h4 mb-4">Appointments Report</h2>
    <div class="dash-panel">
        <table class="table table-hover">
            <thead><tr><th>Patient</th><th>Doctor</th><th>Department</th><th>Date &amp; Time</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($appointments as $a)
                    <tr>
                        <td>{{ $a->patient->user->name ?? 'N/A' }}</td>
                        <td>{{ $a->doctor->user->name ?? 'N/A' }}</td>
                        <td>{{ $a->department->name ?? '—' }}</td>
                        <td>{{ $a->appointment_time->format('d M Y, H:i') }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_',' ',$a->status)) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted">No results for this filter.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary mt-3">Back to Reports</a>
</x-dashboard-layout>