<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentBookingTest extends TestCase
{
    use RefreshDatabase;

    protected function makeDoctor($departmentId)
    {
        $user = User::factory()->create(['role' => 'doctor']);
        return Doctor::create([
            'user_id' => $user->id,
            'department_id' => $departmentId,
            'specialization' => 'General Practitioner',
            'phone' => '0700000000',
        ]);
    }

    protected function makePatientUser()
    {
        $user = User::factory()->create(['role' => 'patient']);
        Patient::create([
            'user_id' => $user->id,
            'phone' => '0700000001',
        ]);
        return $user;
    }

    public function test_patient_cannot_book_the_same_doctor_within_the_buffer_window()
    {
        $department = Department::create(['name' => 'General Medicine', 'description' => 'Test dept']);
        $doctor = $this->makeDoctor($department->id);
        $patientUser = $this->makePatientUser();

        $existingTime = now()->addDay()->setTime(10, 0);

        Appointment::create([
            'patient_id' => $patientUser->patient->id,
            'doctor_id' => $doctor->id,
            'department_id' => $department->id,
            'appointment_time' => $existingTime,
            'status' => 'scheduled',
        ]);

        $response = $this->actingAs($patientUser)->post('/appointments', [
            'patient_id' => $patientUser->patient->id,
            'department_id' => $department->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => $existingTime->toDateString(),
            'appointment_time' => $existingTime->copy()->addMinutes(2)->format('H:i'),
            'amount' => 50000,
            'payment_method' => 'Cash',
        ]);

        $response->assertSessionHasErrors('appointment_time');
        $this->assertEquals(1, Appointment::count());
    }

    public function test_patient_can_book_when_slot_is_free()
    {
        $department = Department::create(['name' => 'General Medicine', 'description' => 'Test dept']);
        $doctor = $this->makeDoctor($department->id);
        $patientUser = $this->makePatientUser();

        $time = now()->addDay()->setTime(11, 0);

        $response = $this->actingAs($patientUser)->post('/appointments', [
            'patient_id' => $patientUser->patient->id,
            'department_id' => $department->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => $time->toDateString(),
            'appointment_time' => $time->format('H:i'),
            'amount' => 50000,
            'payment_method' => 'Cash',
        ]);

        $response->assertSessionDoesntHaveErrors();
        $this->assertEquals(1, Appointment::count());
        $this->assertEquals(1, \App\Models\Payment::count());
    }

    public function test_auto_assignment_picks_least_busy_doctor_in_department()
    {
        $department = Department::create(['name' => 'ENT', 'description' => 'Test dept']);
        $busyDoctor = $this->makeDoctor($department->id);
        $freeDoctor = $this->makeDoctor($department->id);
        $patientUser = $this->makePatientUser();

        $time = now()->addDay()->setTime(14, 0);

        // Give the busy doctor an appointment earlier that same day
        Appointment::create([
            'patient_id' => $patientUser->patient->id,
            'doctor_id' => $busyDoctor->id,
            'department_id' => $department->id,
            'appointment_time' => $time->copy()->subHours(2),
            'status' => 'scheduled',
        ]);

        $response = $this->actingAs($patientUser)->post('/appointments', [
            'patient_id' => $patientUser->patient->id,
            'department_id' => $department->id,
            'doctor_id' => '', // no doctor selected -> auto-assign
            'appointment_date' => $time->toDateString(),
            'appointment_time' => $time->format('H:i'),
            'amount' => 50000,
            'payment_method' => 'Cash',
        ]);

        $response->assertSessionDoesntHaveErrors();

        $newAppointment = Appointment::where('appointment_time', $time)->first();
        $this->assertEquals($freeDoctor->id, $newAppointment->doctor_id);
    }
}