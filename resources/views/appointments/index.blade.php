<x-dashboard-layout>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0">Appointments</h2>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary">Book Appointment</a>
    </div>

    <div class="dash-panel mb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search patient or doctor..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All statuses</option>
                    @foreach(['scheduled','completed','cancelled','no_show'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary w-100" type="submit">Filter</button>
            </div>
        </form>
    </div>

    <div class="dash-panel">
        @if($appointments->count())
            <table class="table table-hover align-middle">
                <thead>
                    <tr><th>Patient</th><th>Doctor</th><th>Department</th><th>Date &amp; Time</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appt)
                        <tr>
                            <td>{{ $appt->patient->user->name ?? 'N/A' }}</td>
                            <td>{{ $appt->doctor->user->name ?? 'N/A' }}</td>
                            <td>{{ $appt->department->name ?? '—' }}</td>
                            <td>{{ $appt->appointment_time->format('d M Y, H:i') }}</td>
                            <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_',' ',$appt->status)) }}</span></td>
                            <td>
                                <a href="{{ route('appointments.show', $appt) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                <a href="{{ route('appointments.edit', $appt) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAppt{{ $appt->id }}">Delete</button>

                                <x-confirm-delete-modal
                                    :id="'deleteAppt' . $appt->id"
                                    :action="route('appointments.destroy', $appt)"
                                    title="Cancel Appointment?"
                                    message="This will permanently delete this appointment record. This cannot be undone."
                                />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">{{ $appointments->links() }}</div>
        @else
            <p class="text-muted mb-0">No appointments found.</p>
        @endif
    </div>
</x-dashboard-layout>