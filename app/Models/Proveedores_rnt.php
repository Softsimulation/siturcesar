<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use App\Models\Categoria_Proveedor_Con_Idioma;
use App\Models\Tipo_Proveedor;

class Proveedores_rnt extends Model
{
    protected $table = 'proveedores_rnt';
    
    
    protected $fillable = ['categoria_proveedores_id', 'estados_proveedor_id', 'municipio_id', 'razon_social', 'longitud', 'latitud', 'direccion', 'numero_rnt', 'telefono', 'celular', 'email', 'estado', 'user_create', 'created_at', 'updated_at', 'user_update','digito_verificacion','nombre_gerente','ultimo_anio_rnt','sostenibilidad_rnt','turismo_aventura','hab2','cam2','emp2','nit'];
    
    
    public function idiomas(){
        return $this->hasMany( "App\Models\Proveedores_rnt_idioma", 'proveedor_rnt_id'); 
    }
    
    public function estadop(){
        return $this->hasOne('App\Models\Estado_proveedor', 'id', 'estados_proveedor_id'); 
    }
    
    public function categoria(){
        return $this->hasOne('App\Models\Categoria_Proveedor', 'id', 'categoria_proveedores_id'); 
    }
    
    public function municipio(){
        return $this->hasOne('App\Models\Municipio', 'id', 'municipio_id'); 
    }
    
    public function vacantes(){
        return $this->hasMany( "App\Models\Oferta_Vacante", 'proveedores_rnt_id'); 
    }
    
    public function proveedor(){
        return $this->hasMany( "App\Models\Proveedor", 'proveedor_rnt_id'); 
    }
    
    
}
