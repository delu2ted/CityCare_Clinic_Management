<x-dashboard-layout>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0">Departments</h2>
        <a href="{{ route('departments.create') }}" class="btn btn-primary">Add New Department</a>
    </div>

    <div class="dash-panel">
        @if($departments->count() > 0)
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $dept)
                        <tr>
                            <td>{{ $dept->id }}</td>
                            <td>{{ $dept->name }}</td>
                            <td>{{ Str::limit($dept->description, 50) }}</td>
                            <td>
                                <a href="{{ route('departments.show', $dept->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                <a href="{{ route('departments.edit', $dept->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteDept{{ $dept->id }}">Delete</button>

                                <x-confirm-delete-modal
                                    :id="'deleteDept' . $dept->id"
                                    :action="route('departments.destroy', $dept->id)"
                                    title="Delete Department?"
                                    :message="'Are you sure you want to delete \' . $dept->name . '\'? This cannot be undone.'"
                                />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                {{ $departments->links() }}
            </div>
        @else
            <p class="text-muted mb-0">No departments found. <a href="{{ route('departments.create') }}">Add one now.</a></p>
        @endif
    </div>
</x-dashboard-layout>