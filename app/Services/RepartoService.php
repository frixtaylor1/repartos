<?php

namespace App\Services;

use App\Models\Reparto;
use Carbon\Carbon;
use Exception;

class RepartoService
{
    /**
     * Crea un nuevo reparto.
     */
    public function crear(array $data): Reparto
    {
        return Reparto::create($data);
    }

    /**
     * Lista los repartos por fecha.
     *
     * @param string $fecha
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function listarPorFecha(string $fecha)
    {
        $fechaCarbon = $this->parseFecha($fecha);

        return Reparto::with('ordenes.cliente')
            ->whereDate('fecha_entrega', $fechaCarbon->toDateString())
            ->get();
    }

    /**
     * Convierte string a Carbon validando formato Y-m-d.
     */
    private function parseFecha(string $fecha): Carbon
    {
        $fecha = trim($fecha, '" ');

        try {
            return Carbon::createFromFormat('Y-m-d', $fecha);
        } catch (Exception $e) {
            throw new Exception('Formato de fecha inválido.');
        }
    }
}
