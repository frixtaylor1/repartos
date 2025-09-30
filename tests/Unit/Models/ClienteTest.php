<?php

namespace Tests\Unit\Models;

use App\Models\Cliente;
use App\Models\Orden;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_un_cliente()
    {
        $cliente = Cliente::create([
            'codigo'       => 'CLI-001',
            'razon_social' => 'Mi Empresa',
            'direccion'    => 'Calle Falsa 123',
            'latitud'      => -34.6037,
            'longitud'     => -58.3816,
            'email'        => 'cliente@test.com',
        ]);

        $this->assertDatabaseHas('clientes', [
            'email' => 'cliente@test.com',
        ]);

        $this->assertEquals('Mi Empresa', $cliente->razon_social);
    }

    public function test_tiene_relacion_con_ordenes()
    {
        $cliente    = Cliente::factory()->create();
        $orden      = Orden::factory()->create(['cliente_id' => $cliente->id]);

        $this->assertTrue($cliente->ordenes->contains($orden));
        $this->assertInstanceOf(Orden::class, $cliente->ordenes->first());
    }
}
