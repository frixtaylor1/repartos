<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orden>
 */
class OrdenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo_de_orden' => $this->faker->unique()->bothify('O-###'),
            'fecha_creacion' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
