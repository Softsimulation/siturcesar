<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Viaje;
use App\Models\Ciudad_Visitada;
use App\Models\Hogar;

class TurismoInterno
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
       
        
        if(strlen(strstr($request->path(),'turismointerno/actividadesrealizadas'))>0){
            
            $viaje=Viaje::find($request->one);
             $sw = 1;
        
            $principal = Ciudad_Visitada::join("municipios","municipios.id","=","municipio_id")
            ->join("departamentos","departamentos.id","=","municipios.departamento_id")
            ->where('viajes_id', $viaje->id)->where("destino_principal",true)
            ->where("departamentos.id",1396)->first();
            if($principal == null){
                $sw = 0;
            }
            
            if($sw==1){
               return $next($request);
            }else{
                return redirect('/turismointerno/viajeprincipal/'.$request->one);
            }
            
        }
        
        if(strlen(strstr($request->path(),'turismointerno/viajesrealizados'))>0){
            
            $hogar=Hogar::find($request->one);
            $sw = 1;
        
            $persona=$hogar->personas->where('es_viajero',true)->where('es_residente',true)->first();
            
            if($persona == null){
                $sw = 0;
            }
            
            if($sw==1){
               return $next($request);
            }else{
                \Session::flash('mensaje','El hogar no tiene ningun miembro viajero');
                return redirect('/turismointerno/editarhogar/'.$request->one);
            }
            
        }
        
        
        
        
        
        return $next($request);
    }
}
