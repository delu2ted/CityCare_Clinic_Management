<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id', 'doctor_id', 'department_id', 
        'appointment_time', 'status', 'notes'
    ];

    // Protected date format
    protected $casts = [
        'appointment_time' => 'datetime',
    ];

    // An Appointment belongs to a Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // An Appointment belongs to a Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // An Appointment belongs to a Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // An Appointment can have a Payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
