<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearVehiculoRequest;
use App\Services\VehiculoService;
use Illuminate\Http\JsonResponse;

class VehiculoController extends Controller
{
    public function __construct(private readonly VehiculoService $service) {}

    /**
     * Crea un nuevo recurso de Vehículo.
     *
     * Valida la información del request y delega la creación
     * al servicio correspondiente.
     *
     * @param \Illuminate\Http\Request $request Request HTTP con los datos del Vehículo.
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el Vehículo creado o error.
     */
    public function crear(CrearVehiculoRequest $request): JsonResponse
    {
        $vehiculo = $this->service->crear($request->validated());
        return response()->json($vehiculo, 201);
    }
}
