<?php

namespace App\Services;

use App\Models\Orden;
use App\Models\Reparto;
use Exception;

class OrdenService
{
    /**
     * Crea una nueva orden en la base de datos.
     *
     * @param array $data Datos de la orden (por ejemplo, cliente_id, productos, etc.).
     * @return Orden La instancia de la orden creada.
     */
    public function crearOrden(array $data): Orden
    {
        $data['fecha_creacion'] = now();
        return Orden::create($data);
    }

    /**
     * Asigna una orden a un reparto específico.
     *
     * @param Orden $orden La orden a asignar.
     * @param int $repartoId ID del reparto al cual se asignará la orden.
     * @return Orden La orden actualizada con el reparto asignado.
     * @throws Exception Si la orden ya está asignada o el reparto está completo.
     */
    public function asignarReparto(Orden $orden, int $repartoId): Orden
    {
        $reparto = Reparto::findOrFail($repartoId);

        $this->validarAsignacionDeReparto($orden, $reparto);

        $orden->reparto_id = $repartoId;
        $orden->save();

        return $orden;
    }

    /**
     * Valida si la orden puede asignarse al reparto indicado.
     *
     * @param Orden $orden La orden que se quiere asignar.
     * @param Reparto $reparto El reparto al cual se quiere asignar la orden.
     * @throws Exception Si la orden ya tiene un reparto asignado o si el reparto está completo.
     */
    private function validarAsignacionDeReparto(Orden $orden, Reparto $reparto): void
    {
        if ($orden->reparto_id) {
            throw new Exception('La orden ya está asignada a un reparto.');
        }

        if ($reparto->estado === Reparto::ESTADO_COMPLETO) {
            throw new Exception('La orden no puede asignarse a un reparto completado.');
        }
    }
}
