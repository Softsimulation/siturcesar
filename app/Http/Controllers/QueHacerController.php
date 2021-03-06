<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

use App\Models\Idioma;

class QueHacerController extends Controller
{
    public function getIndex(Request $request){
        return view('quehacer.Index', $this->queHacerData(1, $request));
    }
    
    
    /**La función queHacerData pide como parámetro el idioma de la página.
     * 
     * Los tipos de entidad son:
     * tipo: 1 -> Actividades
     * tipo: 2 -> Atracciones
     * tipo: 3 -> Destinos
     * tipo: 4 -> Eventos
     * tipo: 5 -> Rutas
     * 
     * La fecha inicial y final solo aplica para el tipo 4 (Eventos)
     * para el resto de tipos las fechas tienen por default 'NOW()'
     * */
    private function queHacerData (){
        $idIdioma = \Config::get('app.locale') == 'es' ? 1 : 2;
        
        $query = DB::select("(SELECT DISTINCT actividades.id AS id,  
                 actividades.calificacion_legusto AS calificacion_legusto, 
                 1 AS tipo, 
                 NOW() AS fecha_inicio, 
                 NOW() AS fecha_fin, 
                 actividades_con_idiomas.nombre AS nombre,
                 multimedias_actividades.ruta AS portada 
             FROM actividades INNER JOIN actividades_con_idiomas ON actividades_con_idiomas.actividades_id = actividades.id AND actividades_con_idiomas.idiomas = ?
                 INNER JOIN multimedias_actividades ON actividades.id = multimedias_actividades.actividades_id AND multimedias_actividades.portada = true 
             WHERE actividades.estado = true ORDER BY actividades.id) UNION 
             (SELECT DISTINCT atracciones.id AS id,  
                 atracciones.calificacion_legusto AS calificacion_legusto, 
                 2 AS tipo, 
                 NOW() AS fecha_inicio, 
                 NOW() AS fecha_fin, 
                 sitios_con_idiomas.nombre AS nombre,
                 multimedia_sitios.ruta AS portada 
             FROM atracciones INNER JOIN sitios ON sitios.id = atracciones.sitios_id 
                 INNER JOIN sitios_con_idiomas ON sitios.id = sitios_con_idiomas.sitios_id AND sitios_con_idiomas.idiomas_id = ?
                 INNER JOIN multimedia_sitios ON sitios.id = multimedia_sitios.sitios_id AND multimedia_sitios.portada = true 
             WHERE atracciones.estado = true ORDER BY atracciones.id) UNION 
             (SELECT DISTINCT destino.id AS id,  
                 destino.calificacion_legusto AS calificacion_legusto, 
                 3 AS tipo, 
                 NOW() AS fecha_inicio, 
                 NOW() AS fecha_fin, 
                 destino_con_idiomas.nombre AS nombre, 
                 multimedia_destino.ruta AS portada 
             FROM destino INNER JOIN destino_con_idiomas ON destino.id = destino_con_idiomas.destino_id AND destino_con_idiomas.idiomas_id = ? 
                 INNER JOIN multimedia_destino ON destino.id = multimedia_destino.destino_id AND multimedia_destino.portada = true 
             WHERE destino.estado = true ORDER BY destino.id) UNION 
             (SELECT DISTINCT eventos.id AS id,  
                 0.0 AS calificacion_legusto, 
                 4 AS tipo, 
                 eventos.fecha_in AS fecha_inicio, 
                 eventos.fecha_fin AS fecha_fin, 
                 eventos_con_idiomas.nombre AS nombre,
                 multimedia_evento.ruta AS portada 
             FROM eventos INNER JOIN eventos_con_idiomas ON eventos.id = eventos_con_idiomas.eventos_id AND eventos_con_idiomas.idiomas_id = ? 
                 INNER JOIN multimedia_evento ON eventos.id = multimedia_evento.eventos_id AND multimedia_evento.portada = true 
             WHERE eventos.estado = true ORDER BY eventos.id) UNION 
             (SELECT DISTINCT rutas.id AS id,  
                 0.0 AS calificacion_legusto, 
                 5 AS tipo, 
                 NOW() AS fecha_inicio, 
                 NOW() AS fecha_fin, 
                 rutas_con_idiomas.nombre AS nombre,
                 rutas.portada AS portada 
             FROM rutas INNER JOIN rutas_con_idiomas ON rutas.id = rutas_con_idiomas.ruta_id AND rutas_con_idiomas.idioma_id = ?  
             WHERE rutas.estado = true ORDER BY rutas.id) ORDER BY tipo", [$idIdioma, $idIdioma, $idIdioma, $idIdioma, $idIdioma]);
             
        /*$query = DB::select("SELECT rutas.id AS id,  
                 null AS calificacion_legusto, 
                 5 AS tipo, 
                 NOW() AS fecha_inicio, 
                 NOW() AS fecha_fin, 
                 rutas_con_idiomas.nombre AS nombre,
                 rutas.portada AS portada 
             FROM rutas INNER JOIN rutas_con_idiomas ON rutas.id = rutas_con_idiomas.ruta_id AND rutas_con_idiomas.idioma_id = ?  
             WHERE rutas.estado = true", [$idIdioma]);*/
                             
        return ['query' => $query];
    }
}
