<?php

namespace App\Http\Middleware;
use Illuminate\Database\Eloquent\Collection;
use DB;
use Closure;
use App\Models\Encuesta;
use App\Models\Sitio_Para_Encuesta;

class OfertaEmpleo
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
        
        if(strlen(strstr($request->path(),'ofertaempleo/encuesta'))>0){
            $sitio = Sitio_Para_Encuesta::find($request->one);
            if($sitio != null){
                 return $next($request);
             }else{
                \Session::flash('mensaje','Sitio no valido');
                return redirect('/ofertaempleo/listadoproveedores/'.$request->one);
            }
            
          
            
        }    
    
   
     if(strlen(strstr($request->path(),'ofertaempleo/actividadcomercial'))>0){
            $sitio = Sitio_Para_Encuesta::find($request->three);
            if($sitio != null){
                 return $next($request);
             }else{
                \Session::flash('mensaje','Sitio no valido');
                return redirect('/ofertaempleo/encuesta/'.$request->one);
            }
            
          
            
        }
        
        
    $encuesta = Encuesta::find($request->one);
    if($encuesta->actividad_comercial == 0){
        return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
        
    }
    
    $data =  new Collection(DB::select("SELECT *from listado_encuesta_oferta where id =".$request->one));
        
    if($encuesta == null){
         \Session::flash('mensaje','No existe la encuesta');
                return redirect('/ofertaempleo/listadoproveedores');
    }
    
    if(strlen(strstr($request->path(),'ofertaempleo/agenciaviajes'))>0){
            
            if($data[0]->mes_id%3 != 0){
                        return redirect('/ofertaempleo/empleo/'.$request->one);
            }
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 15 || $encuesta->sitiosParaEncuesta->proveedor->categoria->id == 13){
                            
                
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
         
            
        }
        
    if(strlen(strstr($request->path(),'ofertaempleo/ofertaagenciaviajes'))>0){
            
            if($data[0]->mes_id%3 != 0){
                    return redirect('/ofertaempleo/empleo/'.$request->one);
            }
         
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 15 || $encuesta->sitiosParaEncuesta->proveedor->categoria->id == 13){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
    }
        
    if(strlen(strstr($request->path(),'ofertaempleo/caracterizacionalquilervehiculo'))>0){
            
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            
        
        }
     
    if(strlen(strstr($request->path(),'ofertaempleo/caracterizacionagenciasoperadoras'))>0){
            
            if($data[0]->mes_id%3 != 0){
                return redirect('/ofertaempleo/empleo/'.$request->one);
            }
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 14){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
     
    if(strlen(strstr($request->path(),'ofertaempleo/ocupacionagenciasoperadoras'))>0){
            
            if($data[0]->mes_id%3 != 0){
                return redirect('/ofertaempleo/empleo/'.$request->one);
            }
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 14){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
        
    if(strlen(strstr($request->path(),'ofertaempleo/caracterizaciontransporte'))>0){
            
            if($data[0]->mes_id%3 != 0){
                return redirect('/ofertaempleo/empleo/'.$request->one);
            } 
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 22 || $encuesta->sitiosParaEncuesta->proveedor->categoria->id == 21  || $encuesta->sitiosParaEncuesta->proveedor->categoria->id == 23){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
     
    if(strlen(strstr($request->path(),'ofertaempleo/ofertatransporte'))>0){
            
            if($data[0]->mes_id%3 != 0){
                return redirect('/ofertaempleo/empleo/'.$request->one);
            }
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 22 || $encuesta->sitiosParaEncuesta->proveedor->categoria->id == 21  || $encuesta->sitiosParaEncuesta->proveedor->categoria->id == 23){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
        
    if(strlen(strstr($request->path(),'ofertaempleo/caracterizacionalimentos'))>0){
            
          
            if($data[0]->mes_id%3 != 0){
                return redirect('/ofertaempleo/empleo/'.$request->one);
            }
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 12  || $encuesta->sitiosParaEncuesta->proveedor->categoria->id == 11 || $encuesta->sitiosParaEncuesta->proveedor->categoria->id == 25 || $encuesta->sitiosParaEncuesta->proveedor->categoria->id == 16){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
     
          if(strlen(strstr($request->path(),'ofertaempleo/empleomensual'))>0){
            
            if($data[0]->mes_id%3 != 0){
                return redirect('/ofertaempleo/empleo/'.$request->one);
            } else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                return $next($request);
            }
            
     }
     
     if(strlen(strstr($request->path(),'ofertaempleo/empleadoscaracterizacion'))>0){
            
            if($data[0]->mes_id%3 != 0){
                return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            } else{
                return $next($request);
            }
            
     }
     
     if(strlen(strstr($request->path(),'ofertaempleoempleo/empleo'))>0){
            
            if($data[0]->mes_id%3 == 0){
                return redirect('/ofertaempleo/empleomensual/'.$request->one);
            } else{
                return $next($request);
            }
            
     }

     
     
    if(strlen(strstr($request->path(),'ofertaempleo/capacidadalimentos'))>0){
            
            if($data[0]->mes_id%3 != 0){
                return redirect('/ofertaempleo/empleo/'.$request->one);
            }

            if($encuesta->sitiosParaEncuesta->proveedor->categoria->id == 12 || $encuesta->sitiosParaEncuesta->proveedor->categoria->id == 11 || $encuesta->sitiosParaEncuesta->proveedor->categoria->id == 25 || $encuesta->sitiosParaEncuesta->proveedor->categoria->id == 16){
                         return $next($request);
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
        
    if(strlen(strstr($request->path(),'ofertaempleo/alojamientomensual'))>0){
            
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->tipoProveedore->id == 1){
               
                 if($data[0]->mes_id%3 == 0){
                        return redirect('/ofertaempleo/alojamientotrimestral/'.$request->one);
                  }else{
                      return $next($request);
                  }
            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                 return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
        
    if(strlen(strstr($request->path(),'ofertaempleo/alojamientotrimestral'))>0){
            
            if($encuesta->sitiosParaEncuesta->proveedor->categoria->tipoProveedore->id == 1){
                  if($data[0]->mes_id%3 != 0){
                        return redirect('/ofertaempleo/alojamientomensual/'.$request->one);
                  }else{
                      return $next($request);
                  }
            

            }else{
                \Session::flash('mensaje','No puede acceder a dicha ruta no concuerdan el tipo de proveedor');
                  return redirect('/ofertaempleo/encuestas/'.$encuesta->sitios_para_encuestas_id);
            }
            
        }
     
   

        return $next($request);
    }
}
