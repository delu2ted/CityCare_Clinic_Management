<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CityCare Medical Centre') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
</head>
<body>
    <div class="dash-wrapper">
        <aside class="dash-sidebar">
            <div class="brand">CityCare Clinic</div>

            <div class="nav-section-label">Main</div>
            <a href="{{ route('dashboard') }}" class="dash-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">📊 Dashboard</a>

            @if(in_array(Auth::user()->role, ['admin', 'receptionist', 'doctor', 'patient']))
                <a href="{{ route('appointments.index') }}" class="dash-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}">📅 Appointments</a>
            @endif

            @if(in_array(Auth::user()->role, ['admin', 'receptionist']))
                <div class="nav-section-label">People</div>
                <a href="{{ route('doctors.index') }}" class="dash-link {{ request()->routeIs('doctors.*') ? 'active' : '' }}">🩺 Doctors</a>
                <a href="{{ route('patients.index') }}" class="dash-link {{ request()->routeIs('patients.*') ? 'active' : '' }}">🧑‍🤝‍🧑 Patients</a>
            @endif

            @if(in_array(Auth::user()->role, ['admin', 'cashier', 'patient']))
                <div class="nav-section-label">Finance</div>
                <a href="{{ route('payments.index') }}" class="dash-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">💳 Payments</a>
            @endif

            @if(Auth::user()->role === 'admin')
                <div class="nav-section-label">Admin</div>
                <a href="{{ route('departments.index') }}" class="dash-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">🏢 Departments</a>
            @endif


            <div class="nav-section-label">Account</div>
            <a href="{{ route('profile.edit') }}" class="dash-link">👤 Profile ({{ Auth::user()->name }})</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dash-link border-0 bg-transparent w-100 text-start">🚪 Log Out</button>
            </form>
        </aside>

        <main class="dash-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</body>
</html>