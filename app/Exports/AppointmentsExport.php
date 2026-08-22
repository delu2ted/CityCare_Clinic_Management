<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AppointmentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $appointments;

    public function __construct($appointments)
    {
        $this->appointments = $appointments;
    }

    public function collection()
    {
        return $this->appointments;
    }

    public function headings(): array
    {
        return ['Patient', 'Doctor', 'Department', 'Date & Time', 'Status', 'Notes'];
    }

    public function map($appointment): array
    {
        return [
            $appointment->patient->user->name ?? 'N/A',
            $appointment->doctor->user->name ?? 'N/A',
            $appointment->department->name ?? '—',
            $appointment->appointment_time->format('d M Y, H:i'),
            ucfirst(str_replace('_', ' ', $appointment->status)),
            $appointment->notes ?? '',
        ];
    }
}