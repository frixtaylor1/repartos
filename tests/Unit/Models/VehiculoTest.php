<?php

namespace Tests\Unit\Models;

use App\Models\Reparto;
use App\Models\Vehiculo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehiculoTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_un_vehiculo()
    {
        $vehiculo = Vehiculo::create([
            'patente' => 'ABC-123',
            'modelo'  => 'Ford Transit',
        ]);

        $this->assertDatabaseHas('vehiculos', [
            'patente' => $vehiculo->patente,
            'modelo'  => 'Ford Transit',
        ]);
    }

    public function test_tiene_relacion_con_repartos()
    {
        $vehiculo = Vehiculo::factory()->create();
        $reparto  = Reparto::factory()->create(['vehiculo_id' => $vehiculo->id]);

        $this->assertTrue($vehiculo->repartos->contains($reparto));
    }
}
