<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Visitante $visitante
 * @property int $visitante_id
 * @property string $nombre_empresa
 */
class Visitante_Transporte_Terrestre extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'visitante_transporte_terrestre';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'visitante_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['nombre_empresa'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Visitante');
    }
}
