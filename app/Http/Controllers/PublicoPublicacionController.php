<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Publicacion;
use App\Models\TipoPublicacion;

class PublicoPublicacionController extends Controller
{
	function getListado(Request $request){
	 //return $request->all();
        //publicaciones_idioma::where("publicaciones_id",">",1)->delete();
        //Publicacione::where("estado",true)->delete();
        
        $where = [ [ 'estados_id', 3 ] ];
        
        if( isset($request->tipoPublicacion) ){ array_push($where, ['tipos_publicaciones_obras_id',$request->tipoPublicacion]); }
        if( isset($request->buscar) ){ array_push($where, [strtolower('titulo'),'like','%',trim(strtolower($request->buscar))]); }
        
        return view('publicaciones.ListadoPublicoPublicacion', array(
               "publicaciones"=> Publicacion::
                where( $where )->orderBy('id')->paginate(10),
                   
               "tipos"=> TipoPublicacion::join("idiomas_has_tipos_publicaciones_obras","idiomas_has_tipos_publicaciones_obras.tipos_publicaciones_obras_id","=","tipos_publicaciones_obras.id")->where("idiomas_has_tipos_publicaciones_obras.idiomas_id","=",1)->
               select("idiomas_has_tipos_publicaciones_obras.nombre as nombre ","tipos_publicaciones_obras.id as id")->get()    
                ));
       
    }
    
 function getVer($id){
     //publicaciones_idioma::where("publicaciones_id",">",1)->delete();
     //Publicacione::where("estado",true)->delete();
     //return Publicacion::with(["personas","temas"=>function($q){$q->with(['idiomas'=>function($r){$r->where('idiomas_id',$this->idioma_id);}]);},"palabras"])->where("id","=",$id)->first();;
     return view('publicaciones.VerPublicacionPublico', array(
            "publicacion"=> Publicacion::with(["personas","temas"=>function($q){$q->with(['idiomas'=>function($r){$r->where('idiomas_id',1);}]);},"palabras"])->where("id","=",$id)->first()
                
         ));
    
 }
}