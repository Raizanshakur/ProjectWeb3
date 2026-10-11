<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Child>
 */
class ChildFactory extends Factory
{
    protected $model = Child::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->firstName(),
            'gender' => fake()->randomElement(['L', 'P']),
            'birth_date' => now()->subYears(2)->format('Y-m-d'),
            'birth_weight' => 3.20,
            'birth_height' => 49.50,
            'photo' => null,
        ];
    }
}
