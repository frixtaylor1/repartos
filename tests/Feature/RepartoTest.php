<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\Support\PersistedTestObjects;
use Tests\TestCase;

class RepartoTest extends TestCase
{
    use RefreshDatabase;

    public function test_crear_reparto_exitosamente()
    {
        $user       = PersistedTestObjects::user();
        $vehiculo   = PersistedTestObjects::vehiculo();
        $data = [
            'codigo_de_reparto' => 'R-101',
            'fecha_entrega'     => now()->addDay()->toDateString(),
            'estado'            => 'PEN',
            'vehiculo_id'       => $vehiculo->id,
        ];

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/repartos', $data);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJsonFragment([
                     'codigo_de_reparto' => 'R-101',
                     'vehiculo_id'       => $vehiculo->id,
                 ]);
        $this->assertDatabaseHas('repartos', [
            'codigo_de_reparto' => 'R-101',
            'vehiculo_id'       => $vehiculo->id,
        ]);
    }

    public function test_crear_reparto_falla_sin_vehiculo()
    {
        $user = PersistedTestObjects::user();
        $data = [
            'codigo_de_reparto' => 'R-102',
            'fecha_entrega'     => now()->addDay()->toDateString(),
            'estado'            => 'PEN',
        ];

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/repartos', $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                 ->assertJsonValidationErrors(['vehiculo_id']);
    }

    public function test_listar_repartos_por_fecha()
    {
        $user       = PersistedTestObjects::user();
        $reparto    = PersistedTestObjects::reparto([
            'fecha_entrega' => now()->toDateString()
        ]);

        $response = $this->actingAs($user, 'sanctum')
                         ->getJson('/api/repartos/fecha/' . now()->toDateString());

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonFragment([
                     'id'            => $reparto->id,
                     'fecha_entrega' => now()->toDateString(),
                 ]);
    }

    public function test_listar_repartos_por_fecha_sin_resultados()
    {
        $user = PersistedTestObjects::user();
        $fecha = now()->addDays(10)->toDateString();

        $response = $this->actingAs($user, 'sanctum')
                         ->getJson("/api/repartos/fecha/{$fecha}");

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonCount(0);
    }
}
