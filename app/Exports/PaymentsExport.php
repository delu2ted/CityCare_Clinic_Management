<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $payments;

    public function __construct($payments)
    {
        $this->payments = $payments;
    }

    public function collection()
    {
        return $this->payments;
    }

    public function headings(): array
    {
        return ['Patient', 'Amount (UGX)', 'Method', 'Status', 'Date'];
    }

    public function map($payment): array
    {
        return [
            $payment->patient->user->name ?? 'N/A',
            number_format($payment->amount, 0),
            $payment->payment_method ?? '—',
            ucfirst(str_replace('_', ' ', $payment->status)),
            $payment->created_at->format('d M Y'),
        ];
    }
}