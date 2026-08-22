<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'user_id', 'phone', 'emergency_contact', 
        'emergency_phone', 'date_of_birth', 
        'blood_group', 'medical_history'
    ];

    // A Patient belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A Patient has Many Appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // A Patient has Many Payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
