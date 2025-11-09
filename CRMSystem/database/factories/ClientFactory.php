<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'status' => $this->faker->randomElement(['New', 'Prospect', 'Hot', 'Inactive']),
            'assigned_to' => User::inRandomOrder()->first()?->id, // قد يكون null إن لم يوجد users بعد
            'last_communication_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
