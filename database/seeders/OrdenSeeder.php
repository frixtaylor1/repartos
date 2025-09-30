<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Orden;
use App\Models\Reparto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrdenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = Cliente::all();
        $repartos = Reparto::all();

        foreach ($clientes as $cliente) {
            Orden::factory()->count(rand(2,5))->create([
                'cliente_id' => $cliente->id,
                'reparto_id' => $repartos->random()->id,
            ]);
        }
    }
}
