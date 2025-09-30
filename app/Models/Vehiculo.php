<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $fillable = ['patente', 'modelo'];

    public function repartos()
    {
        return $this->hasMany(Reparto::class);
    }
}
