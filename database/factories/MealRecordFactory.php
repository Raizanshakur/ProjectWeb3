<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\MealRecord;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MealRecord>
 */
class MealRecordFactory extends Factory
{
    protected $model = MealRecord::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'child_id' => Child::factory(),
            'food_analysis_id' => null,
            'food_name' => fake()->randomElement(['Bubur Ayam', 'Nasi Tim Daging', 'Sup Sayur', 'Pisang Rebus', 'Pure Alpukat']),
            'meal_type' => fake()->randomElement(['sarapan', 'snack_pagi', 'makan_siang', 'snack_sore', 'makan_malam']),
            'portion_text' => '1 porsi sedang',
            'consumed_at' => now(),
            'calories' => 250.00,
            'protein' => 10.00,
            'carbohydrates' => 35.00,
            'fat' => 6.00,
            'fiber' => 2.50,
            'source' => 'manual',
            'notes' => null,
        ];
    }
}
