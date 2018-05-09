<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Divisa $divisa
 * @property Viaje $viaje
 * @property UbicacionAgenciaViaje[] $ubicacionAgenciaViajes
 * @property PagoPesosColombiano $pagoPesosColombiano
 * @property ServiciosPaqueteInterno[] $serviciosPaqueteInternos
 * @property int $viajes_id
 * @property int $divisas_id
 * @property float $valor_paquete
 * @property int $personas_cubrio
 */
class Viaje_Excursion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'viaje_excursion';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'viajes_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['divisas_id', 'valor_paquete', 'personas_cubrio'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function divisa()
    {
        return $this->belongsTo('App\Divisa', 'divisas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viaje()
    {
        return $this->belongsTo('App\Viaje', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ubicacionAgenciaViajes()
    {
        return $this->belongsToMany('App\UbicacionAgenciaViaje', 'lugar_agencia_viaje', null, 'ubicacion_agencia_viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pagoPesosColombiano()
    {
        return $this->hasOne('App\PagoPesosColombiano', 'viajes_id', 'viajes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function serviciosPaqueteInternos()
    {
        return $this->belongsToMany('App\ServiciosPaqueteInterno', 'servicios_excursion_incluidos_interno', 'viajes_id', 'servicios_paquete_id');
    }
}
