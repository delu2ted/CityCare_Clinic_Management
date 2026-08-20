<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Dr. Sarah Smith',
                'email' => 'doctor@citycare.com',
                'password' => bcrypt('password'),
                'role' => 'doctor'
            ],
            [
                'name' => 'Receptionist John',
                'email' => 'reception@citycare.com',
                'password' => bcrypt('password'),
                'role' => 'receptionist'
            ],
            [
                'name' => 'Admin Mike',
                'email' => 'admin@citycare.com',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ],
            [
                'name' => 'Cashier Jane',
                'email' => 'cashier@citycare.com',
                'password' => bcrypt('password'),
                'role' => 'cashier'
            ],
            [
                'name' => 'Patient Alice',
                'email' => 'patient@citycare.com',
                'password' => bcrypt('password'),
                'role' => 'patient'
            ]
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}