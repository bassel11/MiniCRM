<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FollowUp>
 */
class FollowUpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::inRandomOrder()->first()?->id,
            'user_id' => User::inRandomOrder()->first()?->id,
            'due_at' => $this->faker->dateTimeBetween('now', '+10 days'),
            'notes' => $this->faker->sentence(),
            'done' => $this->faker->boolean(20), // 20% من المتابعات منجزة
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
