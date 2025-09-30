<?php

namespace App\Services;

use App\Models\Vehiculo;

class VehiculoService
{
    /**
     * Crea un nuevo vehículo en la base de datos.
     *
     * @param array $data Datos del vehículo (por ejemplo: 'patente', 'modelo', 'capacidad', etc.).
     * @return Vehiculo La instancia del vehículo creado.
     */
    public function crear(array $data): Vehiculo
    {
        return Vehiculo::create($data);
    }
}