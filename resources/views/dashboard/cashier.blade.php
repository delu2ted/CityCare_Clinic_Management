<x-dashboard-layout>
    <h2 class="h4 mb-4">Cashier Dashboard</h2>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card tone-4">
                <div><div class="stat-label">Pending Payments</div><div class="stat-value">{{ $pendingCount }}</div></div>
                <div class="stat-icon">⏳</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card tone-1">
                <div><div class="stat-label">Pending Total</div><div class="stat-value">${{ number_format($pendingTotal, 0}}</div></div>
                <div class="stat-icon">💵</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card tone-2">
                <div><div class="stat-label">Collected Today</div><div class="stat-value">${{ number_format($todayCollected, UGX {{ number_format($income, 0) }}) }}</div></div>
                <div class="stat-icon">✅</div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-6 col-md-3"><a href="{{ route('payments.create') }}" class="quick-action"><div class="qa-icon">➕</div>Record Payment</a></div>
        <div class="col-6 col-md-3"><a href="{{ route('payments.index') }}" class="quick-action"><div class="qa-icon">📋</div>All Payments</a></div>
    </div>
</x-dashboard-layout>