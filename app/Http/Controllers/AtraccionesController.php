<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

use App\Http\Requests;

use App\Models\Atracciones;
use App\Models\Comentario_Atraccion;
use App\Models\Atraccion_Favorita;
use App\Models\Sitio;
use App\Models\Municipio;
use App\Models\Proveedor;

class AtraccionesController extends Controller
{
    //
    public function __construct()
    {
        
        $this->middleware('auth',["only"=>["postFavorito","postFavoritoclient"]]);
        $this->user = \Auth::user();
    }
    
    public function getIndex (){
        $atracciones = Atracciones::with(['sitio' => function ($querySitio){
            $querySitio->with(['sitiosConIdiomas' => function ($querySitiosConIdiomas){
                $querySitiosConIdiomas->select('idiomas_id', 'sitios_id', 'nombre', 'descripcion');
            }, 'multimediaSitios' => function ($queryMultimediaSitios){
                $queryMultimediaSitios->where('portada', true)->select('sitios_id', 'ruta');
            }])->select('id', 'latitud', 'longitud', 'direccion');
        }])->select('id', 'sitios_id', 'calificacion_legusto')->get();
        
        $destinos = DB::table('destino_con_idiomas')
                        ->join('')->select()->get();
        
        
        
        return view('atracciones.Index', ['atracciones' => $atracciones, 'destinos' => $destinos]);
    }
    
    public function getVer($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Atracciones::find($id) == null){
            return response('Not found.', 404);
        }
        
        $atraccion = Atracciones::with([
        'sitio' => function($querySitio){
            
            $querySitio->with(['sector'=>function($sector){
                    $sector->with(['destino'=>function($destino){
                        $destino->with('destinoConIdiomas');
                    }]);
                },'sitiosConIdiomas' => function ($querySitiosConIdiomas){
                $querySitiosConIdiomas->orderBy('idiomas_id')->select('idiomas_id', 'sitios_id', 'nombre', 'descripcion');
                }, 'multimediaSitios' => function($queryMultimediaSitios){
                $queryMultimediaSitios->select('sitios_id', 'ruta')->orderBy('portada', 'desc')->where('tipo', false);
                }, 'sitiosConActividades' => function ($querySitiosConActividades){
                $querySitiosConActividades->with(['actividadesConIdiomas' => function($queryActividadesConIdiomas){
                    $queryActividadesConIdiomas->select('actividades_id', 'idiomas', 'nombre');
                }, 'multimediasActividades' => function($queryMultimediasActividades){
                    $queryMultimediasActividades->where('portada', true)->select('actividades_id', 'ruta');
                }
                ])->select('actividades.id');
            }])->select('id', 'longitud', 'latitud', 'direccion', 'sectores_id');
        },'comentariosAtracciones'=> function ($queryComentario){
            $queryComentario->orderBy('fecha', 'DESC')->with(['user']);
        }, 'atraccionesConIdiomas' => function ($queryAtraccionesConIdiomas){
            $queryAtraccionesConIdiomas->orderBy('idiomas_id')->select('atracciones_id', 'idiomas_id'  , 'como_llegar', 'horario', 'periodo', 'recomendaciones', 'reglas');
        }, 'atraccionesConTipos' => function ($queryAtraccionesConTipos){
            $queryAtraccionesConTipos->with(['tipoAtraccionesConIdiomas' => function ($queryTipoAtraccionesConIdiomas){
                $queryTipoAtraccionesConIdiomas->select('idiomas_id', 'tipo_atracciones_id', 'nombre');
            }])->select('tipo_atracciones.id');
        }, 'categoriaTurismoConAtracciones' => function($queryCategoriaTurismoConAtracciones){
            $queryCategoriaTurismoConAtracciones->with(['categoriaTurismoConIdiomas' => function ($queryCategoriaTurismoConIdiomas){
                $queryCategoriaTurismoConIdiomas->select('categoria_turismo_id', 'idiomas_id', 'nombre');
            }])->select('categoria_turismo.id');
        }, 'perfilesUsuariosConAtracciones' => function ($queryPerfilesUsuariosConAtracciones){
            $queryPerfilesUsuariosConAtracciones->with(['perfilesUsuariosConIdiomas' => function($queryPerfilesUsuariosConIdiomas){
                $queryPerfilesUsuariosConIdiomas->select('idiomas_id', 'perfiles_usuarios_id', 'nombre');
            }])->select('perfiles_usuarios.id');
        }])->where('id', $id)->select('id', 'sitios_id', 'calificacion_legusto', 'calificacion_recomendar', 'calificacion_volveria', 'sitio_web')->first();
        
        $video_promocional = Atracciones::where('id', $id)->with(['sitio' => function($querySitio){
            $querySitio->with(['multimediaSitios' => function ($queryMultimediaSitios){
                $queryMultimediaSitios->where('tipo', true);
            }]);
        }])->get();
        
        //return $atraccion->sitio->sector->destino->destinoConIdiomas->where('idiomas_id', 1)->first()->nombre;
        
        $municipio = Municipio::whereRaw('lower(nombre) like lower(?)', ["%{$atraccion->sitio->sector->destino->destinoConIdiomas->where('idiomas_id', 1)->first()->nombre}%"])->first();
        
        //var_dump($video_promocional);
        
        if (count($video_promocional) > 0){
            $video_promocional = $video_promocional[0]->ruta;
        }else {
            $video_promocional = null;
        }
        $dondeDormir = null; $dondeComer = null;
        if($municipio != null){
            $dondeDormir = $this->getProveedoresPorTipo(1, $municipio->id);
            $dondeComer = $this->getProveedoresPorTipo(2, $municipio->id);
        }
        
