<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2 { color: #513c73; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background: #f0eef9; }
    </style>
</head>
<body>
    <h2>CityCare Medical Centre — Appointments Report</h2>
    <p>Generated: {{ now()->format('d M Y, H:i') }}</p>
    <table>
        <thead>
            <tr><th>Patient</th><th>Doctor</th><th>Department</th><th>Date &amp; Time</th><th>Status</th></tr>
        </thead>
        <tbody>
            @foreach($appointments as $a)
                <tr>
                    <td>{{ $a->patient->user->name ?? 'N/A' }}</td>
                    <td>{{ $a->doctor->user->name ?? 'N/A' }}</td>
                    <td>{{ $a->department->name ?? '—' }}</td>
                    <td>{{ $a->appointment_time->format('d M Y, H:i') }}</td>
                    <td>{{ ucfirst(str_replace('_',' ',$a->status)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>