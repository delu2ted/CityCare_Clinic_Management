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
    <h2>Visit History — {{ $patient->user->name ?? 'N/A' }}</h2>
    <table>
        <thead><tr><th>Date</th><th>Doctor</th><th>Department</th><th>Status</th><th>Payment</th></tr></thead>
        <tbody>
            @foreach($visits as $v)
                <tr>
                    <td>{{ $v->appointment_time->format('d M Y, H:i') }}</td>
                    <td>{{ $v->doctor->user->name ?? 'N/A' }}</td>
                    <td>{{ $v->department->name ?? '—' }}</td>
                    <td>{{ ucfirst($v->status) }}</td>
                    <td>{{ $v->payment ? 'UGX ' . number_format($v->payment->amount, 0) . ' — ' . ucfirst($v->payment->status) : 'Not recorded' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>