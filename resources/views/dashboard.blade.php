<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Dashboard</h2>
    </x-slot>

    <div class="card">
        <div class="card-header">Welcome</div>
        <div class="card-body">
            <h3 class="h5">Welcome to CityCare Clinic!</h3>
            <p class="mb-1">You are logged in as: <strong>{{ Auth::user()->name }}</strong></p>
            <p class="mb-3">Your Role: <strong>{{ ucfirst(Auth::user()->role) }}</strong></p>
            <hr>
            <p class="text-muted mb-2">Use the navigation menu above to access:</p>
            <ul class="list-unstyled">
                <li><a href="{{ route('departments.index') }}">Departments</a></li>
                <li><a href="{{ route('doctors.index') }}">Doctors</a></li>
                <li><a href="{{ route('patients.index') }}">Patients</a></li>
                <li><a href="{{ route('appointments.index') }}">Appointments</a></li>
                <li><a href="{{ route('payments.index') }}">Payments</a></li>
            </ul>
        </div>
    </div>
</x-app-layout>