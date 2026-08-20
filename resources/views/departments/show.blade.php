<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Department Details</h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <h4>{{ $department->name }}</h4>
            <p class="text-muted">{{ $department->description ?? 'No description provided.' }}</p>
            <hr>
            <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-outline-primary">Edit</a>
            <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary">Back to List</a>
        </div>
    </div>
</x-app-layout>