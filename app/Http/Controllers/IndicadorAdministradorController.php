<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anio;
use App\Models\Mes_Indicador;
use App\Models\Indicadores_medicion;
use App\Models\Tipo_Medicion_Indicador;
use App\Models\Tiempo_Indicador;
use App\Models\Indicador;
use App\Models\D_Tiempo;
use App\Models\Temporada;
use App\Models\Mes_Anio;

use DB;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests;

class IndicadorAdministradorController extends Controller
{
    //
    public function getIndex(){
        return view("indicadoresAdministrador.index");
    }
    
    public function getCargarinfo(){
        
        $year = date('Y');
        
        $anios = Anio::where('anio','>=',$year-1)->where('anio','<=',$year+2)->orderBy('anio','asc')->get();
        $meses = Mes_Indicador::orderBy('id','asc')->get();
        $indicadores  = Indicadores_medicion::with([ "idiomas"=>function($q){ $q->where("idioma_id", 1); } ])
                                    ->orderBy('peso', 'asc')->get();
                                    
        $indicadoresMedicion = new Collection(DB::select("SELECT *from indicadores_calculados "));
        $tiposMedicion = Tipo_Medicion_Indicador::all();
        $temporadas =  Temporada::orderBy('id','desc')->get();
        return ["anios"=>$anios,"meses"=>$meses,"indicadores"=>$indicadores,"tiposMedicion"=>$tiposMedicion,"indicadoresMedicion"=>$indicadoresMedicion,'temporadas'=>$temporadas];
    }
    
