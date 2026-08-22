<x-dashboard-layout>
    <h2 class="h4 mb-4">Clinic Dashboard</h2>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card tone-1">
                <div><div class="stat-label">Doctors</div><div class="stat-value">{{ $doctorCount }}</div></div>
                <div class="stat-icon">🩺</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card tone-2">
                <div><div class="stat-label">Patients</div><div class="stat-value">{{ $patientCount }}</div></div>
                <div class="stat-icon">🧑‍🤝‍🧑</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card tone-3">
                <div><div class="stat-label">Appointments Today</div><div class="stat-value">{{ $appointmentCount }}</div></div>
                <div class="stat-icon">📅</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card tone-4">
                <div><div class="stat-label">Income</div><div class="stat-value">${{ number_format($income, UGX {{ number_format($income, 0) }}) }}</div></div>
                <div class="stat-icon">💰</div>
            </div>
        </div>
    </div>

    <h6 class="text-muted text-uppercase mb-3" style="font-size:.75rem;letter-spacing:.05em;">Quick Actions</h6>
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3"><a href="{{ route('appointments.create') }}" class="quick-action"><div class="qa-icon">➕</div>Book Appointment</a></div>
        <div class="col-6 col-md-3"><a href="{{ route('patients.create') }}" class="quick-action"><div class="qa-icon">🧑‍🤝‍🧑</div>New Patient</a></div>
        <div class="col-6 col-md-3"><a href="{{ route('doctors.create') }}" class="quick-action"><div class="qa-icon">🩺</div>Add Doctor</a></div>
        <div class="col-6 col-md-3"><a href="{{ route('departments.index') }}" class="quick-action"><div class="qa-icon">🏢</div>Departments</a></div>
    </div>

    <div class="row g-3">
        <div class="col-md-7">
            <div class="dash-panel">
                <h6 class="mb-3">Appointment Traffic (Monthly)</h6>
                <canvas id="trafficChart" height="120"></canvas>
            </div>
        </div>
        <div class="col-md-5">
            <div class="dash-panel">
                <h6 class="mb-3">Staff Overview</h6>
                <canvas id="staffChart" height="150"></canvas>
            </div>
        </div>
    </div>

    <script>
        const monthly = @json($monthlyTraffic ?? []);
        const labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        const data = labels.map((_, i) => monthly[i + 1] ?? 0);

        new Chart(document.getElementById('trafficChart'), {
            type: 'line',
            data: { labels, datasets: [{ label: 'Appointments', data, borderColor: '#7657ab', backgroundColor: 'rgba(118,87,171,0.15)', fill: true, tension: .3 }] },
            options: { plugins: { legend: { display: false } } }
        });

        new Chart(document.getElementById('staffChart'), {
            type: 'doughnut',
            data: {
                labels: ['Doctors', 'Patients'],
                datasets: [{ data: [{{ $doctorCount }}, {{ $patientCount }}], backgroundColor: ['#7657ab', '#9498b3'] }]
            }
        });
    </script>
</x-dashboard-layout>