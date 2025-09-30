<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vehiculo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehiculoTest extends TestCase
{
    use RefreshDatabase;

    public function test_crear_vehiculo()
    {
        $user = User::factory()->create();

        $data = [
            'patente' => 'ABC123',
            'modelo'  => 'Ford Fiesta',
        ];

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/vehiculos', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'patente' => 'ABC123',
                     'modelo'  => 'Ford Fiesta',
                 ]);

        $this->assertDatabaseHas('vehiculos', [
            'patente' => 'ABC123',
            'modelo'  => 'Ford Fiesta',
        ]);
    }

    public function test_no_puede_crear_vehiculo_sin_patente()
    {
        $user = User::factory()->create();

        $data = [
            'modelo' => 'Toyota Corolla',
        ];

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/vehiculos', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['patente']);
    }

    public function test_no_puede_crear_vehiculo_con_patente_existente()
    {
        $user = User::factory()->create();

        Vehiculo::factory()->create(['patente' => 'XYZ999']);

        $data = [
            'patente' => 'XYZ999',
            'modelo'  => 'Honda Civic',
        ];

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/vehiculos', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['patente']);
    }
}
