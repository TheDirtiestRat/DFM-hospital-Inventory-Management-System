<?php

namespace Database\Factories;

use App\Models\BatchMedicine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // variables
        $medicine_id = fake()->numerify('M#####');
        $batch_no = fake()->randomElement(['0920', '2230', '2345', '8790', '7890', '0000', '4141']);

        $expiration_date = fake()->dateTimeBetween('now', '5 years');

        // also insert batch medicine
        BatchMedicine::factory()->create([
            'batch_id' => $batch_no,
            'batch_title' => fake()->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G']),
            'medicine_id' => $medicine_id,
            'stock_date' => fake()->dateTimeBetween('-5 years', 'now'),
            'expired_date' => $expiration_date,
        ]);

        return [
            'medicine_id' => $medicine_id,

            'name' => fake()->firstName() . fake()->lastName,
            'manufacturer' => fake()->colorName(),
            'type' => fake()->randomElement([
                'Endocrine',
                'Contraception',
                "Central Nervous System",

                'Digestive System',
                'Cardiovascular System',
                "Musculoskeletal Disorders",
                'Pain',
                'Allergies',
                "Respiratory System",
            ]),

            'quantity' => fake()->randomNumber(3),
            'package_type' => fake()->randomElement([
                'Box',
                'Bottle',
                "Bags",
                "Pads",
            ]),
            'mesurement' => fake()->randomElement([
                'mm',
                'ml',
                "l",
            ]),
            'mesurement_value' => fake()->randomElement([
                20,
                10,
                1000,
                250,
            ]),

            'photo' => 'aclc500px.png',
            'batch_no' => $batch_no,
            'description' => fake()->sentence(),

            'expired_date' =>  $expiration_date,

            // 'expired_date' =>  fake()->randomElement([
            //     '2025-01-15',
            //     '2027-05-12',
            //     "2024-02-15",
            //     "2024-01-18",
            // ]),
        ];
    }
}
