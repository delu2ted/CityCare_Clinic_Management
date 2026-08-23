<x-dashboard-layout>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0">Patients</h2>
        <a href="{{ route('patients.create') }}" class="btn btn-primary">Register Patient</a>
    </div>

    <div class="dash-panel mb-3 position-relative">
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" id="patient-instant-search" class="form-control" placeholder="Instant search by name or phone...">
                <div id="patient-search-results" class="position-absolute bg-white border rounded shadow-sm w-50" style="z-index:10;"></div>
            </div>
            <div class="col-md-6">
                <form method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Search (with pagination)..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>

    <div class="dash-panel">
        @if($patients->count())
            <table class="table table-hover align-middle">
                <thead>
                    <tr><th>Name</th><th>Phone</th><th>Blood Group</th><th>DOB</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @foreach($patients as $pat)
                        <tr>
                            <td>{{ $pat->user->name ?? 'N/A' }}</td>
                            <td>{{ $pat->phone }}</td>
                            <td>{{ $pat->blood_group ?? '—' }}</td>
                            <td>{{ $pat->date_of_birth ? \Carbon\Carbon::parse($pat->date_of_birth)->format('d M Y') : '—' }}</td>
                            <td>
                                <a href="{{ route('patients.show', $pat) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                <a href="{{ route('patients.edit', $pat) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deletePatient{{ $pat->id }}">Delete</button>

                                <x-confirm-delete-modal
                                    :id="'deletePatient' . $pat->id"
                                    :action="route('patients.destroy', $pat)"
                                    title="Remove Patient?"
                                    :message="'Remove ' . ($pat->user->name ?? 'this patient') . '? This also deletes their login account and medical records. This cannot be undone.'"
                                />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">{{ $patients->links() }}</div>
        @else
            <p class="text-muted mb-0">No patients found.</p>
        @endif
    </div>
</x-dashboard-layout>