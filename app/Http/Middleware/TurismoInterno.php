<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Viaje;
use App\Models\Ciudad_Visitada;

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
        
        
        return $next($request);
    }
}
