<?php

namespace Tests\Feature;

use App\Models\DespenseMedicine;
use App\Models\Doctor;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\PatientCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PharmacyWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_password_update_allows_pharmacist_to_log_in(): void
    {
        $admin = $this->createUser('Admin', 'ADMIN', 'admin-password');
        $pharmacist = $this->createUser('Pharmacist', 'PHARMACIST', 'old-password');

        $this->actingAs($admin)
            ->put(route('user.update', $pharmacist), [
                'username' => $pharmacist->name,
                'email' => $pharmacist->email,
                'type' => 'PHARMACIST',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])
            ->assertRedirect(route('user.index'));

        $pharmacist->refresh();
        $this->assertTrue(Hash::check('new-password', $pharmacist->password));

        Auth::logout();

        $this->post('/loginUser', [
            'name' => $pharmacist->name,
            'password' => 'new-password',
        ])->assertRedirect('/dashboardPharmacist');

        $this->assertAuthenticatedAs($pharmacist);
    }

    public function test_dispensing_reduces_stock_and_records_the_transaction(): void
    {
        $pharmacist = $this->createUser('Pharmacist', 'PHARMACIST', 'password');
        $patient = $this->createPatient();
        $doctor = $this->createDoctor();
        $medicine = $this->createMedicine('M10001', 'Pain relief', 12);

        $this->actingAs($pharmacist)
            ->post('/recordDespenseMedicine', [
                'doc_license_no' => $doctor->license_no,
                'patient_case_id' => $patient->case_no,
                'diagnosis' => 'Headache',
                'medicine' => [$medicine->medicine_id],
                'quantity' => [4],
            ])
            ->assertRedirect(route('despenseMedicine'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('medicines', [
            'medicine_id' => $medicine->medicine_id,
            'quantity' => 8,
        ]);
        $this->assertDatabaseHas('despense_medicines', [
            'despenser' => $pharmacist->name,
            'despensed' => $patient->case_no,
            'medicine' => $medicine->medicine_id,
            'quantity' => 4,
            'doctor' => $doctor->license_no,
        ]);
    }

    public function test_medicine_stock_is_calculated_from_packages_and_units_per_package(): void
    {
        $pharmacist = $this->createUser('Pharmacist', 'PHARMACIST', 'password');

        $this->actingAs($pharmacist)
            ->post(route('medicine.store'), [
                'medicine_id' => 'M20001',
                'name' => 'Standard tablet',
                'manufacturer' => 'Example Manufacturer',
                'medicine_type' => 'Pain',
                'package_count' => 5,
                'units_per_package' => 12,
                'package_type' => 'box',
                'dispensing_unit' => 'tablet',
                'strength_value' => '500',
                'strength_unit' => 'mg',
                'batch_no' => 'B20001',
                'stock_date' => now()->toDateString(),
                'expired_date' => now()->addYear()->toDateString(),
            ])
            ->assertRedirect(route('medicine.index'));

        $this->assertDatabaseHas('medicines', [
            'medicine_id' => 'M20001',
            'quantity' => 60,
            'units_per_package' => 12,
            'dispensing_unit' => 'tablet',
            'strength_value' => 500,
            'strength_unit' => 'mg',
        ]);
    }

    public function test_pharmacist_dashboard_orders_medicines_by_dispensed_quantity(): void
    {
        $pharmacist = $this->createUser('Pharmacist', 'PHARMACIST', 'password');
        $mostDispensed = $this->createMedicine('M10005', 'Most dispensed medicine', 20);
        $lessDispensed = $this->createMedicine('M10006', 'Less dispensed medicine', 20);
        $mostDispensed->update(['dispensing_unit' => 'tablet']);
        $lessDispensed->update(['dispensing_unit' => 'mL']);

        DespenseMedicine::query()->create([
            'despenser' => $pharmacist->name,
            'despensed' => '1234567',
            'medicine' => $mostDispensed->medicine_id,
            'diagnosis' => 'Test diagnosis',
            'quantity' => 8,
            'doctor' => '1234567',
        ]);
        DespenseMedicine::query()->create([
            'despenser' => $pharmacist->name,
            'despensed' => '1234567',
            'medicine' => $lessDispensed->medicine_id,
            'diagnosis' => 'Test diagnosis',
            'quantity' => 2,
            'doctor' => '1234567',
        ]);

        $response = $this->actingAs($pharmacist)
            ->get('/dashboardPharmacist')
            ->assertOk()
            ->assertSee($mostDispensed->name)
            ->assertSee($lessDispensed->name)
            ->assertSee('20 tablet')
            ->assertSee('20 mL');

        $this->assertLessThan(
            strpos($response->getContent(), $lessDispensed->name),
            strpos($response->getContent(), $mostDispensed->name)
        );
    }

    public function test_dispensing_receipt_preview_requires_valid_medicine_and_quantity_data(): void
    {
        $pharmacist = $this->createUser('Pharmacist', 'PHARMACIST', 'password');
        $patient = $this->createPatient();
        $doctor = $this->createDoctor();
        $medicine = $this->createMedicine('M10004', 'Receipt medicine', 7);

        PatientCase::query()->create([
            'case_no' => $patient->case_no,
            'diagnosis_no' => 'D123456',
            'diagnosis' => 'Test diagnosis',
            'treatment' => 'Rest',
            'admit_date' => now()->toDateString(),
            'arrive_time' => '10:00:00',
        ]);

        $this->actingAs($pharmacist)
            ->post('/despenseMedicineReciept', [
                'despenser' => $pharmacist->name,
                'doc_license_no' => $doctor->license_no,
                'patient_case_id' => $patient->case_no,
                'diagnosis' => 'Test diagnosis',
                'medicine' => [$medicine->medicine_id],
                'quantity' => [2],
            ])
            ->assertOk()
            ->assertSee('Receipt medicine')
            ->assertSee('Test diagnosis');

        $this->from('/despenseMedicine')
            ->actingAs($pharmacist)
            ->post('/despenseMedicineReciept', [
                'despenser' => $pharmacist->name,
                'doc_license_no' => $doctor->license_no,
                'patient_case_id' => $patient->case_no,
                'diagnosis' => 'Test diagnosis',
                'medicine' => [$medicine->medicine_id],
                'quantity' => [],
            ])
            ->assertRedirect('/despenseMedicine')
            ->assertSessionHasErrors('quantity');
    }

    public function test_insufficient_stock_rolls_back_all_medicine_and_dispensing_changes(): void
    {
        $pharmacist = $this->createUser('Pharmacist', 'PHARMACIST', 'password');
        $patient = $this->createPatient();
        $doctor = $this->createDoctor();
        $availableMedicine = $this->createMedicine('M10002', 'Available medicine', 10);
        $lowStockMedicine = $this->createMedicine('M10003', 'Low stock medicine', 2);

        $this->actingAs($pharmacist)
            ->from('/despenseMedicineReciept')
            ->post('/recordDespenseMedicine', [
                'doc_license_no' => $doctor->license_no,
                'patient_case_id' => $patient->case_no,
                'diagnosis' => 'Test diagnosis',
                'medicine' => [$availableMedicine->medicine_id, $lowStockMedicine->medicine_id],
                'quantity' => [3, 5],
            ])
            ->assertRedirect('/despenseMedicineReciept')
            ->assertSessionHasErrors('quantity');

        $this->assertDatabaseHas('medicines', [
            'medicine_id' => $availableMedicine->medicine_id,
            'quantity' => 10,
        ]);
        $this->assertDatabaseHas('medicines', [
            'medicine_id' => $lowStockMedicine->medicine_id,
            'quantity' => 2,
        ]);
        $this->assertDatabaseCount('despense_medicines', 0);
    }

    private function createUser(string $name, string $type, string $password): User
    {
        return User::query()->create([
            'name' => $name,
            'email' => strtolower($name).'-'.fake()->unique()->numerify('####').'@example.com',
            'password' => Hash::make($password),
            'type' => $type,
        ]);
    }

    private function createPatient(): Patient
    {
        return Patient::query()->create([
            'case_no' => '1234567',
            'first_name' => 'Jane',
            'mid_name' => 'Marie',
            'last_name' => 'Doe',
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

    private function createDoctor(): Doctor
    {
        return Doctor::query()->create([
            'full_name' => 'Dr. Example',
            'license_no' => '1234567',
        ]);
    }

    private function createMedicine(string $medicineId, string $name, int $quantity): Medicine
    {
        return Medicine::query()->create([
            'medicine_id' => $medicineId,
            'name' => $name,
            'manufacturer' => 'Example Manufacturer',
            'type' => 'Tablet',
            'package_type' => 'Box',
            'mesurement' => 'mg',
            'mesurement_value' => '500',
            'quantity' => $quantity,
            'photo' => 'aclc500px.png',
            'batch_no' => 'B10001',
            'description' => null,
            'expired_date' => now()->addYear()->toDateString(),
        ]);
    }
}
