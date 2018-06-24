<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acompaniante_Sin_Gasto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'acompaniantes_sin_gasto';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'viaje_id';
    /**
     * @var array

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viaje()
    {
        return $this->hasOne('App\Models\Viaje', 'viaje_id');
    }
}