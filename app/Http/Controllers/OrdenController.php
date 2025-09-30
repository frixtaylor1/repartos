<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsignarRepartoRequest;
use App\Http\Requests\CrearOrdenRequest;
use App\Models\Orden;
use App\Services\OrdenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class OrdenController extends Controller
{
    public function __construct(private readonly OrdenService $service) {}

    /**
     * Almacena un nuevo recurso en la base de datos.
     *
     * Maneja la solicitud entrante para crear una nueva Orden.
     *
     * @param CrearOrdenRequest $request
     * @return \Illuminate\Http\Response
     */
    public function crear(CrearOrdenRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $orden = $this->service->crearOrden($validated);

        return response()->json($orden, 201);
    }

    /**
     * Asigna un reparto a una orden si aún no está asignado.
     *
     * @param AsignarRepartoRequest $request
     * @param \App\Models\Orden $orden
     * @return \Illuminate\Http\JsonResponse
     */
    public function asignarReparto(AsignarRepartoRequest $request, Orden $orden): JsonResponse
    {
        try {
            $orden = $this->service->asignarReparto($orden, $request->reparto_id);
            return response()->json($orden, Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => $exception->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
