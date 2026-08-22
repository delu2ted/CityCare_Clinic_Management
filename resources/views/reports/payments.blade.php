<x-dashboard-layout>
    <h2 class="h4 mb-4">Payments Report</h2>
    <div class="dash-panel mb-3">
        <strong>Total Collected (Paid):</strong> UGX {{ number_format($totalAmount, 0) }}
    </div>
    <div class="dash-panel">
        <table class="table table-hover">
            <thead><tr><th>Patient</th><th>Amount</th><th>Method</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
                @forelse($payments as $p)
                    <tr>
                        <td>{{ $p->patient->user->name ?? 'N/A' }}</td>
                        <td>UGX {{ number_format($p->amount, 0) }}</td>
                        <td>{{ $p->payment_method ?? '—' }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_',' ',$p->status)) }}</span></td>
                        <td>{{ $p->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted">No results for this filter.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary mt-3">Back to Reports</a>
</x-dashboard-layout>