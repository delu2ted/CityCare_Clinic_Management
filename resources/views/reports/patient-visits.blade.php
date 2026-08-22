<x-dashboard-layout>
    <h2 class="h4 mb-4">Visit History — {{ $patient->user->name ?? 'N/A' }}</h2>
    <div class="dash-panel">
        <table class="table table-hover">
            <thead><tr><th>Date</th><th>Doctor</th><th>Department</th><th>Status</th><th>Payment</th></tr></thead>
            <tbody>
                @forelse($visits as $v)
                    <tr>
                        <td>{{ $v->appointment_time->format('d M Y, H:i') }}</td>
                        <td>{{ $v->doctor->user->name ?? 'N/A' }}</td>
                        <td>{{ $v->department->name ?? '—' }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($v->status) }}</span></td>
                        <td>{{ $v->payment ? 'UGX ' . number_format($v->payment->amount, 0) . ' — ' . ucfirst($v->payment->status) : 'Not recorded' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted">No visit history.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary mt-3">Back to Reports</a>
</x-dashboard-layout>