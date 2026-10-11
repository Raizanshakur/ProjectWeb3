<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Consultation>
 */
class ConsultationFactory extends Factory
{
    protected $model = Consultation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'parent']),
            'child_id' => function (array $attributes) {
                return Child::factory()->create([
                    'user_id' => $attributes['user_id'] ?? User::factory()->state(['role' => 'parent']),
                ])->id;
            },
            'doctor_id' => Doctor::factory(),
            'complaint' => fake()->paragraph(),
            'consultation_date' => now()->addDays(1),
            'status' => 'pending',
            'doctor_notes' => null,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn () => ['status' => 'pending']);
    }

    public function accepted(): static
    {
        return $this->state(fn () => ['status' => 'accepted']);
    }

    public function completed(): static
    {
        return $this->state(fn () => [
            'status' => 'completed',
            'doctor_notes' => 'Rekomendasi dokter telah diberikan.',
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn () => ['status' => 'cancelled']);
    }
}
