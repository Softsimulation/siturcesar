<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ViajesTurismo $viajesTurismo
 * @property int $viajes_turismo_id
 * @property string $otro
 */
class Provision_Alimento_Otro extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
     public $timestamps = false;
     public $incrementing = false;
    protected $table = 'provision_alimentos_otros';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'provision_alimento_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    //protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['otro'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provisionAlimento()
    {
        return $this->belongsTo('App\Models\Provision_Alimento');
    }
}
