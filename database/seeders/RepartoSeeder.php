<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehiculo;
use App\Models\Reparto;

class RepartoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehiculos = Vehiculo::all();

        foreach ($vehiculos as $vehiculo) {
            $numRepartos = 5;

            for ($i = 0; $i < $numRepartos; $i++) {
                Reparto::factory()->create([
                    'vehiculo_id'   => $vehiculo->id,
                    'fecha_entrega' => now()->addDays($i + ($vehiculo->id * 10)),
                ]);
            }
        }
    }
}
