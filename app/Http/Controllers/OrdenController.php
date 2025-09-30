<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsignarRepartoRequest;
use App\Http\Requests\CrearOrdenRequest;
use App\Models\Orden;
use App\Services\OrdenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        Log::info('Orden creada', ['orden_id' => $orden->id, 'user_id' => Auth::user()->id]);

        return response()->json($orden, Response::HTTP_CREATED);
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
            
            Log::info('Asignar reparto', ['orden_id' => $orden->id, 'reparto_id' => $request->reparto_id, 'user_id' => Auth::user()->id]);
    
            return response()->json($orden, Response::HTTP_OK);
        } catch (\Exception $exception) {
            Log::error('Error al asignar reparto', [
                'orden_id'      => $orden->id,
                'reparto_id'    => $request->reparto_id,
                'user_id'       => Auth::user()->id,
                'error'         => $exception->getMessage(),
                'trace'         => $exception->getTraceAsString()
            ]);

            return response()->json([
                "message" => $exception->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
