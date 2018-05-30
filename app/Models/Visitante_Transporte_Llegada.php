<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Visitante $visitante
 * @property int $visitante_id
 * @property string $otro
 */
class Visitante_Transporte_Llegada extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'visitantes_transporte_llegada';
    public $timestamps = false;
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
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['otro'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitante()
    {
        return $this->belongsTo('App\Visitante');
    }
}
