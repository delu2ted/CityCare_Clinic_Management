<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'description'];

    // One Department has Many Doctors
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
    
    // One Department has Many Appointments (via doctors)
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}