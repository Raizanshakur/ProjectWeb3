<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\FoodAnalysis;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FoodAnalysis>
 */
class FoodAnalysisFactory extends Factory
{
    protected $model = FoodAnalysis::class;

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
            'food_image' => 'food_analyses/fake_image.jpg',
            'food_name' => fake()->randomElement(['Bubur Ayam Sayur', 'Nasi Tim Wortel', 'Sup Ayam Bening', 'Pure Pisang']),
            'portion_description' => '1 mangkuk sedang (200g)',
            'visible_ingredients' => ['Beras', 'Ayam', 'Wortel'],
            'calories' => 220.00,
            'protein' => 10.50,
            'fat' => 5.00,
            'carbohydrates' => 30.00,
            'fiber' => 2.00,
            'uncertainty_note' => 'Estimasi berdasarkan porsi rata-rata.',
            'ai_analysis' => 'Cocok untuk kebutuhan nutrisi balita.',
            'status' => 'succeeded',
            'is_food' => true,
            'model_used' => 'gemini-3.8-flash',
            'error_message' => null,
            'analyzed_at' => now(),
        ];
    }

    /**
     * State for non-food images.
     */
    public function notFood(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_food' => false,
            'food_name' => null,
            'calories' => null,
            'protein' => null,
            'fat' => null,
            'carbohydrates' => null,
            'fiber' => null,
            'visible_ingredients' => [],
            'portion_description' => null,
            'uncertainty_note' => 'Objek tidak terdeteksi sebagai makanan.',
        ]);
    }

    /**
     * State for failed analysis.
     */
    public function failed(string $error = 'Terjadi kesalahan analisis'): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'failed',
            'is_food' => false,
            'error_message' => $error,
        ]);
    }

    /**
     * State for pending analysis.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'analyzed_at' => null,
        ]);
    }
}
