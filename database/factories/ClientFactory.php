<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'document_type' => 'CC',
            'document_number' => (string) fake()->unique()->numberBetween(10000000, 1999999999),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '3'.fake()->numerify('#########'),
            'address' => fake()->streetAddress(),
            'active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['active' => false]);
    }
}
