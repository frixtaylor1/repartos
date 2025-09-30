<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => $this->faker->unique()->bothify('C-###'),
            'razon_social' => $this->faker->company,
            'direccion' => $this->faker->address,
            'latitud' => $this->faker->latitude,
            'longitud' => $this->faker->longitude,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
