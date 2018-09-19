<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtroTransporteSalida extends Model
{
    protected $table='otro_transporte_salida';
    
    protected $primaryKey = 'viaje_id';

    public $incrementing = false;
    
    public $timestamps=false;
    
}
