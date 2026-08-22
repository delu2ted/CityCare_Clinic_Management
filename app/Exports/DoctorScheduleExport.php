<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DoctorScheduleExport implements FromCollection, WithHeadings, WithMapping
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
        return ['Time', 'Patient', 'Status', 'Notes'];
    }

    public function map($appointment): array
    {
        return [
            $appointment->appointment_time->format('H:i'),
            $appointment->patient->user->name ?? 'N/A',
            ucfirst(str_replace('_', ' ', $appointment->status)),
            $appointment->notes ?? '',
        ];
    }
}