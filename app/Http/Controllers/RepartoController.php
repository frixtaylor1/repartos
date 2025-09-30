<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearRepartoRequest;
use App\Services\RepartoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RepartoController extends Controller
{
    public function __construct(private readonly RepartoService $service) {}
    /**
     * Maneja la creación de un nuevo reparto.
     *
     * @param CrearRepartoRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function crear(CrearRepartoRequest $request): JsonResponse
    {
        $reparto = $this->service->crear($request->validated());
        return response()->json($reparto, Response::HTTP_CREATED);
    }

    /**
     * Lista los repartos correspondientes a una fecha específica.
     *
     * @param string $fecha Fecha para filtrar los repartos (formato: 'YYYY-MM-DD').
     * @return \Illuminate\Http\JsonResponse
     */
    public function listarPorFecha(string $fecha): JsonResponse
    {
        try {
            $repartos = $this->service->listarPorFecha($fecha);
            return response()->json($repartos);
        } catch (\Exception $exception) {
            Log::error('Error al listar por fecha', [
                'fecha'         => $fecha,
                'user_id'       => Auth::user()->id,
                'error'         => $exception->getMessage(),
                'trace'         => $exception->getTraceAsString()
            ]);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
