<x-dashboard-layout>
    <h2 class="h4 mb-4">Doctor Schedule — {{ $doctor->user->name ?? 'N/A' }} ({{ $date }})</h2>
    <div class="dash-panel">
        <table class="table table-hover">
            <thead><tr><th>Time</th><th>Patient</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($appointments as $a)
                    <tr>
                        <td>{{ $a->appointment_time->format('H:i') }}</td>
                        <td>{{ $a->patient->user->name ?? 'N/A' }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($a->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-muted">No appointments this day.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary mt-3">Back to Reports</a>
</x-dashboard-layout>