<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AspNetUser $aspNetUser
 * @property Atraccione $atraccione
 * @property int $id
 * @property string $user_id
 * @property int $atraccion_id
 * @property string $fecha
 * @property string $titulo
 * @property string $comentario
 * @property float $le_gusto
 * @property float $llegar
 * @property float $recomendar
 * @property float $volveria
 */
class Comentario_Atraccion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'comentarios_atracciones';
     public $timestamps=false;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'atraccion_id', 'fecha', 'titulo', 'comentario', 'le_gusto', 'llegar', 'recomendar', 'volveria'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function atraccione()
    {
        return $this->belongsTo('App\Atraccione', 'atraccion_id');
    }
}
