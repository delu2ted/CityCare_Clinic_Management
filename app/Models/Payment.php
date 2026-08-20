<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'appointment_id', 'patient_id', 'amount', 
        'payment_method', 'status', 'notes'
    ];

    // A Payment belongs to an Appointment
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    // A Payment belongs to a Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
