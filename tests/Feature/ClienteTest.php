<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\PersistedTestObjects;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(\Illuminate\Auth\Middleware\Authorize::class);
    }

    public function test_crear_cliente()
    {
        $user = PersistedTestObjects::user();
        $data = [
            'codigo'        => 'C1',
            'razon_social'  => 'Mi Cliente',
            'direccion'     => 'Calle Falsa 123',
            'email'         => 'cliente@test.com',
            'latitud'       => -34.6037,
            'longitud'      => -58.3816,
        ];

        $response = $this->actingAs($user, 'sanctum')
                        ->postJson('/api/clientes', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'codigo' => 'C1',
                     'email'  => 'cliente@test.com'
                 ]);
        $this->assertDatabaseHas('clientes', [
            'codigo' => 'C1',
            'email'  => 'cliente@test.com'
        ]);
    }

    public function test_crear_cliente_falla_sin_email()
    {
        $user = PersistedTestObjects::user();

        $data = [
            'codigo'       => 'C2',
            'razon_social' => 'Cliente2',
            'direccion'    => 'Calle 456'
        ];

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/clientes', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
    }

}
