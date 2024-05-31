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

        // get the age
        $birth_date = fake()->date('Y-m-d');
        $b_year = date('Y', strtotime($birth_date));
        $d_year = date('Y');
        $age = $d_year - $b_year;

        $height = fake()->randomElement([
            185,
            164,
            152,
            140
        ]);
        $h_m = $height / 100;
        $s_h = ($h_m * $h_m);
        $weight = fake()->randomElement([
            180,
            75,
            65,
            54,
            40
        ]);
        // get the BMI
        $BMI = round(($weight / $s_h), 2);

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

            'birth_date' => $birth_date,
            'age' => $age,
            'birth_place' => fake()->streetAddress(),
            'blood_type' => fake()->randomElement(['A+', 'B+', "O+", "AB+"]),

            // physical info
            'height' => $height,
            'weight' => $weight,
            'BMI' => $BMI,

            'gender' => fake()->randomElement(['Male', 'Female', 'Others']),
            'religion' => fake()->randomElement(['CATHOLIC', 'HER']),
            'citizenship' => 'FILIPINO',

            'contact_no' => fake()->numerify('##########'),
            'address' => fake()->streetAddress(),
            'barangay' => fake()->randomElement([
                // south
                'District 1',
                'District 2',
                'District 3',
                'District 4',
                'District 5',
                'District 6',
                'District 7',
                'District 8',
                'District 12',
                'District 13',
                'District 15',
                'District 17',
                'District 23',
                'District 27',
                // west
                'District 14',
                'District 19',
                'District 20',
                'District 21',
                'District 22',
                'District 24',
                'District 26',
                // east
                'District 9',
                'District 10',
                'District 11',
                'District 16',
                'District 18',
                'District 25',
                'District 28',
                // north
                'District 29',
                'Cogon',
                'Altavista',
                'Patag',
                'Doña Feliza (DFL)',
                'Donghol',
                'Mahayag',
                'Bagong Buhay',
                'San Isidro',
            ]),
        ];
    }
}
