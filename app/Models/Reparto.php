<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reparto extends Model
{
    use HasFactory;
 
    const ESTADO_COMPLETO   = 'COM';
    const ESTADO_EN_PROCESO = 'PRO';
    const ESTADO_PENDIENTE  = 'PEN';

    protected $table    = 'repartos';
    protected $fillable = ['codigo_de_reparto', 'fecha_entrega', 'estado', 'vehiculo_id'];

    protected static function booted()
    {
        static::creating(function ($reparto) {
            if (empty($reparto->codigo_de_reparto)) {
                $reparto->codigo_de_reparto = 'R-' . strtoupper(Str::random(6));
            }
        });
    }

    public function ordenes()
    {
        return $this->hasMany(Orden::class);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}
