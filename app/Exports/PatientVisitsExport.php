<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PatientVisitsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $visits;

    public function __construct($visits)
    {
        $this->visits = $visits;
    }

    public function collection()
    {
        return $this->visits;
    }

    public function headings(): array
    {
        return ['Date', 'Doctor', 'Department', 'Status', 'Payment Status', 'Amount (UGX)'];
    }

    public function map($appt): array
    {
        return [
            $appt->appointment_time->format('d M Y, H:i'),
            $appt->doctor->user->name ?? 'N/A',
            $appt->department->name ?? '—',
            ucfirst($appt->status),
            $appt->payment->status ?? 'Not recorded',
            $appt->payment ? number_format($appt->payment->amount, 0) : '—',
        ];
    }
}