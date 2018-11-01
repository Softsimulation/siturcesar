<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EncuestasPstSostenibilidad $encuestasPstSostenibilidad
 * @property TiposEnergiasRenovable $tiposEnergiasRenovable
 * @property int $encuestas_pst_sostenibilidad_id
 * @property int $tipos_energias_renovable_id
 * @property boolean $tiene_manual
 * @property string $otro
 */
class Energia_Renovable_Pst extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'energias_renovables_pst';

    /**
     * @var array
     */
    protected $fillable = ['tiene_manual', 'otro'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuestasPstSostenibilidad()
    {
        return $this->belongsTo('App\EncuestasPstSostenibilidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposEnergiasRenovable()
    {
        return $this->belongsTo('App\TiposEnergiasRenovable');
    }
}
