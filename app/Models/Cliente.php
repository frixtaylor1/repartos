<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'razon_social', 'direccion', 'latitud', 'longitud', 'email'];

    public function ordenes() {
        return $this->hasMany(Orden::class);
    }
}
