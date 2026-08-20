<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Departments</h2>
    </x-slot>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="h5 mb-0 text-muted">Department List</h3>
        <a href="{{ route('departments.create') }}" class="btn btn-primary">Add New Department</a>
    </div>

    <div class="card">
        <div class="card-body">
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
                                    <form action="{{ route('departments.destroy', $dept->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
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
    </div>
</x-app-layout>