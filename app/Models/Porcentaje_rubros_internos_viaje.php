<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Porcentaje_rubros_internos_viaje extends Model
{
    protected $table = 'porcentaje_rubros_internos_viaje';
    protected $primaryKey = 'viaje_id';
    public $timestamps = false;
    
    protected $casts = [
        'dentro' => 'int',
        'fuera' => 'int',
    ];

    
}
