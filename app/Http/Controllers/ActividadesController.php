<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Actividad;
use App\Models\Actividades;

class ActividadesController extends Controller
{
    //
    public function getVer($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Actividad::find($id) == null){
            return response('Not found.', 404);
        }
        
        $actividad = Actividad::with(['actividadesConIdiomas' => function ($queryActividadesConIdiomas){
            $queryActividadesConIdiomas->orderBy('idiomas')->select('actividades_id', 'idiomas', 'nombre', 'descripcion');
        }, 'multimediasActividades' => function($queryMultimediasActividades){
            $queryMultimediasActividades->orderBy('portada', 'desc')->select('actividades_id', 'ruta');
        }, 'sitiosConActividades' => function ($querySitiosConActividades){
            //$querySitiosConActividades->join('atracciones', 'sitios.id', '=', 'atracciones.sitios_id');
            $querySitiosConActividades->with(['sitiosConIdiomas'=>function($q){
                $q->where('idiomas_id',1);
            }, 'multimediaSitios'=>function($q){
                $q->where('portada',true);
            }]);
        }])->where('id', $id)->first();
        
        //return $actividad;
       
        //return ['actividad' => $actividad];
        return view('actividades.Ver', ['actividad' => $actividad]);
    }
}
