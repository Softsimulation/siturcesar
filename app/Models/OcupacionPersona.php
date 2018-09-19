<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OcupacionPersona extends Model
{
    protected $table='ocupaciones_personas';
    public $timestamps=false;
    
    protected $primaryKey = 'persona_id';
    
}
