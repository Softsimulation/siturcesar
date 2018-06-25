<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtraRed extends Model
{
    protected $table='otro_redes_sociales';
    
    public $timestamps=false;
    
    protected $primaryKey = 'viaje_id';
    
}
