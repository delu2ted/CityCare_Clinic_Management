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
    <h2>CityCare Medical Centre — Payments Report</h2>
    <p>Total Collected (Paid): UGX {{ number_format($totalAmount, 0) }}</p>
    <table>
        <thead><tr><th>Patient</th><th>Amount</th><th>Method</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
            @foreach($payments as $p)
                <tr>
                    <td>{{ $p->patient->user->name ?? 'N/A' }}</td>
                    <td>UGX {{ number_format($p->amount, 0) }}</td>
                    <td>{{ $p->payment_method ?? '—' }}</td>
                    <td>{{ ucfirst(str_replace('_',' ',$p->status)) }}</td>
                    <td>{{ $p->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>