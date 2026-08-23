<x-dashboard-layout>
    <h2 class="h4 mb-4">Book Appointment</h2>

    <div class="dash-panel">
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                @if(in_array(auth()->user()->role, ['admin','receptionist']))
                    <div class="col-md-6">
                        <label class="form-label">Patient</label>
                        <select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                            <option value="">Select patient</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}" {{ old('patient_id') == $p->id ? 'selected' : '' }}>{{ $p->user->name ?? 'Unknown' }}</option>
                            @endforeach
                        </select>
                        @error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                @else
                    <input type="hidden" name="patient_id" value="{{ auth()->user()->patient->id ?? '' }}">
                @endif

                <div class="col-md-6">
                    <label class="form-label">Department</label>
                    <select name="department_id" id="department_id" class="form-select @error('department_id') is-invalid @enderror" required>
                        <option value="">Select department</option>
                        @foreach($departments as $d)
                            <option value="{{ $d->id }}" {{ old('department_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Doctor</label>
                    <select name="doctor_id" id="doctor_id" class="form-select" data-all-doctors="{{ $doctors->toJson() }}">
                        <option value="">Any available doctor in this department</option>
                    </select>
                    <div class="form-text">Not sure? Leave this on "Any available doctor"</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Date</label>
                    <input type="date" name="appointment_date" id="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" value="{{ old('appointment_date') }}" min="{{ date('Y-m-d') }}" required>
                    @error('appointment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Preferred Time</label>
                    <input type="time" name="appointment_time" id="appointment_time" class="form-control @error('appointment_time') is-invalid @enderror" value="{{ old('appointment_time') }}" required>
                    @error('appointment_time')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    <div class="form-text">Clinic hours: 9:00 AM – 5:00 PM.</div>
                </div>

                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                </div>

                <div class="col-md-6">
    <label class="form-label">Consulation Fee (UGX)</label>
    <input type="number" step="1000" min="50000" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', 50000) }}" required>
    @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
    <div class="form-text">Minimum consultation fee: UGX 50,000</div>
</div>

<div class="col-md-6">
    <label class="form-label">Payment Method</label>
    <select name="payment_method" id="payment_method" class="form-select" required>
        <option value="Cash">Cash (pay at clinic)</option>
        <option value="Card">Card</option>
        <option value="Mobile Money">Mobile Money</option>
        <option value="Insurance">Insurance</option>
    </select>
    <div class="form-text">Payment is recorded as pending until confirmed by our cashier at your visit.</div>
</div>

<div class="col-12" id="mobile_money_fields" style="display:none;">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Mobile Money Number</label>
            <input type="text" name="mobile_money_number" class="form-control" placeholder="e.g. 0770 000 000">
        </div>
        <div class="col-md-6">
            <label class="form-label">Provider</label>
            <select name="mobile_money_provider" class="form-select">
                <option>MTN Mobile Money</option>
                <option>Airtel Money</option>
            </select>
        </div>
    </div>
</div>

<div class="col-12" id="card_fields" style="display:none;">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Card Number</label>
            <input type="text" name="card_number" class="form-control" placeholder="1234 5678 9012 3456">
        </div>
        <div class="col-md-3">
            <label class="form-label">Expiry</label>
            <input type="text" name="card_expiry" class="form-control" placeholder="MM/YY">
        </div>
        <div class="col-md-3">
            <label class="form-label">CVV</label>
            <input type="text" name="card_cvv" class="form-control" placeholder="123">
        </div>
    </div>
</div>

<div class="col-12" id="insurance_fields" style="display:none;">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Insurance Provider</label>
            <input type="text" name="insurance_provider" class="form-control" placeholder="e.g. Jubilee Insurance">
        </div>
        <div class="col-md-6">
            <label class="form-label">Policy Number</label>
            <input type="text" name="insurance_policy_number" class="form-control" placeholder="e.g. POL-2026-00123">
        </div>
    </div>
</div>

            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Book Appointment</button>
                <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</x-dashboard-layout>