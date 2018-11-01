<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViajeMedioTransporte extends Model
{
    protected $table='viajes_medio_transporte';
    protected $primaryKey = 'viaje_id';
    public $timestamps=false;
    
}
