<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = ['user_id', 'specialization', 'phone', 'email'];

    // A Doctor belongs to a User (the login account)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A Doctor belongs to a Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // A Doctor has Many Appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}