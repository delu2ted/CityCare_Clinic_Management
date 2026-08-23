<x-dashboard-layout>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0">Doctors</h2>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('doctors.create') }}" class="btn btn-primary">Add Doctor</a>
        @endif
    </div>

    <div class="dash-panel mb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Search name or specialization..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="department_id" class="form-select">
                    <option value="">All departments</option>
                    @foreach($departments as $d)
                        <option value="{{ $d->id }}" {{ request('department_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-secondary w-100" type="submit">Filter</button>
            </div>
        </form>
    </div>

    <div class="dash-panel">
        @if($doctors->count())
            <table class="table table-hover align-middle">
                <thead>
                    <tr><th>Name</th><th>Specialization</th><th>Department</th><th>Phone</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @foreach($doctors as $doc)
                        <tr>
                            <td>{{ $doc->user->name ?? 'N/A' }}</td>
                            <td>{{ $doc->specialization }}</td>
                            <td>{{ $doc->department->name ?? '—' }}</td>
                            <td>{{ $doc->phone ?? '—' }}</td>
                            <td>
                                <a href="{{ route('doctors.show', $doc) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('doctors.edit', $doc) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteDoctor{{ $doc->id }}">Delete</button>

                                    <x-confirm-delete-modal
                                        :id="'deleteDoctor' . $doc->id"
                                        :action="route('doctors.destroy', $doc)"
                                        title="Remove Doctor?"
                                        :message="'Remove' . ($doc->user->name ?? 'this doctor') . '? This also deletes their login account. This cannot be undone.'"
                                    />
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">{{ $doctors->links() }}</div>
        @else
            <p class="text-muted mb-0">No doctors found.</p>
        @endif
    </div>
</x-dashboard-layout>