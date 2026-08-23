<x-dashboard-layout>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0">Payments</h2>
        @if(in_array(auth()->user()->role, ['admin','cashier']))
            <a href="{{ route('payments.create') }}" class="btn btn-primary">Record Payment</a>
        @endif
    </div>

    <div class="dash-panel mb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search patient..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All statuses</option>
                    @foreach(['pending','paid','partially_paid','refunded'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary w-100" type="submit">Filter</button>
            </div>
        </form>
    </div>

    <div class="dash-panel">
        @if($payments->count())
            <table class="table table-hover align-middle">
                <thead>
                    <tr><th>Patient</th><th>Appointment Date</th><th>Amount</th><th>Method</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @foreach($payments as $pay)
                        <tr>
                            <td>{{ $pay->patient->user->name ?? 'N/A' }}</td>
                            <td>{{ $pay->appointment?->appointment_time?->format('d M Y') ?? '—' }}</td>
                            <td>UGX {{ number_format($pay->amount, 0) }}</td>
                            <td>{{ $pay->payment_method ?? '—' }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ ucfirst(str_replace('_',' ',$pay->status)) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('payments.show', $pay) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                @if(in_array(auth()->user()->role, ['admin','cashier']))
                                    <a href="{{ route('payments.edit', $pay) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    @if($pay->status === 'pending')
                                        <form action="{{ route('payments.mark-paid', $pay) }}" method="POST" class="d-inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-success">Mark Paid</button>
                                        </form>
                                    @endif
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deletePayment{{ $pay->id }}">Delete</button>

<x-confirm-delete-modal
    :id="'deletePayment' . $pay->id"
    :action="route('payments.destroy', $pay)"
    title="Delete Payment Record?"
    message="This will permanently delete this payment record. This cannot be undone."
/>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">{{ $payments->links() }}</div>
        @else
            <p class="text-muted mb-0">No payment records found.</p>
        @endif
    </div>
</x-dashboard-layout>