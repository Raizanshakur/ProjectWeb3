<?php

namespace Database\Factories;

use App\Models\AiChat;
use App\Models\Child;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AiChat>
 */
class AiChatFactory extends Factory
{
    protected $model = AiChat::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'child_id' => null,
            'user_message' => fake()->sentence(),
            'ai_response' => fake()->paragraph(),
            'topic' => 'gizi_anak',
            'model_used' => 'gemini-3.8-flash',
        ];
    }

    /**
     * State for a chat attached to a child.
     */
    public function forChild(Child $child): static
    {
        return $this->state(fn (array $attributes) => [
            'child_id' => $child->id,
            'user_id' => $child->user_id,
        ]);
    }
}
