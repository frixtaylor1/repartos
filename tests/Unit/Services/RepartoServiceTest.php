<?php

namespace Tests\Unit\Services;

use App\Models\Reparto;
use App\Services\RepartoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Support\PersistedTestObjects;
use Exception;

class RepartoServiceTest extends TestCase
{
    use RefreshDatabase;

    protected RepartoService $repartoService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repartoService = new RepartoService();
    }

    public function test_puede_crear_un_reparto(): void
    {
        $data = [
            'fecha_entrega' => now()->addDay()->toDateString(),
            'vehiculo_id'   => PersistedTestObjects::vehiculo()->id,
            'estado'        => Reparto::ESTADO_PENDIENTE,
        ];
        $reparto = $this->repartoService->crear($data);

        $this->assertInstanceOf(Reparto::class, $reparto);
        $this->assertEquals($data['fecha_entrega'], $reparto->fecha_entrega);
        $this->assertEquals($data['estado'], $reparto->estado);
    }

    public function test_puede_listar_repartos_por_fecha(): void
    {
        $fecha = now()->addDay()->toDateString();
        $reparto1 = PersistedTestObjects::reparto(['fecha_entrega' => $fecha]);
        $reparto2 = PersistedTestObjects::reparto(['fecha_entrega' => $fecha]);
        $reparto3 = PersistedTestObjects::reparto(['fecha_entrega' => now()->addDays(2)->toDateString()]);

        $repartos = $this->repartoService->listarPorFecha($fecha);

        $this->assertCount(2, $repartos);
        $this->assertTrue($repartos->pluck('id')->contains($reparto1->id));
        $this->assertTrue($repartos->pluck('id')->contains($reparto2->id));
        $this->assertFalse($repartos->pluck('id')->contains($reparto3->id));
    }

    public function test_listar_por_fecha_lanza_excepcion_si_formato_invalido(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Formato de fecha inválido.');

        $this->repartoService->listarPorFecha('2025/09/29');
    }
}
