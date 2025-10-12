<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Groups;

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
        return [
            'medicine' => fake()-> name(),
            'price' => fake()-> numberBetween(200, 1000),
            'description' => fake()-> realText(50),
            'quantity' => fake()-> numberBetween(0, 1000),
            'group_id'=> Groups::inRandomOrder()->first()->id
        ];
    }
}
