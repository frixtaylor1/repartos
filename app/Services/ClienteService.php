<?php

namespace App\Services;

use App\Models\Cliente;

class ClienteService
{
    /**
     * Crea un nuevo cliente en la base de datos.
     *
     * @param array $data Datos del cliente (por ejemplo: 'razon_social', 'email', 'direccion', etc.).
     * @return Cliente La instancia del cliente creado.
     */
    public function crear(array $data): Cliente
    {
        return Cliente::create($data);
    }
}