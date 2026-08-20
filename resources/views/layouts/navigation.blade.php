<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">CityCare Medical Centre</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('departments.*') ? 'active fw-bold' : '' }}" href="{{ route('departments.index') }}">Departments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('doctors.*') ? 'active fw-bold' : '' }}" href="{{ route('doctors.index') }}">Doctors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('patients.*') ? 'active fw-bold' : '' }}" href="{{ route('patients.index') }}">Patients</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('appointments.*') ? 'active fw-bold' : '' }}" href="{{ route('appointments.index') }}">Appointments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('payments.*') ? 'active fw-bold' : '' }}" href="{{ route('payments.index') }}">Payments</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><span class="dropdown-item-text text-muted small">{{ Auth::user()->email }}</span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Log Out</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>