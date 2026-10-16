<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\PatientCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PatientCertificateTest extends TestCase
{
    use RefreshDatabase;

    public function test_receptionist_can_search_patients_by_name_or_case_number(): void
    {
        $this->actingAs($this->createUser());
        $patient = $this->createPatient('0123456', 'Jane', 'Marie', 'Doe');

        $this->get(route('certificates.index', ['search' => 'Jane Doe']))
            ->assertOk()
            ->assertSee($patient->case_no)
            ->assertSee('Jane Marie Doe');

        $this->get(route('certificates.index', ['search' => $patient->case_no]))
            ->assertOk()
            ->assertSee($patient->case_no);
    }

    public function test_patient_can_open_a_direct_certificate_preparation_form(): void
    {
        $this->actingAs($this->createUser());
        $patient = $this->createPatient('0123456', 'Jane', 'Marie', 'Doe');
        $this->createPatientCase($patient, 'Seasonal influenza');

        $this->get(route('certificates.index'))
            ->assertOk()
            ->assertSee(route('certificates.prepare', $patient));

        $this->get(route('certificates.prepare', $patient))
            ->assertOk()
            ->assertSee('Prepare Patient Certificate')
            ->assertSee('Generate PDF')
            ->assertSee(route('certificates.print', $patient));

        $this->get(route('patient.show', $patient))
            ->assertOk()
            ->assertSee('Prepare certificate')
            ->assertSee(route('certificates.prepare', $patient));
    }

    public function test_medical_certificate_is_streamed_as_a_pdf(): void
    {
        $this->actingAs($this->createUser());
        $patient = $this->createPatient('0123456', 'Jane', 'Marie', 'Doe');
        $this->createPatientCase($patient, 'Seasonal influenza');

        $response = $this->post(route('certificates.print', $patient), [
            'type' => 'medical',
            'purpose' => 'Work clearance',
        ]);

        $response->assertOk()
            ->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF', $response->getContent());
    }

    public function test_death_certificate_requires_death_details_and_streams_a_pdf(): void
    {
        $this->actingAs($this->createUser());
        $patient = $this->createPatient('0123456', 'Jane', 'Marie', 'Doe');

        $this->from(route('certificates.index'))
            ->post(route('certificates.print', $patient), ['type' => 'death'])
            ->assertRedirect(route('certificates.index'))
            ->assertSessionHasErrors([
                'death_date',
                'death_time',
                'death_place',
                'cause_of_death',
                'certifier_name',
                'certifier_license',
            ]);

        $response = $this->post(route('certificates.print', $patient), [
            'type' => 'death',
            'death_date' => now()->toDateString(),
            'death_time' => '10:30',
            'death_place' => 'Dona Feliza Mejia District Health Center',
            'cause_of_death' => 'To be verified by certifying physician',
            'certifier_name' => 'Dr. Example',
            'certifier_license' => 'PRC-12345',
        ]);

        $response->assertOk()
            ->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF', $response->getContent());
    }

    private function createUser(): User
    {
        return User::query()->create([
            'name' => 'Certificate User',
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'type' => 'RECEPTIONIST',
        ]);
    }

    private function createPatient(string $caseNo, string $firstName, string $middleName, string $lastName): Patient
    {
        return Patient::query()->create([
            'case_no' => $caseNo,
            'first_name' => $firstName,
            'mid_name' => $middleName,
            'last_name' => $lastName,
            'birth_date' => '1990-01-01',
            'age' => 36,
            'birth_place' => 'Ormoc City',
            'blood_type' => 'O+',
            'gender' => 'Female',
            'religion' => 'N/A',
            'citizenship' => 'Filipino',
            'height' => 160,
            'weight' => 55,
            'BMI' => 21.5,
            'contact_no' => '09123456789',
            'barangay' => 'District 1',
            'address' => 'Ormoc City',
        ]);
    }

    private function createPatientCase(Patient $patient, string $diagnosis): PatientCase
    {
        return PatientCase::query()->create([
            'case_no' => $patient->case_no,
            'diagnosis_no' => 'D123456',
            'diagnosis' => $diagnosis,
            'treatment' => 'Rest',
            'admit_date' => now()->toDateString(),
            'arrive_time' => '10:00:00',
        ]);
    }
}
