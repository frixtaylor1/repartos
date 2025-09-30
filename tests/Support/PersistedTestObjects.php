<?php
namespace Tests\Support;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Vehiculo;
use App\Models\Reparto;
use App\Models\Orden;
use Laravel\Sanctum\Sanctum;

class PersistedTestObjects
{
    public static function user(array $overrides = []): User
    {
        $user = User::factory()->create($overrides);
        Sanctum::actingAs($user);
        return $user;
    }

    public static function cliente(array $overrides = []): Cliente
    {
        return Cliente::factory()->create($overrides);
    }

    public static function vehiculo(array $overrides = []): Vehiculo
    {
        return Vehiculo::factory()->create($overrides);
    }

    public static function reparto(array $overrides = []): Reparto
    {
        if (!isset($overrides['vehiculo_id'])) {
            $overrides['vehiculo_id'] = self::vehiculo()->id;
        }
        return Reparto::factory()->create($overrides);
    }

    public static function orden(array $overrides = []): Orden
    {
        if (!isset($overrides['cliente_id'])) {
            $overrides['cliente_id'] = self::cliente()->id;
        }
        if (!isset($overrides['codigo_de_orden'])) {
            $overrides['codigo_de_orden'] = 'ORD-' . rand(100, 999);
        }
        return Orden::factory()->create($overrides);
    }
}