        //return ['atraccion' => $atraccion, 'video_promocional' => $video_promocional];
        
        return view('atracciones.Ver', ['atraccion' => $atraccion, 'video_promocional' => $video_promocional, 'municipio' => $municipio, 'dondeComer' => $dondeComer, 'dondeDormir' => $dondeDormir]);
    }
    
    public function getProveedoresPorTipo($tipo, $municipioId){
        $idioma = \Config::get('app.locale') == 'es' ? 1 : 2;
        $proveedores = Proveedor::with(['proveedorRnt' => function ($queryProveedorRnt) use ($idioma){
           
            $queryProveedorRnt->with(['idiomas' => function ($queyProveedor_rnt_idioma) use ($idioma){
                $queyProveedor_rnt_idioma->where('idioma_id', $idioma)->select('proveedor_rnt_id', 'idioma_id', 'descripcion', 'nombre')->orderBy('idioma_id');
            }, 'categoria' => function ($queryCategoria) use ($idioma){
                $queryCategoria->with(['categoriaProveedoresConIdiomas' => function($queryCategoriaProveedoresConIdiomas) use ($idioma){
                    $queryCategoriaProveedoresConIdiomas->select('categoria_proveedores_id', 'nombre')->where('idiomas_id', $idioma);
                }])->select('id');
            }])->select('id', 'razon_social', 'categoria_proveedores_id');
            
        }, 'multimediaProveedores' => function ($queryMultimediaProveedores){
            $queryMultimediaProveedores->where('tipo', false)->orderBy('portada', 'desc')->select('proveedor_id', 'ruta');
        }])->whereHas('proveedorRnt',function($query) use($municipioId){
            $query->where('municipio_id',$municipioId);
            
        })->whereHas('proveedorRnt.categoria', function ($query) use ($tipo){
                $query->where('tipo_proveedores_id',$tipo);
            
        })->select('id', 'valor_min', 'valor_max', 'calificacion_legusto', 'proveedor_rnt_id')->where('estado', true)->take(3)->get();
        
        return $proveedores;
    }
    
    
    public function postGuardarcomentario(Request $request){
	   
	   $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:atracciones,id',
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
           return redirect('atracciones/ver/'.$request->id)->with('error','No se pudo guardar el comentario');
            
        }
        
        
        if($this->user == null){
            return redirect('atracciones/ver/'.$request->id)->with('error','No se pudo guardar el comentario');
            
        }
        
        
        $comentario = new Comentario_Atraccion();
        $comentario->atraccion_id = $request->id;
        $comentario->user_id = $this->user->id;
        $comentario->comentario = $request->comentario;
        $comentario->llegar = $request->calificacionFueFacilLlegar;
        $comentario->recomendar = $request->calificacionRecomendaria;
        $comentario->volveria = $request->calificacionRegresaria;
        $comentario->le_gusto = $request->calificacionLeGusto;
        $comentario->fecha = date("Y/m/d-H:i:s");
        
        
        $atraccion = Atracciones::where('id',$request->id)->first();
        $atraccion->calificacion_legusto = Comentario_Atraccion::where('atraccion_id',$request->id)->avg('le_gusto');
        $atraccion->calificacion_llegar = Comentario_Atraccion::where('atraccion_id',$request->id)->avg('llegar'); 
        $atraccion->calificacion_recomendar = Comentario_Atraccion::where('atraccion_id',$request->id)->avg('recomendar'); 
        $atraccion->calificacion_volveria = Comentario_Atraccion::where('atraccion_id',$request->id)->avg('volveria'); 
        $atraccion->save();
        $comentario->save();
        return redirect('atracciones/ver/'.$request->id)->with('success','Comentario guardado correctamente');
    }
    
    public function postFavorito(Request $request){
        $this->user = \Auth::user();
        $atraccion = Atracciones::find($request->atraccion_id);
        if(!$atraccion){
            return response('Not found.', 404);
        }else{
            if(Atraccion_Favorita::where('usuario_id',$this->user->id)->where('atracciones_id',$atraccion->id)->first() == null){
                Atraccion_Favorita::create([
                    'usuario_id' => $this->user->id,
                    'atracciones_id' => $atraccion->id
                ]);
                return \Redirect::to('/atracciones/ver/'.$atraccion->id)
                        ->with('message', 'Se ha añadido la atracción a tus favoritos.')
                        ->withInput(); 
            }else{
                Atraccion_Favorita::where('usuario_id',$this->user->id)->where('atracciones_id',$atraccion->id)->delete();
                return \Redirect::to('/atracciones/ver/'.$atraccion->id)
                        ->with('message', 'Se ha quitado la atracción a tus favoritos.')
                        ->withInput(); 
            }
        }
    }
    
    public function postFavoritoclient(Request $request){
        $this->user = \Auth::user();
        $atraccion = Atracciones::find($request->atraccion_id);
        if(!$atraccion){
            return ["success" => false, "errores" => [["La atracción seleccionada no se encuentra en el sistema."]] ];
        }else{
            if(Atraccion_Favorita::where('usuario_id',$this->user->id)->where('atracciones_id',$atraccion->id)->first() == null){
                Atraccion_Favorita::create([
                    'usuario_id' => $this->user->id,
                    'atracciones_id' => $atraccion->id
                ]);
                return ["success" => true]; 
            }else{
                Atraccion_Favorita::where('usuario_id',$this->user->id)->where('atracciones_id',$atraccion->id)->delete();
                return ["success" => true]; 
            }
        }
    }
    
}