    public function postRecalcularindicador(Request $request){
        
        $validator = \Validator::make($request->all(), [
            'indicador' => 'required|numeric|exists:indicadores,id'
        ],[
            'indicador_id.required' => 'Se necesita un indicador para calcular.',
            'indicador_id.exists' => 'El indicador debe existir.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $indicador = Indicador::find($request->indicador);
        $indicadorMedicion = Indicadores_medicion::find($indicador->indicador_medicion_id);
    
        if ($indicadorMedicion->tipo_medicion_indicador_id != 2 && $indicadorMedicion->tipo_medicion_indicador_id != 3 ){
        
            $tiempo = Tiempo_Indicador::find($indicador->tiempo_indicador_id);
         
            $mes = Mes_Indicador::find($tiempo->mes_indicador_id);
            $anio = Anio::find($tiempo['años_id']);
        
            $d_tiempo = D_Tiempo::where("anios",$anio->anio)->where("meses",$mes->nombre)->first();
        
            $fecha_inicio = $anio->anio."-".$mes->id."-".$mes->dia_inicio;
            $fecha_final = $anio->anio."-".$mes->id."-".$mes->dia_final;
            $importar = DB::select("SELECT *from eliminar_datos_receptor (?,?)",array($indicador->indicador_medicion_id,$d_tiempo->id));
            $respuesta = $this->calcularReceptor($indicador->indicador_medicion_id,$d_tiempo->id,$fecha_inicio,$fecha_final,$indicador->id);
            
            
        }else{
            if($indicadorMedicion->tipo_medicion_indicador_id == 2){
                $importar = DB::select("SELECT *from eliminar_datos_interno (?,?)",array($indicador->indicador_medicion_id,$indicadorMedicion->temporada_id)); 
                $respuesta = $this->calcularInterno($request->indicador_id,$indicadorMedicion->temporada_id,$indicador->id);
            }else{
                $importar = DB::select("SELECT *from eliminar_datos_emisor (?,?)",array($indicador->indicador_medicion_id,$indicadorMedicion->temporada_id));
                $respuesta = $this->calcularEmisor($request->indicador_id,$indicadorMedicion->temporada_id,$indicador->id);
            }
        }
        
        
        if(!$respuesta["success"]){
            return $respuesta;
        }
        $indicadoresMedicion = new Collection(DB::select("SELECT *from indicadores_calculados "));
        return ["success"=>true,"indicadoresMedicion"=>$indicadoresMedicion];
    }
    
    public function postCalcularindicador(Request $request){
        $validator = \Validator::make($request->all(), [
            'indicador_id' => 'required|numeric|exists:indicadores_mediciones,id',
            'tipo'=>'required|numeric|exists:tipos_mediciones_indicadores,id',
            'mes' => 'required_unless:tipo,2,3 |numeric|exists:mes_indicador,id',
            'anio' => 'required_unless:tipo,2,3|numeric|exists:anios,id',
            'temporada' => 'required_if:tipo,2,3|numeric|exists:temporadas,id'
            
        ],[
            'indicador_id.required' => 'Se necesita un indicador para calcular.',
            'mes.required_unless' => 'Se necesita un mes para calcular.',
            'anio.required_unless' => 'Se necesita un año para calcular.',
            'temporada.required_if' => 'Se necesita una temporada para calcular.',
            
            'indicador_id.exists' => 'El indicador debe existir.',
            'mes.exists' => 'El mes debe existir.',
            'anio.exists' => 'El año debe existir.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        
        if($request->tipo != 2 && $request->tipo != 3 ){
            $mes = Mes_Indicador::find($request->mes);
            $anio = Anio::find($request->anio);
            $tiempo = Tiempo_Indicador::where('años_id',$request->anio)->where("mes_indicador_id",$request->mes)->first();
        
            if($tiempo == null){
                $tiempo = new Tiempo_Indicador();
                $tiempo->mes_indicador_id = $request->mes;
                $tiempo['años_id']= $request->anio;
                $tiempo->save();
            }
            
            
            $indicador = Indicador::where("indicador_medicion_id",$request->indicador_id)->where("tiempo_indicador_id",$tiempo->id)->first();
            
            if($indicador == null){
                $indicador = new Indicador;
                $indicador->tiempo_indicador_id = $tiempo->id;
                $indicador->fecha_carga=date('Y-m-d H:i:s');
                $indicador->estado_indicador_id = 1;
                $indicador->indicador_medicion_id = $request->indicador_id;
                $indicador->save();
			}else{
				 if( $indicador->fecha_finalizacion != null ){
					return ["success"=>false,"errores"=> [ ["El indicador ya se encuentra calculado."] ] ];
				 }
			}	
            
             $d_tiempo = D_Tiempo::where("anios",$anio->anio)->where("meses",$mes->nombre)->first();
        
            if($d_tiempo == null){
                $d_tiempo = new D_Tiempo;
                $d_tiempo->meses = $mes->nombre;
                $d_tiempo->month = $mes->name;
                $d_tiempo->anios = $anio->anio;
                $d_tiempo->month = $mes->name;
                $d_tiempo->peso = $request->mes;
                if($request->mes <=3){
                    $d_tiempo->trimestre = 'Enero-Marzo';
                    $d_tiempo->trimestre_en = 'January-March';
                }
                if($request->mes <=6){
                    $d_tiempo->trimestre = 'Abril-Junio';
                    $d_tiempo->trimestre_en = 'April-June';
                }
                if($request->mes <=9){
                    $d_tiempo->trimestre = 'Julio-Septiembre';
                    $d_tiempo->trimestre_en = 'July-September';
                }
                if($request->mes <=12){
                    $d_tiempo->trimestre = 'Octubre-Diciembre';
                    $d_tiempo->trimestre_en = 'October-December';
                }
                
                $d_tiempo->user_create = "Admin";
                $d_tiempo->user_update = "Admin";
                $d_tiempo->estado = true;
                $d_tiempo->save();
                
            }
            
            switch($request->tipo){
                case 1:
                        $fecha_inicio = $anio->anio."-".$mes->id."-".$mes->dia_inicio;
                        $fecha_final = $anio->anio."-".$mes->id."-".$mes->dia_final;
                        $respuesta = $this->calcularReceptor($request->indicador_id,$d_tiempo->id,$fecha_inicio,$fecha_final,$indicador->id);
                    break;
                case 4:
                    $idMes = Mes_Anio::where('mes_id',$request->mes)->where('anio_id',$request->anio)->first();
                    $respuesta = $this->calcularOferta($request->indicador_id,$d_tiempo->id,$idMes,$indicador->id);
                    break;
                case 5:
                    $idMes = Mes_Anio::where('mes_id',$request->mes)->where('anio_id',$request->anio)->first();
                    $respuesta = $this->calcularEmpleo($request->indicador_id,$d_tiempo->id,$idMes,$indicador->id);
                    break;
            }
            
            
            
        }else{
            $tiempoTemporada = Temporada::find($request->temporada);
            $mes = date('m', strtotime($tiempoTemporada->fecha_fin));
            $numeroAnio =  date('Y', strtotime($tiempoTemporada->fecha_fin));
            $anio = Anio::where('anio',$numeroAnio)->first();
            
            $tiempo = Tiempo_Indicador::where('años_id',$anio->id)->where("mes_indicador_id",$mes)->first();
        
            if($tiempo == null){
                $tiempo = new Tiempo_Indicador();
                $tiempo->mes_indicador_id = $mes;
                $tiempo['años_id']=$anio->id;
                $tiempo->save();
            }
            $indicador = Indicador::where("indicador_medicion_id",$request->indicador_id)->where("temporada_id",$request->temporada)->first();
            if($indicador == null){
                $indicador = new Indicador;
                $indicador->tiempo_indicador_id = $tiempo->id;
                $indicador->fecha_carga=date('Y-m-d H:i:s');
                $indicador->estado_indicador_id = 1;
                $indicador->indicador_medicion_id = $request->indicador_id;
                $indicador->temporada_id = $request->temporada;
                $indicador->save();
			}else{
				 if($indicador->fecha_finalizacion != null ){
					return ["success"=>false,"errores"=> [ ["El indicador ya se encuentra calculado."] ] ];
				 }
			}	
            
            
            if($request->tipo == 2){
                $respuesta = $this->calcularInterno($request->indicador_id,$request->temporada,$indicador->id);
            }else{
                $respuesta = $this->calcularEmisor($request->indicador_id,$request->temporada,$indicador->id);
            }
            
			
		}
            
        if(!$respuesta["success"]){
            return $respuesta;
        }
        
        $indicadoresMedicion = new Collection(DB::select("SELECT *from indicadores_calculados "));
        return ["success"=>true,"indicadoresMedicion"=>$indicadoresMedicion];

    }
    
    
    public function calcularInterno($indicadorMedicion,$idTemporada,$idIndicador){
        $importar = DB::select("SELECT *from importar_interno_emisor ()");
        $indicador = Indicador::find($idIndicador);
        
        try{
            
            switch($indicadorMedicion){
                case 8:
                    $importar = DB::select("SELECT *from etl_motivo_viaje_interno(?,?)",array($idTemporada,$idIndicador));            
                    
                    break;
                case 9:
                    $importar = DB::select("SELECT *from etl_tipo_alojamiento_interno (?,?)",array($idTemporada,$idIndicador));
                    break;
                case 10:
                    $importar = DB::select("SELECT *from etl_tamanio_medio_interno (?,?)",array($idTemporada,$idIndicador));
                    break;
                case 11:
                    $importar = DB::select("SELECT *from etl_tipo_transporte_interno(?,?)",array($idTemporada,$idIndicador));
                    break;
                case 12:
                    $importar = DB::select("SELECT *from etl_duracion_media_interno (?,?)",array($idTemporada,$idIndicador));
                    break;
                case 13:
                    $importar = DB::select("SELECT *from etl_gasto_medio_interno (?,?)",array($idTemporada,$idIndicador));
                    break;
                
            }
            
            $indicador->estado_indicador_id = 2;
            $indicador->fecha_finalizacion=date('Y-m-d H:i:s');
            $indicador->save();
            return ["success"=>true];
        }catch(Exception $ex){
        
            $indicador->estado_indicador_id = 3;
            $indicador->save();
             return ["success"=>false,"errores"=> [ [$ex->getMessage()] ] ];
        }
        
        
    }
    
    
    public function calcularEmisor($indicadorMedicion,$idTemporada,$idIndicador){
        $importar = DB::select("SELECT *from importar_interno_emisor ()");
        $indicador = Indicador::find($idIndicador);
        
        try{
            
            switch($indicadorMedicion){
                case 14:
                    $importar = DB::select("SELECT *from etl_motivo_viaje_emisor(?,?)",array($idTemporada,$idIndicador));            
                    
                    break;
                case 15:
                    $importar = DB::select("SELECT *from etl_tipo_alojamiento_emisor (?,?)",array($idTemporada,$idIndicador));
                    break;
                case 16:
                    $importar = DB::select("SELECT *from etl_tamanio_medio_emisor (?,?)",array($idTemporada,$idIndicador));
                    break;
                case 17:
                    $importar = DB::select("SELECT *from etl_tipo_transporte_emisor(?,?)",array($idTemporada,$idIndicador));
                    break;
                case 18:
                    $importar = DB::select("SELECT *from etl_duracion_media_emisor (?,?)",array($idTemporada,$idIndicador));
                    break;
                case 19:
                    $importar = DB::select("SELECT *from etl_gasto_medio_emisor (?,?)",array($idTemporada,$idIndicador));
                    break;

            }
            
            $indicador->estado_indicador_id = 2;
            $indicador->fecha_finalizacion=date('Y-m-d H:i:s');
            $indicador->save();
            return ["success"=>true];
        }catch(Exception $ex){
        
            $indicador->estado_indicador_id = 3;
            $indicador->save();
             return ["success"=>false,"errores"=> [ [$ex->getMessage()] ] ];
        }
        
        
    }
    
    public function calcularReceptor($indicadorMedicion, $dTiempo,$fecha_inicio,$fecha_final,$idIndicador){
        
        $importar = DB::select("SELECT *from importar_receptor()");
        $importar = DB::select("SELECT *from importar_dimensiones_adicionales()");
        $indicador = Indicador::find($idIndicador);

        try{
            switch($indicadorMedicion){
                case 1:
                    $importar = DB::select("SELECT *from etl_motivo_viaje_receptor(?,?,?)",array($fecha_inicio,$fecha_final,$dTiempo));            
                    
                    break;
                case 2:
                    $importar = DB::select("SELECT *from etl_tipo_alojamiento (?,?,?)",array($fecha_inicio,$fecha_final,$dTiempo));
                    break;
                case 3:
                    $importar = DB::select("SELECT *from etl_medio_transporte_receptor (?,?,?)",array($fecha_inicio,$fecha_final,$dTiempo));
                    break;
                case 4:
                    $importar = DB::select("SELECT *from etl_gasto_medio_receptor(?,?,?)",array($fecha_inicio,$fecha_final,$dTiempo));
                    break;
                case 5:
                    $importar = DB::select("SELECT *from etl_gasto_medio_rubro_receptor (?,?,?)",array($fecha_inicio,$fecha_final,$dTiempo));
                    break;
                case 6:
                    $importar = DB::select("SELECT *from etl_duracion_media_receptor_1 (?,?,?)",array($fecha_inicio,$fecha_final,$dTiempo));
                    break;
                case 7:
                    $importar = DB::select("SELECT *from etl_tamanio_grupo_viaje_receptor_1 (?,?,?)",array($fecha_inicio,$fecha_final,$dTiempo));
                    break;
                

            }
            
            
            $indicador->estado_indicador_id = 2;
            $indicador->fecha_finalizacion=date('Y-m-d H:i:s');
            $indicador->save();
            return ["success"=>true];
        }catch(Exception $ex){
        
            $indicador->estado_indicador_id = 3;
            $indicador->save();
             return ["success"=>false,"errores"=> [ [$ex->getMessage()] ] ];
        }
        
    }
    
    public function calcularOferta($indicadorMedicion, $dTiempo,$Idmes,$idIndicador){
        
        $importar = DB::select("SELECT *from importar_oferta_empleo()");
        $indicador = Indicador::find($idIndicador);

        try{
            switch($indicadorMedicion){
                case 21:
                    $importar = DB::select("SELECT *from etl_agencia_viaje_operadoras(?,?)",array($Idmes,$dTiempo));            
                    break;
                case 25:
                   $importar = DB::select("SELECT *from etl_viajes_emisores_oferta(?,?)",array($Idmes,$dTiempo));
                    break;
                case 26:
                    $importar = DB::select("SELECT *from etl_viajes_interno_oferta(?,?)",array($Idmes,$dTiempo));
                    break;
                case 23:
                    $importar = DB::select("SELECT *from etl_tasa_platos_comida_oferta(?,?)",array($Idmes,$dTiempo));
                    break;
                case 24:
                    $importar = DB::select("SELECT *from etl_tasa_unidades_comida_oferta(?,?)",array($Idmes,$dTiempo));
                    break;
                case 6:
                    $importar = DB::select("SELECT *from etl_duracion_media_oferta(?,?)",array($Idmes,$dTiempo));
                    break;
                case 22:
                   $importar = DB::select("SELECT *from etl_ocupacion_media_oferta(?,?)",array($Idmes,$dTiempo));
                    break;
                case 20:
                   $importar = DB::select("SELECT *from etl_numero_establecimientos_oferta(?,?)",array($Idmes,$dTiempo));
                    break;
                

            }
            
            
            $indicador->estado_indicador_id = 2;
            $indicador->fecha_finalizacion=date('Y-m-d H:i:s');
            $indicador->save();
            return ["success"=>true];
        }catch(Exception $ex){
        
            $indicador->estado_indicador_id = 3;
            $indicador->save();
             return ["success"=>false,"errores"=> [ [$ex->getMessage()] ] ];
        }
        
    }
    
    
     public function calcularEmpleo($indicadorMedicion, $dTiempo,$Idmes,$idIndicador){
        
        $importar = DB::select("SELECT *from importar_oferta_empleo()");
        $indicador = Indicador::find($idIndicador);

        try{
            switch($indicadorMedicion){
                case 29:
                    $importar = DB::select("SELECT *from etl_dominio_ingles_empleo(?,?)",array($Idmes,$dTiempo));            
                    break;
                case 28:
                   $importar = DB::select("SELECT *from etl_total_personas_empleo(?,?)",array($Idmes,$dTiempo));
                    break;
                case 33:
                    $importar = DB::select("SELECT *from etl_numero_vacantes_empleo(?,?)",array($Idmes,$dTiempo));
                    break;
                case 27:
                    $importar = DB::select("SELECT *from etl_vinculacion_laboral_empleo(?,?)",array($Idmes,$dTiempo));
                    break;
                case 32:
                    $importar = DB::select("SELECT *from etl_renumeracion_promedio_empleo(?,?)",array($Idmes,$dTiempo));
                    break;
                case 30:
                    $importar = DB::select("SELECT *from etl_numero_empleados_empleo(?,?)",array($Idmes,$dTiempo));
                    break;
                case 31:
                   $importar = DB::select("SELECT *from etl_numero_empleados_tc_empleo(?,?)",array($Idmes,$dTiempo));
                    break;
              
            }
            
            
            $indicador->estado_indicador_id = 2;
            $indicador->fecha_finalizacion=date('Y-m-d H:i:s');
            $indicador->save();
            return ["success"=>true];
        }catch(Exception $ex){
        
            $indicador->estado_indicador_id = 3;
            $indicador->save();
             return ["success"=>false,"errores"=> [ [$ex->getMessage()] ] ];
        }
        
    }
    
}
