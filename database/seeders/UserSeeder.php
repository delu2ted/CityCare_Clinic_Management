<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Department;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Make sure at least one department exists to link the doctor to
        $department = Department::firstOrCreate(
            ['name' => 'General Medicine'],
            ['description' => 'General consultations and checkups']
        );

        $doctorUser = User::create([
            'name' => 'Dr. Sarah Smith',
            'email' => 'doctor@citycare.com',
            'password' => bcrypt('password'),
            'role' => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $doctorUser->id,
            'department_id' => $department->id,
            'specialization' => 'General Practitioner',
            'phone' => '0788000001',
            'email' => $doctorUser->email,
        ]);

        $receptionUser = User::create([
            'name' => 'Receptionist John',
            'email' => 'reception@citycare.com',
            'password' => bcrypt('password'),
            'role' => 'receptionist',
        ]);

        $adminUser = User::create([
            'name' => 'Admin Mike',
            'email' => 'admin@citycare.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $cashierUser = User::create([
            'name' => 'Cashier Jane',
            'email' => 'cashier@citycare.com',
            'password' => bcrypt('password'),
            'role' => 'cashier',
        ]);

        $patientUser = User::create([
            'name' => 'Patient Alice',
            'email' => 'patient@citycare.com',
            'password' => bcrypt('password'),
            'role' => 'patient',
        ]);

        Patient::create([
            'user_id' => $patientUser->id,
            'phone' => '0788000002',
            'date_of_birth' => '1995-04-12',
            'blood_group' => 'O+',
            'emergency_contact' => 'Bob Alice',
            'emergency_phone' => '0788000003',
        ]);
    }
}