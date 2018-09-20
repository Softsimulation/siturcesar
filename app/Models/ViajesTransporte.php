<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViajesTransporte extends Model
{
   protected $table='viajes_transporte';
     protected $primaryKey = 'viaje_id';
    public $timestamps=false;
}
