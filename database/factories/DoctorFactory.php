<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Doctor>
 */
class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'doctor']),
            'name' => 'dr. ' . fake()->name() . ', Sp.A',
            'specialization' => 'Dokter Spesialis Anak',
            'str_number' => 'STR-' . fake()->unique()->numerify('####-####-####'),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'photo' => null,
            'practice_days' => 'Senin - Jumat',
            'start_time' => '08:00:00',
            'end_time' => '16:00:00',
            'is_available' => true,
            'bio' => fake()->sentence(10),
        ];
    }

    public function unavailable(): static
    {
        return $this->state(fn () => [
            'is_available' => false,
        ]);
    }
}
