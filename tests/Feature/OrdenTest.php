<?php

namespace Tests\Feature;

use App\Models\Reparto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\Support\PersistedTestObjects;
use Tests\TestCase;

class OrdenTest extends TestCase
{
    use RefreshDatabase;

    public function test_crear_orden_exitosamente()
    {
        $user    = PersistedTestObjects::user();
        $cliente = PersistedTestObjects::cliente();
        $data = [
            'cliente_id'     => $cliente->id,
            'codigo_de_orden'=> 'ORD-001',
            'detalle'        => 'Entrega urgente',
            'fecha_entrega'  => now()->addDay()->toDateString(),
        ];

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/ordenes', $data);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJsonFragment([
                     'cliente_id' => $cliente->id,
                 ]);
        $this->assertDatabaseHas('ordenes', [
            'cliente_id' => $cliente->id,
            'codigo_de_orden' => 'ORD-001',
        ]);
    }

    public function test_crear_orden_falla_sin_cliente()
    {
        $user = PersistedTestObjects::user();
        $data = [
            'codigo_de_orden'=> 'ORD-002',
            'direccion'      => 'Calle de prueba 123',
            'detalle'        => 'Entrega urgente',
            'fecha_entrega'  => now()->addDay()->toDateString(),
        ];

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/ordenes', $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                 ->assertJsonValidationErrors(['cliente_id']);
    }

    public function test_asignar_reparto_exitosamente()
    {
        $user    = PersistedTestObjects::user();
        $orden   = PersistedTestObjects::orden();
        $reparto = PersistedTestObjects::reparto(['estado' => Reparto::ESTADO_PENDIENTE]);

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson("/api/ordenes/{$orden->id}/reparto", [
                             'reparto_id' => $reparto->id,
                         ]);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonFragment([
                     'id'         => $orden->id,
                     'reparto_id' => $reparto->id,
                 ]);
        $this->assertDatabaseHas('ordenes', [
            'id' => $orden->id,
            'reparto_id' => $reparto->id,
        ]);
    }

    public function test_asignar_reparto_falla_si_no_existe()
    {
        $user  = PersistedTestObjects::user();
        $orden = PersistedTestObjects::orden();

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson("/api/ordenes/{$orden->id}/reparto", [
                             'reparto_id' => 9999,
                         ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->assertJsonValidationErrors(['reparto_id']);
        $this->assertEquals(
            ['El reparto especificado no existe.'],
            $response->json('errors.reparto_id')
        );
    }
}
