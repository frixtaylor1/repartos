<?php

namespace App\Services;

use App\Models\Orden;

class OrdenService
{
    public function crearOrden(array $data): Orden
    {
        $data['fecha_creacion'] = now();
        return Orden::create($data);
    }

    public function asignarReparto(Orden $orden, int $repartoId): Orden
    {
        if ($orden->reparto_id) {
            throw new \Exception('La orden ya está asignada a un reparto');
        }

        $orden->reparto_id = $repartoId;
        $orden->save();

        return $orden;
    }
}
