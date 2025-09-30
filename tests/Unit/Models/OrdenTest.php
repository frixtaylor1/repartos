<?php

namespace Tests\Unit\Models;

use App\Models\Cliente;
use App\Models\Orden;
use App\Models\Reparto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrdenTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_una_orden()
    {
        $cliente = Cliente::factory()->create();

        $orden = Orden::create([
            'cliente_id'     => $cliente->id,
            'codigo_de_orden'=> 'ORD-001',
            'reparto_id'     => null,
        ]);

        $this->assertDatabaseHas('ordenes', [
            'codigo_de_orden' => 'ORD-001',
        ]);

        $this->assertEquals($cliente->id, $orden->cliente_id);
    }

    public function test_tiene_relacion_con_cliente()
    {
        $cliente = Cliente::factory()->create();
        $orden = Orden::factory()->create(['cliente_id' => $cliente->id]);

        $this->assertInstanceOf(Cliente::class, $orden->cliente);
        $this->assertEquals($cliente->id, $orden->cliente->id);
    }

    public function test_puede_tener_un_reparto_asociado()
    {
        $cliente = Cliente::factory()->create();
        $reparto = Reparto::factory()->create();

        $orden = Orden::factory()->create([
            'cliente_id' => $cliente->id,
            'reparto_id' => $reparto->id,
        ]);

        $this->assertInstanceOf(Reparto::class, $orden->reparto);
        $this->assertEquals($reparto->id, $orden->reparto->id);
    }
}
