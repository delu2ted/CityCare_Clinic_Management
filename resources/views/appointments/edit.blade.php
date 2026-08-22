<x-dashboard-layout>
    <h2 class="h4 mb-4">Edit Appointment</h2>

    <div class="dash-panel">
        <form action="{{ route('appointments.update', $appointment) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Patient</label>
                    <select name="patient_id" class="form-select" required>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}" {{ $appointment->patient_id == $p->id ? 'selected' : '' }}>{{ $p->user->name ?? 'Unknown' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Department</label>
                    <select name="department_id" class="form-select">
                        <option value="">None</option>
                        @foreach($departments as $d)
                            <option value="{{ $d->id }}" {{ $appointment->department_id == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Doctor</label>
                    <select name="doctor_id" class="form-select" required>
                        @foreach($doctors as $d)
                            <option value="{{ $d->id }}" {{ $appointment->doctor_id == $d->id ? 'selected' : '' }}>{{ $d->user->name ?? 'Unknown' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="appointment_date" class="form-control" value="{{ $appointment->appointment_time->format('Y-m-d') }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Time</label>
                    <input type="time" name="appointment_time" class="form-control" value="{{ $appointment->appointment_time->format('H:i') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        @foreach(['scheduled','completed','cancelled','no_show'] as $s)
                            <option value="{{ $s }}" {{ $appointment->status === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3">{{ $appointment->notes }}</textarea>
                </div>
            </div>

            @error('appointment_time')<div class="alert alert-danger mt-3">{{ $message }}</div>@enderror

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</x-dashboard-layout>