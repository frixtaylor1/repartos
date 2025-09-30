<?php

namespace App\Services;

use App\Models\Cliente;

class ClienteService
{
    public function crear(array $data): Cliente
    {
        return Cliente::create($data);
    }
}