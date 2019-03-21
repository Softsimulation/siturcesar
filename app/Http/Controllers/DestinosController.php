<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Destino;
use App\Models\Municipio;
use App\Models\Comentario_Destino;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Proveedores_rnt;
use DB;

class DestinosController extends Controller
{
    //
    
       public function __construct()
	{
	    $this->user = Auth::user();
	}
    
    public function getVer($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Destino::find($id) == null){
            return response('Not found.', 404);
        }
        
        $destino = Destino::where('id', $id)->with(['comentariosDestinos'=> function ($queryComentario){
            $queryComentario->orderBy('fecha', 'DESC')->with(['user']);
        }
            ,'tipoDestino' => function ($queryTipoDestino){
            $queryTipoDestino->with(['tipoDestinoConIdiomas' => function($queryTipoDestinoConIdiomas){
                $queryTipoDestinoConIdiomas->orderBy('idiomas_id')->select('idiomas_id', 'tipo_destino_id', 'nombre');
            }])->select('id');
        }, 'destinoConIdiomas' => function($queryDestinoConIdiomas){
            $queryDestinoConIdiomas->orderBy('idiomas_id')->select('destino_id', 'idiomas_id', 'nombre', 'descripcion', 'como_llegar', 'recomendaciones', 'reglas');
        }, 'multimediaDestinos' => function ($queryMultimediaDestinos){
            $queryMultimediaDestinos->where('tipo', false)->orderBy('portada', 'desc')->select('destino_id', 'ruta');
        }, 'sectores' => function($querySectores){
            $querySectores->with(['sectoresConIdiomas' => function($querySectoresConIdiomas){
                $querySectoresConIdiomas->select('idiomas_id', 'sectores_id', 'nombre');
            }])->select('id', 'destino_id', 'es_urbano');
        }])->select('id', 'tipo_destino_id', 'latitud', 'longitud', 'calificacion_legusto', 'calificacion_llegar', 'calificacion_recomendar', 'calificacion_volveria')->first();
        
        $video_promocional = Destino::where('id', $id)->with(['multimediaDestinos' => function($queryMultimediaDestinos){
            $queryMultimediaDestinos->where('tipo', true);
        }])->where('id', $id)->first()->multimediaDestinos;
        
        // $proveedores = Proveedores_rnt::select(DB::raw('proveedores_rnt.id AS id, proveedores_rnt.razon_social AS razon_social, proveedores_rnt.latitud AS latitud
        // , proveedores_rnt.longitud AS longitud, proveedores_rnt.telefono AS telefono, proveedores_rnt.celular AS celular, proveedores_rnt.email AS email'))
        // ->join('municipios', 'municipios.id', '=', 'proveedores_rnt.municipio_id')
        // ->whereRaw('lower(municipios.nombre) like lower(?)', ["%{$destino->destinoConIdiomas[0]->nombre}%"])->get();
        
        $municipio = Municipio::whereRaw('lower(nombre) like lower(?)', ["%{$destino->destinoConIdiomas[0]->nombre}%"])->first();
        
        if (count($video_promocional) > 0){
            $video_promocional = $video_promocional[0]->ruta;
        }else {
            $video_promocional = null;
        }
        
        
        
        //return ['destino' => $destino, 'video_promocional' => $video_promocional];
        return view('destinos.Ver', ['destino' => $destino, 'video_promocional' => $video_promocional, 'municipio' => $municipio]);
    }
    
        public function postGuardarcomentario(Request $request){
	   
	   $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:destino,id',
            'calificacionFueFacilLlegar' => 'required|numeric|min:1|max:5',
            'calificacionLeGusto' => 'required|numeric|min:1|max:5',
            'calificacionRegresaria' => 'required|numeric|min:1|max:5',
            'calificacionRecomendaria' => 'required|numeric|min:1|max:5',
            'comentario' => 'required|string',
        ],[
            'comentario.string' => 'El comentario  debe ser de tipo string.',
            'id.exists' => 'No se encontro la actividad',
            'calificacionFueFacilLlegar.min' => 'la calificacion fue facil llegar debe ser mínimo de 1.',
            'calificacionFueFacilLlegar.max' => 'la calificacion fue facil llegar debe ser maximo de 5.',
            'calificacionRegresaria.min' => 'la calificacion regresaria debe ser mínimo de 1.',
            'calificacionRegresaria.max' => 'la calificacion regresaria debe ser maximo de 5.',
            'calificacionRecomendaria.min' => 'la calificacion recomendaria debe ser mínimo de 1.',
            'calificacionRecomendaria.max' => 'la calificacion recomendaria debe ser maximo de 5.',
            ]
        );
        
           if($validator->fails()){
           return redirect('destinos/ver/'.$request->id)->with('error','No se pudo guardar el comentario');
            
        }
        
        if($this->user == null){
            return redirect('destinos/ver/'.$request->id)->with('error','No se pudo guardar el comentario');
            
        }
        $comentario = new Comentario_Destino();
        $comentario->destinos_id = $request->id;
        $comentario->user_id = $this->user->id;
        $comentario->comentario = $request->comentario;
        $comentario->llegar = $request->calificacionFueFacilLlegar;
        $comentario->recomendar = $request->calificacionRecomendaria;
        $comentario->volveria = $request->calificacionRegresaria;
        $comentario->le_gusto = $request->calificacionLeGusto;
        $comentario->fecha = date("Y/m/d-H:i:s");
        
        
        $destino = Destino::where('id',$request->id)->first();
        $destino->calificacion_legusto = Comentario_Destino::where('destinos_id',$request->id)->avg('le_gusto');
        $destino->calificacion_llegar = Comentario_Destino::where('destinos_id',$request->id)->avg('llegar'); 
        $destino->calificacion_recomendar = Comentario_Destino::where('destinos_id',$request->id)->avg('recomendar'); 
        $destino->calificacion_volveria = Comentario_Destino::where('destinos_id',$request->id)->avg('volveria'); 
        $destino->save();
        $comentario->save();
        return redirect('destinos/ver/'.$request->id)->with('success','Comentario guardado correctamente');
    }
    
    
}
