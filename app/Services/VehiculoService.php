<?php

namespace App\Services;

use App\Models\Vehiculo;

class VehiculoService
{
    public function crear(array $data): Vehiculo
    {
        return Vehiculo::create($data);
    }
}