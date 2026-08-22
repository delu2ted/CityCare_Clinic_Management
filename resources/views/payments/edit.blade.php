<x-dashboard-layout>
    <h2 class="h4 mb-4">Edit Payment</h2>

    <div class="dash-panel">
        <form action="{{ route('payments.update', $payment) }}" method="POST">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Amount ($)</label>
                    <input type="number" step="0.01" name="amount" class="form-control" value="{{ $payment->amount }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Payment Method</label>
                    <select name="payment_method" class="form-select" required>
                        @foreach(['Cash','Card','Mobile Money','Insurance'] as $m)
                            <option value="{{ $m }}" {{ $payment->payment_method === $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        @foreach(['pending','paid','partially_paid','refunded'] as $s)
                            <option value="{{ $s }}" {{ $payment->status === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ $payment->notes }}</textarea>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</x-dashboard-layout>