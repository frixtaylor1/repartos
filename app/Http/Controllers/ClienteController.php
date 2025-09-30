<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearClienteRequest;
use App\Services\ClienteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ClienteController extends Controller
{
    public function __construct(private readonly ClienteService $service) {}

    /**
     * Maneja la petición de creación de un cliente.
     *
     * Valida el request
     * Devuelve el cliente cread con codigo de estado 201
     *
     * @param CrearClienteRequest Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function crear(CrearClienteRequest $request): JsonResponse
    {
        $cliente = $this->service->crear($request->validated());
        return response()->json($cliente, Response::HTTP_CREATED);
    }
}