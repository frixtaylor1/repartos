<?php

namespace Database\Factories;

use App\Models\Reparto;
use App\Models\Vehiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reparto>
 */
class RepartoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo_de_reparto' => $this->faker->unique()->bothify('R-###'),
            'fecha_entrega'     => $this->faker->dateTimeBetween('now', '+1 month'),
            'vehiculo_id'       => function () {
                return Vehiculo::factory()->create()->id;
            },
            'estado'            => $this->faker->randomElement([
                Reparto::ESTADO_PENDIENTE,
                Reparto::ESTADO_EN_PROCESO,
                Reparto::ESTADO_COMPLETO
            ]),
        ];
    }
}
