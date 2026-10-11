<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\GrowthRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GrowthRecord>
 */
class GrowthRecordFactory extends Factory
{
    protected $model = GrowthRecord::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'child_id' => Child::factory(),
            'measurement_date' => now()->format('Y-m-d'),
            'weight' => 9.50,
            'height' => 80.00,
            'head_circumference' => 45.00,
            'nutrition_status' => null,
            'notes' => fake()->sentence(),
        ];
    }
}
