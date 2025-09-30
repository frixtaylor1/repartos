<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;
    protected $table    = 'ordenes';
    protected $fillable = ['cliente_id', 'fecha_creacion', 'codigo_de_orden', 'reparto_id'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function reparto()
    {
        return $this->belongsTo(Reparto::class);
    }
}
