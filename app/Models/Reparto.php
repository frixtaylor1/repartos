<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reparto extends Model
{
    use HasFactory;
 
    const ESTADO_COMPLETO   = 'COM';
    const ESTADO_EN_PROCESO = 'PRO';
    const ESTADO_PENDIENTE  = 'PEN';

    protected $table    = 'repartos';
    protected $fillable = ['codigo_de_reparto', 'fecha_entrega', 'estado', 'vehiculo_id'];

    public function ordenes() {
        return $this->hasMany(Orden::class);
    }

    public function vehiculo() {
        return $this->belongsTo(Vehiculo::class);
    }
}
