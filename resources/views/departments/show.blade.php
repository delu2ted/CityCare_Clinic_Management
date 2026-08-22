<x-dashboard-layout>
    <h2 class="h4 mb-4">Department Details</h2>

    <div class="dash-panel">
        <h4>{{ $department->name }}</h4>
        <p class="text-muted">{{ $department->description ?? 'No description provided.' }}</p>
        <hr>
        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-outline-primary">Edit</a>
        <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary">Back to List</a>
    </div>
</x-dashboard-layout>