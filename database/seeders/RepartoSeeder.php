<?php

namespace Database\Seeders;

use App\Models\Reparto;
use App\Models\Vehiculo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepartoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehiculos = Vehiculo::all();

        foreach ($vehiculos as $vehiculo) {
            Reparto::factory()->count(3)->create([
                'vehiculo_id' => $vehiculo->id,
            ]);
        }
    }
}
