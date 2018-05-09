<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FuentesInformacionDuranteViaje $fuentesInformacionDuranteViaje
 * @property Viaje $viaje
 * @property int $fuente_informacion_durante_id
 * @property int $viajes_id
 */
class Fuente_Informacion_Durante_Viaje_Interno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fuentes_informacion_durante_viajes_interno';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fuentesInformacionDuranteViaje()
    {
        return $this->belongsTo('App\FuentesInformacionDuranteViaje', 'fuente_informacion_durante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Viaje', 'viajes_id');
    }
}
