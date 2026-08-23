<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // ===== Departments =====
        $departments = [
            ['name' => 'General Medicine', 'description' => 'General consultations and everyday health concerns.'],
            ['name' => 'Pediatrics', 'description' => 'Healthcare for infants, children, and teenagers.'],
            ['name' => 'Cardiology', 'description' => 'Heart health screening, diagnosis, and treatment.'],
            ['name' => 'ENT', 'description' => 'Ear, nose, and throat conditions.'],
            ['name' => 'Dermatology', 'description' => 'Skin, hair, and nail conditions.'],
            ['name' => 'Orthopedics', 'description' => 'Bones, joints, muscles, and injuries.'],
            ['name' => 'Gynecology', 'description' => 'Women\'s reproductive health.'],
            ['name' => 'Dental', 'description' => 'Oral health, cleanings, and dental procedures.'],
        ];

        $departmentModels = [];
        foreach ($departments as $dept) {
            $departmentModels[] = Department::firstOrCreate(['name' => $dept['name']], $dept);
        }

        // ===== Doctors =====
        $doctors = [
            ['name' => 'Dr. Sarah Smith', 'specialization' => 'General Practitioner', 'dept' => 'General Medicine'],
            ['name' => 'Dr. James Okello', 'specialization' => 'Pediatrician', 'dept' => 'Pediatrics'],
            ['name' => 'Dr. Grace Nakato', 'specialization' => 'Cardiologist', 'dept' => 'Cardiology'],
            ['name' => 'Dr. Michael Ssebunya', 'specialization' => 'ENT Specialist', 'dept' => 'ENT'],
            ['name' => 'Dr. Patricia Nabirye', 'specialization' => 'Dermatologist', 'dept' => 'Dermatology'],
            ['name' => 'Dr. Robert Kato', 'specialization' => 'Orthopedic Surgeon', 'dept' => 'Orthopedics'],
            ['name' => 'Dr. Esther Namuli', 'specialization' => 'Gynecologist', 'dept' => 'Gynecology'],
            ['name' => 'Dr. Daniel Mugisha', 'specialization' => 'Dentist', 'dept' => 'Dental'],
            ['name' => 'Dr. Lydia Achieng', 'specialization' => 'General Practitioner', 'dept' => 'General Medicine'],
            ['name' => 'Dr. Peter Tumusiime', 'specialization' => 'Pediatrician', 'dept' => 'Pediatrics'],
        ];

        foreach ($doctors as $i => $doc) {
            $email = 'doctor' . ($i + 1) . '@citycare.com';

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $doc['name'],
                    'password' => Hash::make('password'),
                    'role' => 'doctor',
                ]
            );

            $department = collect($departmentModels)->firstWhere('name', $doc['dept']);

            Doctor::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'department_id' => $department->id,
                    'specialization' => $doc['specialization'],
                    'phone' => '07' . rand(70000000, 99999999),
                    'email' => $email,
                ]
            );
        }

        // ===== Patients =====
        $patientNames = [
            'Alice Nabatanzi', 'Brian Ochieng', 'Catherine Auma', 'David Mwesigwa',
            'Esther Namusoke', 'Fred Kiggundu', 'Grace Adong', 'Henry Ssekandi',
            'Irene Nansubuga', 'John Byaruhanga', 'Kevin Otieno', 'Linda Nakimuli',
            'Moses Wanyama', 'Nancy Achan', 'Oscar Bwire', 'Prisca Nantongo',
            'Quinn Okwir', 'Rebecca Alupo', 'Samuel Turyahabwe', 'Teresa Namaganda',
        ];

        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

        foreach ($patientNames as $i => $name) {
            $email = 'patient' . ($i + 1) . '@example.com';

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'role' => 'patient',
                ]
            );

            Patient::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'phone' => '07' . rand(70000000, 99999999),
                    'date_of_birth' => now()->subYears(rand(5, 70))->subDays(rand(0, 365))->toDateString(),
                    'blood_group' => $bloodGroups[array_rand($bloodGroups)],
                    'emergency_contact' => 'N/A',
                    'emergency_phone' => '07' . rand(70000000, 99999999),
                    'medical_history' => null,
                ]
            );
        }

        $this->command->info('Sample departments, doctors, and patients seeded successfully.');
    }
}