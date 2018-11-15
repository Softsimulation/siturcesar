<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property AspNetUser $aspNetUser
 * @property Proveedore $proveedore
 * @property int $id
 * @property string $user_id
 * @property int $proveedores_id
 * @property string $fecha
 * @property string $titulo
 * @property string $comentario
 * @property float $le_gusto
 */
class Comentario_Proveedor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'comentarios_proveedores';
    public $timestamps=false;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'proveedores_id', 'fecha', 'titulo', 'comentario', 'le_gusto'];

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
    public function proveedore()
    {
        return $this->belongsTo('App\Proveedore', 'proveedores_id');
    }
}
