<x-dashboard-layout>
    <h2 class="h4 mb-4">Record Payment</h2>

    <div class="dash-panel">
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Appointment</label>
                    <select name="appointment_id" class="form-select @error('appointment_id') is-invalid @enderror" required>
                        <option value="">Select appointment</option>
                        @foreach($appointments as $a)
                            <option value="{{ $a->id }}" {{ (old('appointment_id', $selectedAppointmentId) == $a->id) ? 'selected' : '' }}>
                                {{ $a->patient->user->name ?? 'N/A' }} — Dr. {{ $a->doctor->user->name ?? 'N/A' }} — {{ $a->appointment_time->format('d M Y, H:i') }}
                            </option>
                        @endforeach
                    </select>
                    @error('appointment_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">Only appointments without an existing payment are shown.</div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Amount ($)</label>
                    <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" required>
                    @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Payment Method</label>
                    <select name="payment_method" class="form-select" required>
                        <option value="Cash">Cash</option>
                        <option value="Card">Card</option>
                        <option value="Mobile Money">Mobile Money</option>
                        <option value="Insurance">Insurance</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="pending">Pending</option>
                        <option value="paid" selected>Paid</option>
                        <option value="partially_paid">Partially Paid</option>
                        <option value="refunded">Refunded</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Save Payment</button>
                <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</x-dashboard-layout>