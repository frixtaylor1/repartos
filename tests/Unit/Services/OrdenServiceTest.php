<?php

namespace Tests\Unit\Services;

use App\Models\Orden;
use App\Models\Reparto;
use App\Services\OrdenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Exception;
use Tests\Support\PersistedTestObjects;

class OrdenServiceTest extends TestCase
{
    use RefreshDatabase;

    protected OrdenService $ordenService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ordenService = new OrdenService();
    }

    public function test_puede_crear_una_orden(): void
    {
        $cliente = PersistedTestObjects::cliente();
        $data    = [
            'cliente_id'        => $cliente->id,
            'codigo_de_orden'   => 'ORD-TEST-1',
            'fecha_entrega'     => now()->addDay()->toDateString(),
        ];

        $orden = $this->ordenService->crearOrden($data);

        $this->assertInstanceOf(Orden::class, $orden);
        $this->assertNotNull($orden->fecha_creacion);
    }

    public function test_puede_asignar_una_orden_a_un_reparto(): void
    {
        $reparto = PersistedTestObjects::reparto(['estado' => Reparto::ESTADO_PENDIENTE]);
        $orden   = PersistedTestObjects::orden(['reparto_id' => null]);

        $ordenAsignada = $this->ordenService->asignarReparto($orden, $reparto->id);

        $this->assertEquals($reparto->id, $ordenAsignada->reparto_id);
    }

    public function test_no_puede_asignar_una_orden_si_ya_tiene_reparto(): void
    {
        $reparto1 = PersistedTestObjects::reparto(['estado' => Reparto::ESTADO_PENDIENTE]);
        $reparto2 = PersistedTestObjects::reparto(['estado' => Reparto::ESTADO_PENDIENTE]);
        $orden    = PersistedTestObjects::orden(['reparto_id' => $reparto1->id]);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('La orden ya está asignada a un reparto.');

        $this->ordenService->asignarReparto($orden, $reparto2->id);
    }

    public function test_no_puede_asignar_una_orden_a_un_reparto_completo(): void
    {
        $reparto = PersistedTestObjects::reparto(['estado' => Reparto::ESTADO_COMPLETO]);
        $orden   = PersistedTestObjects::orden(['reparto_id' => null]);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('La orden no puede asignarse a un reparto completado.');

        $this->ordenService->asignarReparto($orden, $reparto->id);
    }

    public function test_asignar_orden_a_reparto_inexistente_lanza_model_not_found(): void
    {
        $orden = PersistedTestObjects::orden(['reparto_id' => null]);
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->ordenService->asignarReparto($orden, 9999);
    }
}
