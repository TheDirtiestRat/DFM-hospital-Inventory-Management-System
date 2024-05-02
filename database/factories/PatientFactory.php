<?php

namespace Database\Factories;

use App\Models\PatientCase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $case_no = fake()->numerify('0######');

        PatientCase::factory()->create([
            'case_no' => $case_no,

            'diagnosis_no' => fake()->numerify('D######'),
            'diagnosis' => fake()->randomElement(['Fever', 'Cold', 'Cough', 'The Shits']),
            'treatment' => fake()->randomElement(['Drink Medicine', 'I dunno', 'Just Sleep', 'Your on your own']),
            'admit_date' => fake()->date('Y-m-d'),

            'arrive_time' => fake()->dateTime(),
            'brought_by' => fake()->randomElement(['Car', 'Ambulance', 'Relatives', 'A horse']),
            'remarks' => fake()->sentence(),
        ]);

        return [
            'case_no' => $case_no,

            'first_name' => fake()->firstName(),
            'mid_name' => fake()->randomLetter(),
            'last_name' => fake()->lastName(),

            'birth_date' => fake()->date('Y-m-d'),
            'age' => fake()->numberBetween(1, 100),
            'birth_place' => fake()->streetAddress(),
            'blood_type' => fake()->randomElement(['A+', 'B+', "O+", "AB+"]),

            'gender' => fake()->randomElement(['Male', 'Female', 'Others']),
            'religion' => fake()->randomElement(['CATHOLIC', 'HER']),
            'citizenship' => 'FILIPINO',

            'contact_no' => fake()->numerify('##########'),
            'address' => fake()->streetAddress(),
            'barangay' => fake()->randomElement([
                'Ilang-Ilang 1', 
                'Distric 12', 
                'Mijia', 
                'Cogon',
                'Altavista',
                'Patag',
                'Donghol',
                'Mahayag',
                'Bagong Buhay',
                'San Isidro',
            ]),
        ];
    }
}
