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
    <h2>Doctor Schedule — {{ $doctor->user->name ?? 'N/A' }}</h2>
    <p>Date: {{ $date }}</p>
    <table>
        <thead><tr><th>Time</th><th>Patient</th><th>Status</th></tr></thead>
        <tbody>
            @foreach($appointments as $a)
                <tr>
                    <td>{{ $a->appointment_time->format('H:i') }}</td>
                    <td>{{ $a->patient->user->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($a->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>