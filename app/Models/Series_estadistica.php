<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series_estadistica extends Model
{
    
    public $timestamps = false; 
    
    public function valores_rotulo()
    {
        return $this->hasMany('App\Models\Series_estadistica_rotulo', 'serie_estadisitica_id');
    }
    
    public function valores_tiempo()
    {
        return $this->hasMany('App\Models\Valor_serie_tiempo', 'series_estadistica_id');
    }
    
}
