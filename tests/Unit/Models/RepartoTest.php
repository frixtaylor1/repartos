<?php

namespace Tests\Unit\Models;

use App\Models\Cliente;
use App\Models\Orden;
use App\Models\Reparto;
use App\Models\Vehiculo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepartoTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_un_reparto()
    {
        $vehiculo = Vehiculo::factory()->create();

        $reparto = Reparto::create([
            'codigo_de_reparto' => 'REP-001',
            'fecha_entrega'     => now()->addDay()->toDateString(),
            'estado'            => Reparto::ESTADO_PENDIENTE,
            'vehiculo_id'       => $vehiculo->id,
        ]);

        $this->assertDatabaseHas('repartos', [
            'codigo_de_reparto' => $reparto->codigo_de_reparto,
            'estado'            => Reparto::ESTADO_PENDIENTE,
        ]);
    }

    public function test_tiene_relacion_con_ordenes()
    {
        $reparto  = Reparto::factory()->create();
        $cliente  = Cliente::factory()->create();
        $orden    = Orden::factory()->create([
            'reparto_id' => $reparto->id,
            'cliente_id' => $cliente->id,
        ]);

        $this->assertTrue($reparto->ordenes->contains($orden));
    }

    public function test_tiene_relacion_con_vehiculo()
    {
        $vehiculo = Vehiculo::factory()->create();
        $reparto = Reparto::factory()->create(['vehiculo_id' => $vehiculo->id]);

        $this->assertInstanceOf(Vehiculo::class, $reparto->vehiculo);
        $this->assertEquals($vehiculo->id, $reparto->vehiculo->id);
    }

    public function test_constantes_de_estado_son_correctas()
    {
        $this->assertEquals('COM', Reparto::ESTADO_COMPLETO);
        $this->assertEquals('PRO', Reparto::ESTADO_EN_PROCESO);
        $this->assertEquals('PEN', Reparto::ESTADO_PENDIENTE);
    }
}
