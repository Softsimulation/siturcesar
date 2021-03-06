<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\Exportarturismoreceptor;
use App\Http\Requests;
use App\Models\Exportacion;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Mes_Anio;

class ExportacionController extends Controller
{
    public function __construct()
    {
        
       $this->middleware('auth');
       $this->middleware('role:Admin|Estadistico');
       if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
    }
    
    public function getIndex(){
        
        return view('exportacion.Index');
        
    }
    
    public function getMeses(){
        
        $meses=Mes_Anio::with('mes')->with('anio')->orderby('anio_id')->orderby('mes_id')->get();
        return ["meses"=>$meses];
    }
    
    public function postExportar(Request $request){
        
        $validator=\Validator::make($request->all(),['nombre'=>'required',
                                                     'fecha_inicial'=>'required_if:nombre,receptor,interno,sostenibilidad|date|before:tomorrow',
                                                     'fecha_final'=>'required_if:nombre,receptor,interno,sostenibilidad|date|before:tomorrow',
                                                     'categoria'=>'required_if:nombre,ofertayempleo|in:1,2,3,4,5,6',
                                                     'mes'=>'required_if:nombre,ofertayempleo|exists:meses_de_anio,id'
        ]);
        $url='';
        if($validator->fails()){
            
            return ["success"=>false,"errores"=>$validator->errors()];
            
        }
        
        switch($request->nombre){
            
            case 'receptor': 
                $this->ExportacionTurismoReceptor2($request->fecha_inicial,$request->fecha_final);
                $url='/excel/exports/Exportacion.xlsx';
            break;
             case 'interno': 
               $url= $this->ExportacionTurismoInterno2($request->fecha_inicial,$request->fecha_final);
            break;
             case 'sostenibilidad': 
               $url= $this->ExportacionSostenibilidadpst($request->fecha_inicial,$request->fecha_final);
            break;
            case 'ofertayempleo': 
               $url= $this->ExportacionOfertayEmpleo($request->categoria,$request->mes);
            break;
            case 'hogares':
                $url= $this->ExportacionSostenibilidadhogares($request->categoria,$request->mes);
            break;
            
        }
        
        return ["success"=>true,'url'=>$url];
    }
    
    protected function ExportacionTurismoReceptor2($fecha_inicial,$fecha_final){
        
        $exportacion=new Exportacion();
        $exportacion->nombre="Exportacion turismo receptor";
        $exportacion->fecha_realizacion=\Carbon\Carbon::now();
        $exportacion->fecha_inicio=$fecha_inicial;
        $exportacion->fecha_fin=$fecha_final;
        $exportacion->estado=1;
        $exportacion->usuario_realizado="Exportacion";
        $exportacion->hora_comienzo=\Carbon\Carbon::now()->format('h:i:s');
        $exportacion->save();
        
        $datos = \DB::select("SELECT *from exportacionreceptor(?,?)", array($fecha_inicial ,$fecha_final));
        $array= json_decode( json_encode($datos), true);
        $datos=$array;
        array_unshift ($datos,[
                    'codigo '   =>  'Identificación de registro digitado. Un registro esta compuesto por: Digitación hoja de registro más encuesta física o solo hoja de registro si ninguno del grupo diligencia encuesta fisica (Sistema genera automáticamente a medida que se crea un nuevo registro)',
'fecha '    =>                      'Fecha de recolección de datos viajeros',
'hora ' =>                      'Hora de recolección de datos viajeros',                    
'am_pm '    =>                      'Formato hora',
'cod_lugar '    =>                      'Código lugar de recolección de datos',
'cod_base ' =>                      'Código que resume (Fecha de recopilación de datos + Encuestador que ejecuto la labor + lugar de recopilacion) Va marcado con el código de base el sobre que entrega cada encuestador junto con la encuestas y hoja de registro del día. Es un código que ayuda a controlar las entregas de trabajo de campo del encuestador, la supervisión de las encuesta fisicas y el seguimiento al trabajo de digitación. Es un código de 1 a n. Empieza de nuevo cada año.',
'cod_encuestador_EN '   =>                      'Código encuestador',
'cod_Grupo_CG ' =>                      'Código de grupo',
'num_postal_NP '    =>                      'Número de postal (0001 a 9999)',
'total_Per '    =>                      'Total personas del viaje en grupo',
'perviven_Stder '   =>                      'Total personas viven en Cesar',
'noStder_men15 '    =>                      'Personas no viven en Cesar ≤ 15 años',
'noStder_may15 '    =>                      'Personas no viven en Cesar > 15 años',
'noStder_adic_men15 '   =>                      'Personas no viven en Cesar ≤ 15 años adicionales que viajaron con el grupo a Cesar pero no estaban en el lugar de recopilación de datos',
'noStder_adic_may15 '   =>                      'Personas no viven en Cesar > 15 años adicionales que viajaron con el grupo a Cesar pero no estaban en el lugar de recopilación de datos',
'excur_nino_jov '   =>                      'Excursión Niños/Jóvenes',
'conteo_grup_noparticipan ' =>                      'Conteo grupos no desean participar en el estudio',
'A1 '   =>                      'Fecha de llegada de Cesar (Utilizar para definir los periodos de tiempo)',
'A2 '   =>                      'Fecha de salida de Cesar',
'A3 '   =>                      'Ciudad/municipio de residencia',
'A3_1 ' =>                      'Departamento/Estado/Provincia',
'A3_2 ' =>                      'País',
'A4 '   =>                      'Motivo principal del viaje',
'A4_3_1 '   =>                      'Cúantas horas durará/duró la parada más larga en Cesar',
'A4_5_1 '   =>                      'La finalidad del servicio médico es',
'otro_motivo '  =>                      'Otro motivo para venir a Cesar',
'A5 '   =>                      'Lugar de nacimiento',
'A6 '   =>                      'Género',
'A7 '   =>                      'Edad',
'A8_1 ' =>                      'Nombre ',
'A8_2 ' =>                      'Apellidos',
'A9_1 ' =>                      'Correo electrónico 1',
'A9_2 ' =>                      'Correo electrónico 2',
'A10 '  =>                      'Celular',
'A11 '  =>                      'Fijo',
'cod_grupo_codificado ' =>                      'Lo genera el sistema y asigna 1 al código de grupo no duplicado y 0 al duplicado. Se genera duplicado de un mismo código de grupo, porque en un mismo grupo puede contestar más de una persona la encuesta. ',
'visitante '    =>                      'Lo genera el sistema y asigna 1 Si es visitante y 0 si no es visitante. "El criterio de asignación de 1 o 0 se describe en la pestaña "visitante"',
'idioma '   =>                      'Idioma de envío encuesta electrónica. Lo genera el sistema asociando el país de residencia del encuestado con el idioma asociado en el campo "envio_encuesta" de la "base paises_ciudades_indicativos"(Ver anexo C).  1= Español; 2= Inglés',
'envio_encuesta '   =>                      'Fecha de envío encuesta primera vez. La calcula el sistema y es igual fecha de salida de Cesar más dos días',
'llamada '  =>                      'Fecha de llamada primera vez. La calcula el sistema y es gual a la fecha de salida de Cesar más tres días',
'tipo_llamada ' =>                      'Llamada a realizar. Lo genera el sistema asociando el país de residencia del encuestado con el campo "tipo_llamada" de la "base paises_ciudades_indicativos" (Ver anexo C). 1= Nacional; 2=Internacional en español ; 3= internacional en inglés',
'codigo_electronica '   =>                      'Lo genera el sistema. Es el código de unión de encuesta fisica con encuesta electrónica. Cuando el sistema detecta que el registro es un encuestado que obedece a visitante, genera el código de encuesta electrónica para él.',                   
'survey_id '    =>                      'Lo genera el sistema. Es el código de unión de encuesta fisica con encuesta electrónica. Cuando el sistema detecta que el registro es un encuestado que obedece a visitante, genera el código de encuesta electrónica para él.',
'physical_survey_id '   =>                      'Identificación de registro digitado. Un registro esta compuesto por: Digitación hoja de registro más encuesta física o solo hoja de registro si ninguno del grupo diligencia encuesta fisica (Sistema genera automáticamente a medida que se crea un nuevo registro)',
'current_page ' =>                      'Parte de la encuesta hasta donde diligencio el usuario a,b,c,d,e,f,g',
'A111 ' =>                      'A1. ¿Cuál es su país de residencia?',
'A1_1 ' =>                      'A1.1 ¿Cuál es su departamento/estado/provincia de residencia?',
'A21 '  =>                      'A2. ¿Cuál es su ciudad o municipio de residencia?',
'B1 '   =>                      'B1. ¿Cuántas noches pasó en Cesar? [Si es 0 noches seleccione]',
'B2 '   =>                      'B2. ¿Cuántos municipios visitó desde el momento que llegó a Cesar hasta su partida?',
'B3_1 ' =>                      'B3.1 Primer municipio:',
'B3_1_1 '   =>                      'B3.1.1 ¿Cuántas noches pasó? [si es 0 noches ingresar]',
'B3_1_2 '   =>                      'B3.1.2 ¿Tipo de alojamiento utilizado?',   
'B3_1_2_otro '  =>                      '',
'B3_2 ' =>                      'B3.2 Segundo municipio: _____',
'B3_2_1 '   =>                      'B3.2.1 ¿Cuántas noches pasó? [si es 0 noches ingresar]',
'B3_2_2 '   =>                      'B3.2.2 ¿Tipo de alojamiento utilizado?',  
'B3_2_2_otro '  =>                      '', 
'B3_3 ' =>                      'B3.3 Tercer municipio:     _____',
'B3_3_1 '   =>                      'B3.3.1 ¿Cuántas noches pasó? [si es 0 noches ingresar] ________',
'B3_3_2 '   =>                      'B3.3.2 ¿Tipo de alojamiento utilizado?',   
'B3_3_2_otro '  =>                      '',
'B3_4 ' =>                      'B3.4 Cuarto municipio:     _____',
'B3_4_1 '   =>                      'B3.4.1 ¿Cuántas noches? [si es 0 noches ingresar] ________',
'B3_4_2 '   =>                      'B3.4.2 ¿Tipo de alojamiento utilizado?',  
'B3_4_2_otro '  =>                      '', 
'B3_5 ' =>                      'B3.5 Quinto municipio:     _____',
'B3_5_1 '   =>                      'B3.5.1 ¿Cuántas noches? [si es 0 noches ingresar] ________',
'B3_5_2 '   =>                      'B3.5.2 ¿Tipo de alojamiento utilizado?',
'B3_5_2_otro '  =>                      '',
'B3_6 ' =>                      'B3.6 Sexto municipio:      _____',
'B3_6_1 '   =>                      'B3.6.1 ¿Cuántas noches? [si es 0 noches ingresar] ________',
'B3_6_2 '   =>                      'B3.6.2 ¿Tipo de alojamiento utilizado?',
'B3_6_2_otro '  =>                      '',
'B3_7 ' =>                      'B3.7 Séptimo municipio: _____  ',
'B3_7_1 '   =>                      'B3.7.1 ¿Cuántas noches? [si es 0 noches ingresar] ________ ',
'B3_7_2 '   =>                      'B3.7.2 ¿Tipo de alojamiento utilizado?',
'B3_7_2_otro '  =>                      '',
'B4 '   =>                      'B4. De los municipios visitados, ¿Cuál fue el destino principal del viaje a Cesar?______',
'B5_1 '     =>                      '1. Asistencia a espectáculos artísticos (Sin festivales)',
'B5_2 ' =>                      '2. Asistencia a festivales artísticos ',
'B5_3 ' =>                      '3. Asistencia a fiestas y ferias',
'B5_4 ' =>                      '4. Visita a museos/casas de la cultura/ iglesias',
'B5_5 ' =>                      '5. Visita a parques temáticos/parque de atracciones', 
'B5_6 ' =>                      '6. Visita a parques y sitios naturales',
'B5_7 ' =>                      '7. Recorrer las calles y parques del casco urbano', 
'B5_8 ' =>                      '8. Visita temáticas en haciendas o fábricas',
'B5_9 ' =>                      '9. Visita a casinos/juegos de azar',
'B5_10 '    =>                      '10. Práctica de deportes ',
'B5_11 '    =>                      '11. Asistencia a competencias deportivas.', 
'B5_12 '    =>                      '12. Visita a sitios nocturnos',
'B5_13 '    =>                      '13. Visita a centros comerciales', 
'B5_14 '    =>                      '14. Compras por fuera de centros comerciales',
'B5_15 '    =>                      '15. Actividades religiosas', 
'B5_16 '    =>                      '16. Realizar inversiones/Reuniones de negocios',
'B5_17 '    =>                      '17. Asistir a conferencias/Congresos/ferias comerciales',
'B5_18 '    =>                      '18. Ninguna',
'B5_otras_cuales '  =>                      '',
'B5_otras_cuales_1 '    =>                      '',
'B5_otras_cuales_2 '    =>                      '',
'B5_otras_cuales_3 '    =>                      '',
'B5_otras_cuales_4 '    =>                      '',
'B5_otras_cuales_5 '    =>                      '',
'B5_4_1_1 ' =>                      '1. Catedrales, iglesias', 
'B5_4_1_2 '     =>                      '2. Casas de la cultura',  
'B5_4_1_3 ' =>                      '3. Museos de arte',
'B5_4_1_4 ' =>                      '4. Museos arqueológicos', 
'B5_4_1_5 ' =>                      '5. Haciendas y/o casas históricas',
'B5_4_1_6 ' =>                      '6. Puentes históricos', 
'B5_4_1_7 ' =>                      '7. Monumentos',  
'B5_4_1_8 ' =>                      '8. Cementerios', 
'B5_4_1_9 ' =>                      '9. Santuarios',
'B5_4_1_otros_cuales '  =>                      '',
'B5_4_1_otros_cuales_1 '    =>                      '',
'B5_4_1_otros_cuales_2 '    =>                      '',
'B5_4_1_otros_cuales_3 '    =>                      '',
'B5_4_1_otros_cuales_4 '    =>                      '',
'B5_4_1_otros_cuales_5 '    =>                      '',
'B5_5_1_1 ' =>                      '1. Parque Nacional del Chicamocha',  
'B5_5_1_2 ' =>                      '2. Acuaparque Nacional del Chicamocha',
'B5_5_1_3 ' =>                      '3. Neomundo', 
'B5_5_1_4 ' =>                      '4. Parque del Agua', 
'B5_5_1_5 ' =>                      '5. Ecoparque Cerro del Santísimo', 
'B5_5_1_6 '     =>                      '6. Acualago',
'B5_5_1_7 ' =>                      '7. Ninguno de los anteriores',
'B5_6_1_1 ' =>                      '1. Parque Gallineral',
'B5_6_1_2 ' =>                      '2. Reservas/Parques naturales', 
'B5_6_1_3 ' =>                      '3. Miradores paisajísticos',
'B5_6_1_4 ' =>                      '4. Cascadas', 
'B5_6_1_5 ' =>                      '5. Ríos, pozos, balnearios', 
'B5_6_1_6 ' =>                      '6. Zoológicos', 
'B5_6_1_7 ' =>                      '7. Jardines botánicos', 
'B5_6_1_8 ' =>                      '8. Cuevas',
'B5_6_1_otros_cuales '  =>                      '',
'B5_6_1_otros_cuales_1 '    =>                      '',
'B5_6_1_otros_cuales_2 '    =>                      '',
'B5_6_1_otros_cuales_3 '    =>                      '',
'B5_6_1_otros_cuales_4 '    =>                      '',
'B5_6_1_otros_cuales_5 '    =>                      '',
'B5_8_1_1 ' =>                      '1. Proceso del café ',
'B5_8_1_2 ' =>                      '2. Proceso de la panela',
'B5_8_1_3 ' =>                      '3. Proceso del dulce',
'B5_8_1_otros_cuales '  =>                      '',
'B5_8_1_otros_cuales_1 '    =>                      '',
'B5_8_1_otros_cuales_2 '    =>                      '',
'B5_8_1_otros_cuales_3 '    =>                      '',
'B5_8_1_otros_cuales_4 '    =>                      '',
'B5_8_1_otros_cuales_5 '    =>                      '',
'B5_10_1_1 '    =>                      '1. Rafting (Canotaje)', 
'B5_10_1_2 '    =>                      '2. Espelelismo (Exploración recreativa de cuevas)',  
'B5_10_1_3 '    =>                      '3. Rappel en cascadas',
'B5_10_1_4 '    =>                      '4. Parapente', 
'B5_10_1_5 '    =>                      '5. Senderismo (Caminatas)', 
'B5_10_1_6 '    =>                      '6. Escalada en roca', 
'B5_10_1_7 '    =>                      '7. Bungee Jumping ',
'B5_10_1_otros_cuales ' =>                      '',
'B5_10_1_otros_cuales_1 '   =>                      '',
'B5_10_1_otros_cuales_2 '   =>                      '',
'B5_10_1_otros_cuales_3 '   =>                      '',
'B5_10_1_otros_cuales_4 '   =>                      '',
'B5_10_1_otros_cuales_5 '   =>                      '',
'C1 '   =>                      'C1. ¿Qué tipo de transporte utilizó para llegar a Cesar (Seleccione únicamente en el que recorrió la mayor distancia)?',
'C2 '   =>                      'C2. ¿Cuál fue el transporte utilizado la mayor parte del tiempo para desplazarse por Cesar?', 
'D1 '   =>                      'D1. ¿Cuántas personas incluyéndose usted, realizaron juntos el viaje desde la llegada hasta la salida de Cesar? [Si viajo solo ingrese 1]',
'D2_1 ' =>                      '1. Viajé solo',   
'D2_2 ' =>                      '2. Mi pareja/Novia(o)/esposa(o)',    
'D2_3 ' =>                      '3. Mis Hijos' ,
'D2_4 ' =>                      '4. Otros familiares',     
'D2_5 ' =>                      '5. Amigo(s)',  
'D2_6 ' =>                      '6. Compañeros de trabajo', 
'D2_7 ' =>                      '7. Compañeros de estudio', 
'D2_8 ' =>                      '8. Otros turistas', 
'D8_1 ' =>                      '¿Cuántos eran otros turistas?', 
'D2_otros_cuales '  =>                      '',
'D2_otros_cuales_1 '    =>                      '',
'D2_otros_cuales_2 '    =>                      '',
'D2_otros_cuales_3 '    =>                      '',
'D2_otros_cuales_4 '    =>                      '',
'D2_otros_cuales_5 '    =>                      '',
'E1 '   =>                      'E1. ¿El viaje a Cesar hizo parte de un paquete/plan turístico o excursión?',
'E1_1_1 '   =>                      'Barranquilla',
'E1_1_2 '   =>                      'Bogotá',
'E1_1_3 '   =>                      'Cartagena',
'E1_1_4 '   =>                      'Cúcuta',
'E1_1_ninguna ' =>                      'Ninguna',
'E1_1_otros_cuales '    =>                      '',
'E1_1_otros_cuales_6 '  =>                      '',
'E1_1_otros_cuales_7 '  =>                      '',
'E1_1_otros_cuales_8 '  =>                      '',
'E1_1_otros_cuales_9 '  =>                      '',
'E1_1_otros_cuales_10 ' =>                      '',
'E2 '   =>                      'E2. ¿Cuánto usted pagó por el paquete turístico o excursión? [Si la respuesta es 0 ingrese cero.] Pesos Colombianos', 
'E2_1 ' =>                      'E2.1 ¿A cuántas personas cubrió? _______ personas',
'E3 '   =>                      'E3. El paquete/plan turístico o excursión fue comprado a:', 
'E3_1 ' =>                      'E3.1 En donde está ubicada la agencia de viajes/operador turístico:', 
'E4_1 ' =>                      '1. Transporte aéreo internacional', 
'E4_2 ' =>                      '2. Transporte aéreo desde una ciudad de Colombia a Cesar ',
'E4_3 ' =>                      '3. Transporte terrestre de pasajeros desde una ciudad de Colombia a Cesar ',
'E4_4 ' =>                      '4. Transporte terrestre de pasajeros para movilizarse  dentro de Cesar',
'E4_5 ' =>                      '7. Alojamiento',
'E4_6 ' =>                      '8. Alimento y bebidas',
'E4_7 ' =>                      '9. Actividades recreativas, culturales y deportivas',
'E4_8 ' =>                      '13.Asistencia a conferencias, seminarios, congresos, ferias comerciales y exposiciones',
'E4_otros_servicios '   =>                      '',
'E4_otros_servicios_1 ' =>                      '',
'E4_otros_servicios_2 ' =>                      '',
'E4_otros_servicios_3 ' =>                      '',
'E4_otros_servicios_4 ' =>                      '',
'E4_otros_servicios_5 ' =>                      '',
'E4_otros_servicios_6 ' =>                      '',
'E5_99 '    =>                      '99. No realicé ningún tipo de gasto ',                                                        
'E5_1 ' =>                      '1. Transporte aéreo internacional (ida-vuelta)',
'E5_1_1 '   =>                      'E5.1 ¿Cuánto gastó?',
'E5_1_1_1 ' =>                      'E5.1.1 Tipo de Moneda:__',
'E5_2_1 '   =>                      'E5.2 ¿A cuántas personas cubrió? [Si solo a usted, ingrese 1]',
'E5_2 ' =>                      '2. Transporte aéreo desde una ciudad de Colombia a Cesar (ida-vuelta)',
'E5_1_2 '   =>                      'E5.1 ¿Cuánto gastó?',
'E5_2_2 '   =>                      'E5.2 ¿A cuántas personas cubrió? [Si solo a usted, ingrese 1]',
'E5_3 ' =>                      '3. Transporte terrestre de pasajeros interdepartamental (ida-vuelta)',
'E5_1_3 '   =>                      'E5.1 ¿Cuánto gastó?',
'E5_2_3 '   =>                      'E5.2 ¿A cuántas personas cubrió? [Si solo a usted, ingrese 1]',
'E5_4 ' =>                      '4. Transporte terrestre de pasajeros intermunicipal',
'E5_1_4 '   =>                      'E5.1 ¿Cuánto gastó?',
'E5_2_4 '   =>                      'E5.2 ¿A cuántas personas cubrió? [Si solo a usted, ingrese 1]',
'E5_5 ' =>                      '5. Alquiler de vehículo',
'E5_1_5 '   =>                      'E5.1 ¿Cuánto gastó?',
'E5_2_5 '   =>                      'E5.2 ¿A cuántas personas cubrió? [Si solo a usted, ingrese 1]',
'E5_6 ' =>                      '6. Combustible',
'E5_1_6 '   =>                      'E5.1 ¿Cuánto gastó?',
'E5_2_6 '   =>                      'E5.2 ¿A cuántas personas cubrió? [Si solo a usted, ingrese 1]',
'E5_7 ' =>                      '7. Alojamiento',
'E5_1_7 '   =>                      'E5.1 ¿Cuánto gastó?',
'E5_2_7 '   =>                      'E5.2 ¿A cuántas personas cubrió? [Si solo a usted, ingrese 1]',
'E5_8 ' =>                      '8. Alimento y bebidas',
'E5_1_8 '   =>                      'E5.1 ¿Cuánto gastó?',
'E5_2_8 '   =>                      'E5.2 ¿A cuántas personas cubrió? [Si solo a usted, ingrese 1]',
'E5_9 ' =>                      '9. Actividades recreativas, culturales y deportivas',
'E5_1_9 '   =>                      'E5.1 ¿Cuánto gastó?',
'E5_2_9 '   =>                      'E5.2 ¿A cuántas personas cubrió? [Si solo a usted, ingrese 1]',
'E5_10 '    =>                      '10. Artesanías/recuerdos',
'E5_1_10 '  =>                      'E5.1 ¿Cuánto gastó?',
'E5_2_10 '  =>                      'E5.2 ¿A cuántas personas cubrió? [Si solo a usted, ingrese 1]',
'E5_11 '    =>                      '11. Objetos valiosos ',
'E5_1_11 '  =>                      'E5.1 ¿Cuánto gastó?',
'E5_2_11 '  =>                      'E5.2 ¿A cuántas personas cubrió? [Si solo a usted, ingrese 1]',
'E5_12 '    =>                      '12. Bienes de consumo duradero (Ropa, calzado,etc) ',
'E5_1_12 '  =>                      'E5.1 ¿Cuánto gastó?',
'E5_2_12 '  =>                      'E5.2 ¿A cuántas personas cubrió? [Si solo a usted, ingrese 1]',
'E5_13 '    =>                      '13. Asistencia a conferencias/congresos ',
'E5_1_13 '  =>                      'E5.1 ¿Cuánto gastó?',
'E5_2_13 '  =>                      'E5.2 ¿A cuántas personas cubrió? [Si solo a usted, ingrese 1]',
'E5_14 '    =>                      '14. Cursos/talleres de enseñanza ',
'E5_1_14 '  =>                      'E5.1 ¿Cuánto gastó?',
'E5_2_14 '  =>                      'E5.2 ¿A cuántas personas cubrió? [Si solo a usted, ingrese 1]',
'E5_15 '    =>                      '15. Servicios médicos (Incluye la cirugía estética)',
'E5_1_15 '  =>                      'E5.1 ¿Cuánto gastó?',
'E5_2_15 '  =>                      'E5.2 ¿A cuántas personas cubrió? [Si solo a usted, ingrese 1]',
'E5_otros_gastos '  =>                      '',
'E5_otros_gastos_1 '    =>                      '',
'E5_otros_gastos_2 '    =>                      '',
'E5_otros_gastos_3 '    =>                      '',
'E5_otros_gastos_4 '    =>                      '',
'E5_otros_gastos_5 '    =>                      '',
'E5_1_otros_gastos '    =>                      'E5.1 ¿Cuánto gastó?',
'E5_2_otros_gastos '    =>                      'E5.2 ¿A cuántas personas cubrió? [Si solo a usted, ingrese 1]',
'E6_99 '    =>                      '99. Esta situación no se presentó durante el viaje',
'E6_1 ' =>                      '1. Transporte aéreo internacional (ida-vuelta)',
'E6_2 ' =>                      '2. Transporte aéreo desde una ciudad de Colombia a Cesar (ida-vuelta)',
'E6_3 ' =>                      '3. Transporte terrestre de pasajeros interdepartamental (ida-vuelta)',
'E6_4 ' =>                      '4. Transporte terrestre de pasajeros intermunicipal',
'E6_5 ' =>                      '5. Alquiler de vehículo',
'E6_6 ' =>                      '6. Combustible',
'E6_7 ' =>                      '7. Alojamiento',
'E6_8 ' =>                      '8. Alimento y bebidas',
'E6_9 '     =>                      '9. Actividades recreativas, culturales y deportivas',
'E6_10 '    =>                      '10. Artesanías/recuerdos',
'E6_11 '    =>                      '11. Objetos valiosos ',
'E6_12 '    =>                      '12. Bienes de consumo duradero (Ropa, calzado,etc) ',
'E6_13 '    =>                      '13. Asistencia a conferencias/congresos ',
'E6_14 '    =>                      '14. Cursos/talleres de enseñanza ',
'E6_15 '    =>                      '15. Servicios médicos (Incluye la cirugía estética)',
'E6_otros_gastos '  =>                      '',
'E6_otros_gastos_1 '    =>                      '',
'E6_otros_gastos_2 '    =>                      '',
'E6_otros_gastos_3 '    =>                      '',
'E6_otros_gastos_4 '    =>                      '',
'E6_otros_gastos_5 '    =>                      '',
'E7 '   =>                      'E7. ¿Cuál es el nombre de la empresa de transporte terrestre de pasajeros utilizado desde una ciudad de Colombia a Cesar?: ___________',
'E8 '   =>                      'E8. El alquiler de vehículo fue realizado en: ',
'E9 '   =>                      'E9. En dónde fue realizado el mayor gasto de productos como ropa, calzado implementos deportivos,  etc (bienes duraderos) antes y durante el viaje a Cesar:',
'E10_1 '    =>                      '1. Por mi ',
'E10_2 '    =>                      '2. Por mi pareja/Novia(o)/Esposa(o)  ', 
'E10_3 '    =>                      '3. Cada uno asumió sus gastos  ', 
'E10_4 '    =>                      '4. Se sumaron todos los gastos y se dividió por partes iguales ',
'E10_5 '    =>                      '5. Por otro(s) familiares(s)/Amigos(s)',
'E10_6 '    =>                      '6. Cada familia pagó lo que le correspondió ',
'E10_7 '    =>                      '7. Por todos pero no se dividió en partes iguales', 
'E10_8 '    =>                      '8. Empresa en la que trabajo/trabaja un integrante del grupo',
'E10_9 '    =>                      '9. Una parte por empresa en la que trabajo/trabaja un integrante del grupo',
'E10_10 '   =>                      '10. Entidad patrocinadora',
'E10_Otro ' =>                      '',
'E10_Otro_1 '   =>                      '',
'E10_Otro_2 '   =>                      '',
'E10_Otro_3 '   =>                      '',
'E10_Otro_4 '   =>                      '',
'E10_Otro_5 '   =>                      '', 
'F1 '   =>                      'F1. ¿Durante su viaje utilizó servicio de alojamiento?',  
'F1_1 ' =>                      '1. Estado del edificio',  
'F1_2 ' =>                      '2. Estado de los muebles',
'F1_3 ' =>                      '3. Estado sabana-toallas', 
'F1_4 ' =>                      '4. Higiene y limpieza',
'F1_5 ' =>                      '5.Trato del personal',
'F1_6 ' =>                      '6. Servicio de comidas',
'F1_7 ' =>                      '7. Precios de alojamiento',
'F2 '   =>                      'F2.  ¿Durante su viaje utilizó servicios de restaurante?  ',
'F2_8 ' =>                      '8. Sabor de los platos servidos ',
'F2_9 ' =>                      '9. Variedad de la oferta gastronómica ',
'F2_10 '    =>                      '10. Trato del personal',
'F2_11 '    =>                      '11. Higiene y Limpieza',
'F2_12 '    =>                      '12. Precios de los platos',
'F13 '  =>                      '13. Limpieza y aseo en los municipios',
'F14 '  =>                      '14. Limpieza y conservación de los lugares visitados (parques temáticos, parque naturales, sitios naturales (cascadas, ríos)', 
'F15 '  =>                      '15. Hospitalidad',
'F16 '  =>                      '16. Actividades culturales',
'F17 '  =>                      '17. Actividades deportivas',
'F18 '  =>                      '18. Parques',
'F19 '  =>                      '19. Discotecas, bares, casinos',
'F20 '  =>                      '20. Estado de carreteras',
'F21 '  =>                      '21. Transporte local',
'F22 '  =>                      '22. Seguridad',
'F3 '   =>                      'F3. ¿Qué recomendaría para lograr atraer más visitantes a Cesar (Resalte en detalle aspectos que realmente le disgustaron). ',
'F3_1 ' =>                      'F3. ¿Qué recomendaría para lograr atraer más visitantes a Cesar (Resalte en detalle aspectos que realmente le disgustaron). ',
'F3_2 ' =>                      'F3. ¿Qué recomendaría para lograr atraer más visitantes a Cesar (Resalte en detalle aspectos que realmente le disgustaron).', 
'F3_3 ' =>                      'F3. ¿Qué recomendaría para lograr atraer más visitantes a Cesar (Resalte en detalle aspectos que realmente le disgustaron).', 
'F3_4 ' =>                      'F3. ¿Qué recomendaría para lograr atraer más visitantes a Cesar (Resalte en detalle aspectos que realmente le disgustaron).',
'F3_5 ' =>                      'F3. ¿Qué recomendaría para lograr atraer más visitantes a Cesar (Resalte en detalle aspectos que realmente le disgustaron).',
'F4 '   =>                      'F4. En una escala del 1 al 10, donde 1 es Muy insatisfecho y 10 Muy satisfecho. Valore en general la experiencia de su visita a Cesar.',                     
'F5 '   =>                      'F5. ¿Volvería a visitar Cesar?  ',
'F6 '   =>                      'F6. ¿Recomendaría a Cesar como destino turístico',
'F7 '   =>                      'F7. ¿Cuántas veces ha venido a Cesar en los últimos dos años? ',
'G1_1 ' =>                      '1. Ya los conocía',  
'G1_2 ' =>                      '2. Amigos y/o familiares', 
'G1_3 ' =>                      '3. Búsquedas en internet', 
'G1_4 ' =>                      '4. Medios de comunicación masiva (prensa, radio, televisión.)',    
'G1_5 ' =>                      '6. Agencia de viajes', 
'G1_otras_cuales '  =>                      '5. El Portal Visita Cesar',
'G1_otras_cuales_1 '    =>                      '7. Guía turística impresa',
'G1_otras_cuales_2 '    =>                      '8. Twitter',
'G1_otras_cuales_3 '    =>                      '9. Facebook',
'G1_otras_cuales_4 '    =>                      '10. Otras redes sociales',
'G1_otras_cuales_5 '    =>                      '11. Correo electrónico',
'G2_1 ' =>                      '14. No busqué más información',
'G2_2 ' =>                      '1. Familiares ',
'G2_3 ' =>                      '2. Hotel ',
'G2_4 ' =>                      '3. Otros turistas',
'G2_5 ' =>                      '4. Busqué en internet  (Waze; Despegar: Tripadvisor)',
'G2_otras_cuales '  =>                      '5. Redes sociales',
'G2_otras_cuales_1 '    =>                      '6. Blog',
'G2_otras_cuales_2 '    =>                      '7. Amigos',
'G2_otras_cuales_3 '    =>                      '8. Visité el Portal Visita Cesar',
'G2_otras_cuales_4 '    =>                      '9. Guías de turismo',
'G2_otras_cuales_5 '    =>                      '10. Agencias de viajes/operadores/Promotores',
'G3_1 ' =>                      '1.  No compartí en redes sociales ',
'G3_2 ' =>                      '2.  FacebooK ',
'G3_3 ' =>                      '3.  Twitter ',
'G3_4 ' =>                      '8.  Youtube ',
'G3_5 ' =>                      '11. Instagram',
'G3_otros_cuales '  =>                      '4. Linkedin',
'G3_otros_cuales_1 '    =>                      '5. Pinterest',
'G3_otros_cuales_2 '    =>                      '6. TripAdvisor',
'G3_otros_cuales_3 '    =>                      '7. Google +',
'G3_otros_cuales_4 '    =>                      '9. Flickr',
'G3_otros_cuales_5 '    =>                      '10. Mensajería (Skype, Whatsapp, messenger, Snapchat)',
'G4 '   =>                      'G4. ¿Le gustaría que le enviáramos información sobre Cesar a su correo electrónico?',  
'G5 '   =>                      'G5. ¿Le gustaría que le enviáramos una invitación por redes sociales para seguir a Cesar?', 
'G5_1_1 '   =>                      '1.1 ¿Cómo podemos buscarlo por facebook?',
'G5_1_2 '   =>                      '1.2 ¿Cómo podemos buscarlo en twitter?'
 
                ]);
        
        try{
        
               \Excel::create('Exportacion', function($excel) use($datos) {
        
                    $excel->sheet('Turismo receptor', function($sheet) use($datos) {
                       
                
                        $sheet->fromArray($datos, null, 'A1', false, true);
                
                    });
                
                })->store('xlsx', public_path('excel/exports'));
                
                
                
                $exportacion->estado=2;
                $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
                $exportacion->save();
                
                return '/excel/exports/Exportacion.xlsx'; 
        
        
        }catch(Exception $e){
            
            
            $exportacion=$e;
            $exportacion->estado=3;
            $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
            $exportacion->save();
            
        }
        
        
    }
    
     protected function ExportacionTurismoInterno2($fecha_inicial,$fecha_final){
        
        $exportacion=new Exportacion();
        $exportacion->nombre="Exportacion turismo interno";
        $exportacion->fecha_realizacion=\Carbon\Carbon::now();
        $exportacion->fecha_inicio=$fecha_inicial;
        $exportacion->fecha_fin=$fecha_final;
        $exportacion->estado=1;
        $exportacion->usuario_realizado="Exportacion";
        $exportacion->hora_comienzo=\Carbon\Carbon::now()->format('h:i:s');
        $exportacion->save();
        
        $datos = \DB::select("SELECT *from exportacioninterno(?,?)", array($fecha_inicial ,$fecha_final));
        $array= json_decode( json_encode($datos), true);
       $datos=$array;
        array_unshift ($datos,['	survey_id	'=>'	Código que genera el sistema para identificar cada hogar','
	codigo_hogar	'=>'',
	'phone_surveyid	'=>'	Código que genera el sistema para identificar encuesta electrónica a realizar asistida telefónicamente  (Momento II). Ingresa "0" si el intregante del hogar no cumple las condiciones para ser entrevistado en el momento II, es decir, no mayor de 15 años y no realizo viajes en el periodo de referencia. De lo contrario genera código único para cada persona que cumple las condiciones para la entrevista telefónica. Este código También se encuentra en la base de datos del momento II.','
	a1	'=>'	Fecha de recopilación de los datos','
	a2	'=>'	Hora','
	a2_1	'=>'	am_pm','
	a3	'=>'	Código del hogar (CH). A cada encuestador se le asigna segmento de códigos secuenciales, el primer encuestador del 1 al 20, segundo encuestador del 21 al 40, .........  450 al 600, para que identifiquen cada hogar.','
	a4	'=>'	Código de encuestador (EN). Cada encuestador se identifica con un número único e irrepetible. El primer encuestador se le asigna el 1 al segundo encuestador 2,... etc.','
	b1	'=>'	B1. ¿Cuántas personas incluyéndose usted integran su hogar? ______','
	cod_integra_hogar_1	'=>'	Según el número de integrantes del hogar el sistema asigna un número. Ejemplo: Si el hogar esta compuesto por 3 personas, en el orden que fueron digitadas en la encuesta ingresa 1 Al jefe del hogar que va en el primer registro, 2 al segundo intregrante y 3 al tercer integrante del hogar.','
	code	'=>'	El un número único e irrepetible que se asigna a cada persona registrada en la base de datos.','
	b2_1_1	'=>'	Nombre del intregrante del hogar','
	b2_1_2	'=>'	Género','
	b2_1_3	'=>'	Edad','
	b2_1_4	'=>'	Nivel de educación más alto alcanzado:','
	c1	'=>'	_Nombre del integrante del hogar_ C1. ¿Sin importar el motivo, durante los meses de diciembre y enero finalizó algún viaje que había emprendido?: 1Si ; 2. No','
	d1	'=>'	D1. Nombre de la persona entrevistada:','
	d2	'=>'	D2. Teléfono fijo de la casa:','
	d3	'=>'	D3. Celular de la persona entrevistada:','
	d4	'=>'	D4. Dirección:','
	d5	'=>'	D5. Municipio (En base de datos guarda el código de centro poblado del archivo )','
	d6	'=>'	Barrio','
	d7	'=>'	Estrato','
	observaciones	'=>'	Espacio para observaciones que haga el encuestado por ejemplo: Cuando contacten a Paola para encuesta telefónica hacerlo después de las 6:00 p.m. ','
	phone_surveyid1	'=>'	Código que genera el sistema para identificar encuesta electrónica a realizar asistida telefónicamente  (Momento II). ','
	current_page	'=>'	Parte de la encuesta hasta donde fue constestada (A, B, C, D , E, A! (Ingresa A! cuando ninguno de los viajes es turístico y allí culmina la encuesta)))','
	a11	'=>'	A1. ¿Cuántos viajes realizados por cualquier motivo, finalizó en los meses de diciembre y enero? (No incluya viajes dentro de Bucaramanga, Floridablanca, Piedecuesta y Girón) ___','
	a2_11	'=>'	A2.1 ¿En qué fecha inicio el primer viaje? ___','
	a2_2	'=>'	A2.2 ¿En qué fecha finalizó el primer viaje? ___','
	a2_3_1_1	'=>'	País del primer destino visitado en primer viaje','
	a2_3_1_2	'=>'	Departamento del primer destino visitado en primer viaje','
	a2_3_1_3	'=>'	Ciudad del primer destino visitado en primer viaje','
	a2_3_2_1	'=>'	País del segundo destino visitado en primer viaje','
	a2_3_2_2	'=>'	Departamento del segundo destino visitado en primer viaje','
	a2_3_2_3	'=>'	Ciudad del segundo destino visitado en primer viaje','
	a2_3_3_1	'=>'	País del tercer destino visitado en primer viaje','
	a2_3_3_2	'=>'	Departamento del tercer destino visitado en primer viaje','
	a2_3_3_3	'=>'	Ciudad del tercer destino visitado en primer viaje','
	a2_3_4_1	'=>'	País del cuarto destino visitado en primer viaje','
	a2_3_4_2	'=>'	Departamento del cuarto destino visitado en primer viaje','
	a2_3_4_3	'=>'	Ciudad del cuarto destino visitado en primer viaje','
	a2_3_5_1	'=>'	País del quinto destino visitado en primer viaje','
	a2_3_5_2	'=>'	Departamento del quinto destino visitado en primer viaje','
	a2_3_5_3	'=>'	Ciudad del quinto destino visitado en primer viaje','
	a2_4_1	'=>'	País del destino principal del primer viaje','
	a2_4_2	'=>'	Departamento del destino principal del primer viaje','
	a2_4_3	'=>'	Ciudad del destino principal del primer viaje','
	a2_5	'=>'	A2.5 ¿Cuál fue el motivo principal del primer viaje?','
	a2_5_otro	'=>'	Si motivo no esta en el listado, guarda en este campo la respuesta específicada por el encuestado','
	a2_6	'=>'	A2.6 ¿Con que frecuencia realiza este viaje?','
	a2_7	'=>'	A2.7 ¿Cuántas personas incluyéndose usted, realizaron juntos el primer viaje desde la salida hasta el regreso al lugar de residencia? [Si viajó solo ingrese 1] ______','
	a2_8_1	'=>'	1. Viajé solo','
	a2_8_2	'=>'	2. Personas del hogar compartiendo gastos','
	a2_8_2_1	'=>'	A2.8.2 ¿Cuántas personas del hogar? ___','
	a2_8_3	'=>'	3. Personas del hogar sin compartir gastos','
	a2_8_3_1	'=>'	A2.8.3 ¿Cuántas personas del hogar? ___','
	a2_8_4	'=>'	4. Personas que no son del hogar compartiendo gastos','
	a2_8_5	'=>'	5. Personas que no son del hogar sin compartir gastos','
	a2_8_6	'=>'	6. ¿Dentro de las personas que no son del hogar incluía otros turistas, es decir, personas desconocidas o sin ningún vínculo con usted?','
	a2_8_6_1	'=>'	A2.8.6 ¿Cuántos eran otros turistas? ____________','
	a2_8_otro	'=>'	Otro, ¿Cuál?','
	a3_1	'=>'	A3.1 ¿En qué fecha inicio el segundo viaje? ___','
	a3_2	'=>'	A3.2 ¿En qué fecha finalizó el segundo viaje? ___','
	a3_3_1_1	'=>'	País del primer destino visitado en segundo viaje ','
	a3_3_1_2	'=>'	Departamento del primer destino visitado en segundo viaje ','
	a3_3_1_3	'=>'	Ciudad del primer destino visitado en segundo viaje','
	a3_3_2_1	'=>'	País del segundo destino visitado en segundo viaje','
	a3_3_2_2	'=>'	Departamento del segundo destino visitado en segundo viaje','
	a3_3_2_3	'=>'	Ciudad del segundo destino visitado en segundo viaje','
	a3_3_3_1	'=>'	País del tercer destino visitado en segundo viaje','
	a3_3_3_2	'=>'	Departamento del tercer destino visitado en segundo viaje','
	a3_3_3_3	'=>'	Ciudad del tercer destino visitado en segundo viaje','
	a3_3_4_1	'=>'	País del cuarto destino visitado en segundo viaje','
	a3_3_4_2	'=>'	Departamento del cuarto destino visitado en segundo viaje','
	a3_3_4_3	'=>'	Ciudad del cuarto destino visitado en segundo viaje','
	a3_3_5_1	'=>'	País del quinto destino visitado en segundo viaje','
	a3_3_5_2	'=>'	Departamento del quinto destino visitado en segundo viaje','
	a3_3_5_3	'=>'	Ciudad del quinto destino visitado en segundo viaje','
	a3_4_1	'=>'	País del destino principal del segundo viaje','
	a3_4_2	'=>'	Departamento del destino principal del segundo viaje','
	a3_4_3	'=>'	Ciudad del destino principal del segundo viaje','
	a3_5	'=>'	A3.5 ¿Cuál fue el motivo principal del segundo viaje?','
	a3_5_otro	'=>'	Si motivo no esta en el listado, guarda en este campo la respuesta específicada por el encuestado','
	a3_6	'=>'	A3.6 ¿Con que frecuencia realiza este viaje?','
	a3_7	'=>'	A3.7 ¿Cuántas personas incluyéndose usted, realizaron juntos el segundo viaje desde la salida hasta el regreso al lugar de residencia? [Si viajó solo ingrese 1] ______','
	a3_8_1	'=>'	1. Viajé solo','
	a3_8_2	'=>'	2. Personas del hogar compartiendo gastos','
	a3_8_2_1	'=>'	A3.8.2 ¿Cuántas personas del hogar? ___','
	a3_8_3	'=>'	3. Personas del hogar sin compartir gastos','
	a3_8_3_1	'=>'	A3.8.3 ¿Cuántas personas del hogar? ___','
	a3_8_4	'=>'	4. Personas que no son del hogar compartiendo gastos','
	a3_8_5	'=>'	5. Personas que no son del hogar sin compartir gastos','
	a3_8_6	'=>'	6. ¿Dentro de las personas que no son del hogar incluía otros turistas, es decir, personas desconocidas o sin ningún vínculo con usted?','
	a3_8_6_1	'=>'	A3.8.6 ¿Cuántos eran otros turistas? ____________','
	a3_8_otro	'=>'	Otro, ¿Cuál?','
	a4_1	'=>'	A4.1 ¿En qué fecha inicio el tercer viaje? ___','
	a4_2	'=>'	A4.2 ¿En qué fecha finalizó el tercer viaje? ___','
	a4_3_1_1	'=>'	País del primer destino visitado en tercer viaje ','
	a4_3_1_2	'=>'	Departamento del primer destino visitado en tercer viaje ','
	a4_3_1_3	'=>'	Ciudad del primer destino visitado en tercer viaje','
	a4_3_2_1	'=>'	País del segundo destino visitado en tercer viaje','
	a4_3_2_2	'=>'	Departamento del segundo destino visitado en tercer viaje','
	a4_3_2_3	'=>'	Ciudad del segundo destino visitado en tercer viaje','
	a4_3_3_1	'=>'	País del tercer destino visitado en tercer viaje','
	a4_3_3_2	'=>'	Departamento del tercer destino visitado en tercer viaje','
	a4_3_3_3	'=>'	Ciudad del tercer destino visitado en tercer viaje','
	a4_3_4_1	'=>'	País del cuarto destino visitado en tercer viaje','
	a4_3_4_2	'=>'	Departamento del cuarto destino visitado en tercer viaje','
	a4_3_4_3	'=>'	Ciudad del cuarto destino visitado en tercer viaje','
	a4_3_5_1	'=>'	País del quinto destino visitado en tercer viaje','
	a4_3_5_2	'=>'	Departamento del quinto destino visitado en tercer viaje','
	a4_3_5_3	'=>'	Ciudad del quinto destino visitado en tercer viaje','
	a4_4_1	'=>'	País del destino principal del tercer viaje','
	a4_4_2	'=>'	Departamento del destino principal del tercer viaje','
	a4_4_3	'=>'	Ciudad del destino principal del tercer viaje','
	a4_5	'=>'	A4.5 ¿Cuál fue el motivo principal del tercer viaje?','
	a4_5_otro	'=>'	Si motivo no esta en el listado, guarda en este campo la respuesta específicada por el encuestado','
	a4_6	'=>'	A4.6 ¿Con que frecuencia realiza este viaje?','
	a4_7	'=>'	A4.7 ¿Cuántas personas incluyéndose usted, realizaron juntos el tercer viaje desde la salida hasta el regreso al lugar de residencia? [Si viajó solo ingrese 1] ______','
	a4_8_1	'=>'	1. Viajé solo','
	a4_8_2	'=>'	2. Personas del hogar compartiendo gastos','
	a4_8_2_1	'=>'	A4.8.2 ¿Cuántas personas del hogar? ___','
	a4_8_3	'=>'	3. Personas del hogar sin compartir gastos','
	a4_8_3_1	'=>'	A4.8.3 ¿Cuántas personas del hogar? ___','
	a4_8_4	'=>'	4. Personas que no son del hogar compartiendo gastos','
	a4_8_5	'=>'	5. Personas que no son del hogar sin compartir gastos','
	a4_8_6	'=>'	6. ¿Dentro de las personas que no son del hogar incluía otros turistas, es decir, personas desconocidas o sin ningún vínculo con usted?','
	a4_8_6_1	'=>'	A4.8.6 ¿Cuántos eran otros turistas? ____________','
	a4_8_otro	'=>'	Otro, ¿Cuál?','
	a5_1	'=>'	A5.1 ¿En qué fecha inicio el cuarto viaje? ___','
	a5_2	'=>'	A5.2 ¿En qué fecha finalizó el cuarto viaje? ___','
	a5_3_1_1	'=>'	País del primer destino visitado en cuarto viaje ','
	a5_3_1_2	'=>'	Departamento del primer destino visitado en cuarto viaje ','
	a5_3_1_3	'=>'	Ciudad del primer destino visitado en cuarto viaje','
	a5_3_2_1	'=>'	País del segundo destino visitado en cuarto viaje','
	a5_3_2_2	'=>'	Departamento del segundo destino visitado en cuarto viaje','
	a5_3_2_3	'=>'	Ciudad del segundo destino visitado en cuarto viaje','
	a5_3_3_1	'=>'	País del tercer destino visitado en cuarto viaje','
	a5_3_3_2	'=>'	Departamento del tercer destino visitado en cuarto viaje','
	a5_3_3_3	'=>'	Ciudad del tercer destino visitado en cuarto viaje','
	a5_3_4_1	'=>'	País del cuarto destino visitado en cuarto viaje','
	a5_3_4_2	'=>'	Departamento del cuarto destino visitado en cuarto viaje','
	a5_3_4_3	'=>'	Ciudad del cuarto destino visitado en cuarto viaje','
	a5_3_5_1	'=>'	País del quinto destino visitado en cuarto viaje','
	a5_3_5_2	'=>'	Departamento del quinto destino visitado en cuarto viaje','
	a5_3_5_3	'=>'	Ciudad del quinto destino visitado en cuarto viaje','
	a5_4_1	'=>'	País del destino principal del cuarto viaje','
	a5_4_2	'=>'	Departamento del destino principal del cuarto viaje','
	a5_4_3	'=>'	Ciudad del destino principal del cuarto viaje','
	a5_5	'=>'	A5.5 ¿Cuál fue el motivo principal del cuarto viaje?','
	a5_5_otro	'=>'	Si motivo no esta en el listado, guarda en este campo la respuesta específicada por el encuestado','
	a5_6	'=>'	A5.6 ¿Con que frecuencia realiza este viaje?','
	a5_7	'=>'	A5.7 ¿Cuántas personas incluyéndose usted, realizaron juntos el cuarto viaje desde la salida hasta el regreso al lugar de residencia? [Si viajó solo ingrese 1] ______','
	a5_8_1	'=>'	1. Viajé solo','
	a5_8_2	'=>'	2. Personas del hogar compartiendo gastos','
	a5_8_2_1	'=>'	A5.8.2 ¿Cuántas personas del hogar? ___','
	a5_8_3	'=>'	3. Personas del hogar sin compartir gastos','
	a5_8_3_1	'=>'	A5.8.3 ¿Cuántas personas del hogar? ___','
	a5_8_4	'=>'	4. Personas que no son del hogar compartiendo gastos','
	a5_8_5	'=>'	5. Personas que no son del hogar sin compartir gastos','
	a5_8_6	'=>'	6. ¿Dentro de las personas que no son del hogar incluía otros turistas, es decir, personas desconocidas o sin ningún vínculo con usted?','
	a5_8_6_1	'=>'	A5.8.6 ¿Cuántos eran otros turistas? ____________','
	a5_8_otro	'=>'	Otro, ¿Cuál?','
	a6_1	'=>'	A6.1 ¿En qué fecha inicio el quinto viaje? ___','
	a6_2	'=>'	A6.2 ¿En qué fecha finalizó el quinto viaje? ___','
	a6_3_1_1	'=>'	País del primer destino visitado en quinto viaje ','
	a6_3_1_2	'=>'	Departamento del primer destino visitado en quinto viaje ','
	a6_3_1_3	'=>'	Ciudad del primer destino visitado en quinto viaje','
	a6_3_2_1	'=>'	País del segundo destino visitado en quinto viaje','
	a6_3_2_2	'=>'	Departamento del segundo destino visitado en quinto viaje','
	a6_3_2_3	'=>'	Ciudad del segundo destino visitado en quinto viaje','
	a6_3_3_1	'=>'	País del tercer destino visitado en quinto viaje','
	a6_3_3_2	'=>'	Departamento del tercer destino visitado en quinto viaje','
	a6_3_3_3	'=>'	Ciudad del tercer destino visitado en quinto viaje','
	a6_3_4_1	'=>'	País del cuarto destino visitado en quinto viaje','
	a6_3_4_2	'=>'	Departamento del cuarto destino visitado en quinto viaje','
	a6_3_4_3	'=>'	Ciudad del cuarto destino visitado en quinto viaje','
	a6_3_5_1	'=>'	País del quinto destino visitado en quinto viaje','
	a6_3_5_2	'=>'	Departamento del quinto destino visitado en quinto viaje','
	a6_3_5_3	'=>'	Ciudad del quinto destino visitado en quinto viaje','
	a6_4_1	'=>'	País del destino principal del quinto viaje','
	a6_4_2	'=>'	Departamento del destino principal del quinto viaje','
	a6_4_3	'=>'	Ciudad del destino principal del quinto viaje','
	a6_5	'=>'	A6.5 ¿Cuál fue el motivo principal del quinto viaje?','
	a6_5_otro	'=>'	Si motivo no esta en el listado, guarda en este campo la respuesta específicada por el encuestado','
	a6_6	'=>'	A6.6 ¿Con que frecuencia realiza este viaje?','
	a6_7	'=>'	A6.7 ¿Cuántas personas incluyéndose usted, realizaron juntos el quinto viaje desde la salida hasta el regreso al lugar de residencia? [Si viajó solo ingrese 1] ______','
	a6_8_1	'=>'	1. Viajé solo','
	a6_8_2	'=>'	2. Personas del hogar compartiendo gastos','
	a6_8_2_1	'=>'	A6.8.2 ¿Cuántas personas del hogar? ___','
	a6_8_3	'=>'	3. Personas del hogar sin compartir gastos','
	a6_8_3_1	'=>'	A6.8.3 ¿Cuántas personas del hogar? ___','
	a6_8_4	'=>'	4. Personas que no son del hogar compartiendo gastos','
	a6_8_5	'=>'	5. Personas que no son del hogar sin compartir gastos','
	a6_8_6	'=>'	6. ¿Dentro de las personas que no son del hogar incluía otros turistas, es decir, personas desconocidas o sin ningún vínculo con usted?','
	a6_8_6_1	'=>'	A6.8.6 ¿Cuántos eran otros turistas? ____________','
	a6_8_otro	'=>'	Otro, ¿Cuál?','
	viaje_turistico_1	'=>'	Guarda 1  si primer viaje es turístico y 0 si primer viaje no es turístico','
	viaje_turistico_2	'=>'	Guarda 1  si segundo viaje es turístico y 0 si segundo viaje no es turístico','
	viaje_turistico_3	'=>'	Guarda 1  si tercer viaje es turístico y 0 si tercer viaje no es turístico','
	viaje_turistico_4	'=>'	Guarda 1  si cuarto viaje es turístico y 0 si cuarto viaje no es turístico','
	viaje_turistico_5	'=>'	Guarda 1  si quinto viaje es turístico y 0 si quinto viaje no es turístico','
	viaje_aleatorio	'=>'	Guarda 1 o 2 o 3 o 4 o 5 según viaje turístico seleccionado aleatoriamente para realizar las preguntas de la Parte B en adelante','
	ahora_vamos_hablar	'=>'	Guarda el nombre de las ciudades destino visitadas según viaje turístico seleccionado aleatoriamente','
	b11	'=>'	B1. ¿Cuántas noches pasó durante el viaje? [_Si es 0 seleccione cero] ___','
	b2_1	'=>'	B2.1 ¿Cuántas noches pasó en "Primer destino"? [_Si es 0 ingrese cero] ____','
	b2_1_11	'=>'	B2.1.1 ¿Tipo de alojamiento utilizado?','
	b2_1_1_otro	'=>'	Si no esta en el listado el tipo de alojamiento, guarda el específicado por el encuestado','
	b2_2	'=>'	B2.2 ¿Cuántas noches pasó en "Segundo destino"? [_Si es 0 ingrese cero] ____','
	b2_2_1	'=>'	B2.2.1 ¿Tipo de alojamiento utilizado?','
	b2_2_1_otro	'=>'	Si no esta en el listado el tipo de alojamiento, guarda el específicado por el encuestado','
	b2_3	'=>'	B2.3 ¿Cuántas noches pasó en "Tercer destino"? [_Si es 0 ingrese cero] ____','
	b2_3_1	'=>'	B2.3.1 ¿Tipo de alojamiento utilizado?','
	b2_3_1_otro	'=>'	Si no esta en el listado el tipo de alojamiento, guarda el específicado por el encuestado','
	b2_4	'=>'	B2.4 ¿Cuántas noches pasó en "Cuarto destino"? [_Si es 0 ingrese cero] ____','
	b2_4_1	'=>'	B2.4.1 ¿Tipo de alojamiento utilizado?','
	b2_4_1_otro	'=>'	Si no esta en el listado el tipo de alojamiento, guarda el específicado por el encuestado','
	b2_5	'=>'	B2.5 ¿Cuántas noches pasó en "Quinto destino"? [_Si es 0 ingrese cero] ____','
	b2_5_1	'=>'	B2.5.1 ¿Tipo de alojamiento utilizado?','
	b2_5_1_otro	'=>'	Si no esta en el listado el tipo de alojamiento, guarda el específicado por el encuestado','
	b3_1	'=>'	1. Asistencia a espectáculos artísticos (Sin festivales)','
	b3_2	'=>'	2. Asistencia a festivales artísticos ','
	b3_3	'=>'	3. Asistencia a fiestas y ferias','
	b3_4	'=>'	4. Visita a museos/casas de la cultura/ iglesias','
	b3_5	'=>'	5. Visita a parques temáticos/parque de atracciones ','
	b3_6	'=>'	6. Visita a parques y sitios naturales','
	b3_7	'=>'	7. Recorrer las calles y parques del casco urbano ','
	b3_8	'=>'	8. Visita temáticas en haciendas o fábricas','
	b3_9	'=>'	9. Visita a casinos/juegos de azar','
	b3_10	'=>'	10. Práctica de deportes ','
	b3_11	'=>'	11. Asistencia a competencias deportivas ','
	b3_12	'=>'	12. Visita a sitios nocturnos','
	b3_13	'=>'	13. Visita a centros comerciales ','
	b3_14	'=>'	14. Compras por fuera de centros comerciales','
	b3_15	'=>'	15. Actividades religiosas ','
	b3_16	'=>'	16. Realizar inversiones/Reuniones de negocios','
	b3_17	'=>'	17. Asistir a conferencias/Congresos/ferias comerciales','
	b3_18	'=>'	18. Ninguna','
	b3_otras_cuales_1	'=>'	Códigos de reserva','
	b3_otras_cuales_2	'=>'	19. Visita a familiares','
	b3_otras_cuales_3	'=>'	20. Reunión familiar/amigos','
	b3_otras_cuales_4	'=>'	21. Visita a Clubes recreacionales','
	b3_otras_cuales_5	'=>'	22. Hacer diligencias personales','
	b3_4_1_1	'=>'	1. Catedrales, iglesias ','
	b3_4_1_2	'=>'	2. Casas de la cultura  ','
	b3_4_1_3	'=>'	3. Museos de arte','
	b3_4_1_4	'=>'	4. Museos arqueológicos ','
	b3_4_1_5	'=>'	5. Haciendas y/o casas históricas','
	b3_4_1_6	'=>'	6. Puentes históricos ','
	b3_4_1_7	'=>'	7. Monumentos  ','
	b3_4_1_8	'=>'	8. Cementerios ','
	b3_4_1_9	'=>'	9. Santuarios ','
	b3_4_1_otros_cuales_1	'=>'	Códigos de reserva','
	b3_4_1_otros_cuales_2	'=>'	10 Museo del petróleo','
	b3_4_1_otros_cuales_3	'=>'	11','
	b3_4_1_otros_cuales_4	'=>'	12','
	b3_4_1_otros_cuales_5	'=>'	13','
	b3_5_1_1	'=>'	1. Parque Nacional del Chicamocha  ','
	b3_5_1_2	'=>'	2. Acuaparque Nacional del Chicamocha','
	b3_5_1_3	'=>'	3. Neomundo ','
	b3_5_1_4	'=>'	4. Parque del Agua ','
	b3_5_1_5	'=>'	5. Ecoparque Cerro del Santísimo ','
	b3_5_1_6	'=>'	6. Acualago','
	b3_5_1_7	'=>'	7. Ninguno de los anteriores','
	b3_6_1_1	'=>'	1. Parque Gallineral','
	b3_6_1_2	'=>'	2. Reservas/Parques naturales ','
	b3_6_1_3	'=>'	3. Miradores paisajísticos','
	b3_6_1_4	'=>'	4. Cascadas ','
	b3_6_1_5	'=>'	5. Ríos, pozos, balnearios ','
	b3_6_1_6	'=>'	6. Zoológicos ','
	b3_6_1_7	'=>'	7. Jardines botánicos ','
	b3_6_1_8	'=>'	8. Cuevas','
	b3_6_1_otros_cuales_1	'=>'	Códigos de reserva','
	b3_6_1_otros_cuales_2	'=>'	9','
	b3_6_1_otros_cuales_3	'=>'	10','
	b3_6_1_otros_cuales_4	'=>'	11','
	b3_6_1_otros_cuales_5	'=>'	12','
	b3_8_1_1	'=>'	1. Proceso del café ','
	b3_8_1_2	'=>'	2. Proceso de la panela','
	b3_8_1_3	'=>'	3. Proceso del dulce','
	b3_8_1_otros_cuales_1	'=>'	Códigos de reserva','
	b3_8_1_otros_cuales_2	'=>'	4 Proceso aceite de Palma','
	b3_8_1_otros_cuales_3	'=>'	5 Proceso del cacao','
	b3_8_1_otros_cuales_4	'=>'	6','
	b3_8_1_otros_cuales_5	'=>'	7','
	b3_10_1_1	'=>'	1. Rafting (Canotaje) ','
	b3_10_1_2	'=>'	2. Espelelismo (Exploración recreativa de cuevas)  ','
	b3_10_1_3	'=>'	3. Rappel en cascadas','
	b3_10_1_4	'=>'	4. Parapente ','
	b3_10_1_5	'=>'	5. Senderismo (Caminatas) ','
	b3_10_1_6	'=>'	6. Escalada en roca ','
	b3_10_1_7	'=>'	7. Bungee Jumping ','
	b3_10_1_otros_cuales_1	'=>'	Códigos de reserva','
	b3_10_1_otros_cuales_2	'=>'	8. Ciclismo','
	b3_10_1_otros_cuales_3	'=>'	9. Fútbol','
	b3_10_1_otros_cuales_4	'=>'	10','
	b3_10_1_otros_cuales_5	'=>'	11','
	c11	'=>'	C1. ¿Cuál fue el medio transporte utilizado para recorrer la mayor distancia durante el viaje?','
	c1_otro	'=>'	Si no esta en el listado el medio utilizado, guarda el específicado por el encuestado','
	d11	'=>'	D1. ¿El viaje hizo parte de un paquete/plan turístico o excursión?','
	d21	'=>'	D2. ¿Cuánto usted pagó por el paquete turístico o excursión?','
	d2_1	'=>'	D2.1 ¿Pagó con que tipo de moneda?: ___','
	d31	'=>'	D3. ¿A cuántas personas cubrió? _______ personas','
	d41	'=>'	D4. El paquete/plan turístico o excursión fue comprado a:','
	d4_1	'=>'	D4.1 En donde está ubicada la agencia de viajes/operador turístico:','
	d5_1	'=>'	1. Transporte aéreo internacional (Incluye ida-vuelta)','
	d5_2	'=>'	2. Transporte acuático internacional (Incluye ida-vuelta)','
	d5_3	'=>'	3. Transporte terrestre internacional (Incluye ida-vuelta)','
	d5_4	'=>'	4. Transporte aéreo nacional ','
	d5_5	'=>'	5. Transporte terrestre de pasajeros nacional','
	d5_6	'=>'	6. Transporte terrestre de pasajeros para movilizarse dentro de Santander','
	d5_7	'=>'	9. Alojamiento','
	d5_8	'=>'	10. Alimento y bebidas','
	d5_9	'=>'	11. Actividades recreativas, culturales y deportivas','
	d5_10	'=>'	15. Asistencia a conferencias, seminarios, congresos, ferias comerciales y exposiciones','
	d5_11	'=>'	16. Cursos/talleres de enseñanza','
	d5_otro_1	'=>'	Códigos de reserva para otro servicios','
	d5_otro_2	'=>'	19. Pasaporte','
	d5_otro_3	'=>'	20. Productos de belleza','
	d5_otro_4	'=>'	21. Traslado al aeropuerto hotel','
	d5_otro_5	'=>'	21. Alimentos llevar a casa','
	d6_1	'=>'	1. Dentro de Santander (%): ___','
	d6_2	'=>'	2. Fuera de Santander (%): ___','
	d7_1	'=>'	1. Dentro de Santander (%): ___','
	d7_2	'=>'	2. Fuera de Santander (%): ___','
	d8_1	'=>'	1. Dentro de Santander (%): ___','
	d8_2	'=>'	2. Fuera de Santander (%): ___','
	d9_99	'=>'	99. No realicé ningún tipo de gasto','
	d9_1	'=>'	1. Transporte aéreo internacional (Incluye ida-vuelta)','
	d9_1_1	'=>'	¿Cuánto gasto?','
	d9_1_1_1	'=>'	Tipo de Moneda:__','
	d9_2_1	'=>'	¿A cuántas personas cubrió?','
	d9_2	'=>'	2. Transporte acuático internacional (Incluye ida-vuelta)','
	d9_1_2	'=>'	¿Cuánto gasto?','
	d9_1_2_1	'=>'	Tipo de Moneda:__','
	d9_2_2	'=>'	¿A cuántas personas cubrió?','
	d9_3	'=>'	3. Transporte terrestre internacional (Incluye ida-vuelta)','
	d9_1_3	'=>'	¿Cuánto gasto?','
	d9_1_3_1	'=>'	Tipo de Moneda:__','
	d9_2_3	'=>'	¿A cuántas personas cubrió?','
	d9_4	'=>'	4. Transporte aéreo nacional','
	d9_1_4	'=>'	¿Cuánto gasto?','
	d9_2_4	'=>'	¿A cuántas personas cubrió?','
	d9_5	'=>'	5. Transporte terrestre de pasajeros nacional','
	d9_1_5	'=>'	¿Cuánto gasto?','
	d9_2_5	'=>'	¿A cuántas personas cubrió?','
	d9_6	'=>'	6. Transporte terrestre de pasajeros para movilizarse dentro de Santander.','
	d9_1_6	'=>'	¿Cuánto gasto?','
	d9_2_6	'=>'	¿A cuántas personas cubrió?','
	d9_7	'=>'	7. Alquiler de vehículo','
	d9_1_7	'=>'	¿Cuánto gasto?','
	d9_1_7_1	'=>'	Tipo de Moneda:__','
	d9_2_7	'=>'	¿A cuántas personas cubrió?','
	d9_8	'=>'	8. Combustible','
	d9_1_8	'=>'	¿Cuánto gasto?','
	d9_1_8_1	'=>'	Tipo de Moneda:__','
	d9_2_8	'=>'	¿A cuántas personas cubrió?','
	d9_9	'=>'	9. Alojamiento','
	d9_1_9	'=>'	¿Cuánto gasto?','
	d9_1_9_1	'=>'	Tipo de Moneda:__','
	d9_2_9	'=>'	¿A cuántas personas cubrió?','
	d9_10	'=>'	10. Alimento y bebidas','
	d9_1_10	'=>'	¿Cuánto gasto?','
	d9_1_10_1	'=>'	Tipo de Moneda:__','
	d9_2_10	'=>'	¿A cuántas personas cubrió?','
	d9_11	'=>'	11. Actividades recreativas, culturales y deportivas','
	d9_1_11	'=>'	¿Cuánto gasto?','
	d9_1_11_1	'=>'	Tipo de Moneda:__','
	d9_2_11	'=>'	¿A cuántas personas cubrió?','
	d9_12	'=>'	12. Artesanías (incluye ropa y/o calzado artesanal), recuerdos','
	d9_1_12	'=>'	¿Cuánto gasto?','
	d9_1_12_1	'=>'	Tipo de Moneda:__','
	d9_2_12	'=>'	¿A cuántas personas cubrió?','
	d9_13	'=>'	13. Objetos valiosos (Joyas, obras de arte)','
	d9_1_13	'=>'	¿Cuánto gasto?','
	d9_1_13_1	'=>'	Tipo de Moneda:__','
	d9_2_13	'=>'	¿A cuántas personas cubrió?','
	d9_14	'=>'	14. Bienes de consumo duradero (Ropa, calzado, artículos electrónicos ,etc)','
	d9_1_14	'=>'	¿Cuánto gasto?','
	d9_1_14_1	'=>'	Tipo de Moneda:__','
	d9_2_14	'=>'	¿A cuántas personas cubrió?','
	d9_15	'=>'	15. Asistencia a conferencias, seminarios, congresos, ferias comerciales y exposiciones','
	d9_1_15	'=>'	¿Cuánto gasto?','
	d9_1_15_1	'=>'	Tipo de Moneda:__','
	d9_2_15	'=>'	¿A cuántas personas cubrió?','
	d9_16	'=>'	16. Cursos/talleres de enseñanza','
	d9_1_16	'=>'	¿Cuánto gasto?','
	d9_1_16_1	'=>'	Tipo de Moneda:__','
	d9_2_16	'=>'	¿A cuántas personas cubrió?','
	d9_17	'=>'	17. Servicios médicos (Incluye la cirugía estética)','
	d9_1_17	'=>'	¿Cuánto gasto?','
	d9_1_17_1	'=>'	Tipo de Moneda:__','
	d9_2_17	'=>'	¿A cuántas personas cubrió?','
	d9_18	'=>'	18. Otros gastos, ¿Cuáles? ________','
	d9_otros_1	'=>'	Códigos de reserva','
	d9_otros_2	'=>'	19. Pasaporte','
	d9_otros_3	'=>'	20. Productos de belleza','
	d9_otros_4	'=>'	21. Traslado al aeropuerto hotel','
	d9_otros_5	'=>'	21. Alimentos llevar a casa','
	d9_1_18	'=>'	¿Cuánto gasto?','
	d9_2_18	'=>'	¿A cuántas personas cubrió?','
	d10_99	'=>'	99. Esa situación no se presentó durante el viaje','
	d10_1	'=>'	1. Transporte aéreo internacional (Incluye ida-vuelta)','
	d10_2	'=>'	2. Transporte acuático internacional (Incluye ida-vuelta)','
	d10_3	'=>'	3. Transporte terrestre internacional (Incluye ida-vuelta)','
	d10_4	'=>'	4. Transporte aéreo nacional','
	d10_5	'=>'	5. Transporte terrestre de pasajeros nacional','
	d10_6	'=>'	6. Transporte terrestre de pasajeros para movilizarse dentro de Santander.','
	d10_7	'=>'	7. Alquiler de vehículo','
	d10_8	'=>'	8. Combustible','
	d10_9	'=>'	9. Alojamiento','
	d10_10	'=>'	10. Alimento y bebidas','
	d10_11	'=>'	11. Actividades recreativas, culturales y deportivas','
	d10_12	'=>'	12. Artesanías (incluye ropa y/o calzado artesanal), recuerdos','
	d10_13	'=>'	13. Objetos valiosos (Joyas, obras de arte)','
	d10_14	'=>'	14. Bienes de consumo duradero (Ropa, calzado, artículos electrónicos ,etc)','
	d10_15	'=>'	15. Asistencia a conferencias, seminarios, congresos, ferias comerciales y exposiciones','
	d10_16	'=>'	16. Cursos/talleres de enseñanza','
	d10_17	'=>'	17. Servicios médicos (Incluye la cirugía estética)','
	d10_otros_1	'=>'	Códigos de reserva','
	d10_otros_2	'=>'	19. Pasaporte','
	d10_otros_3	'=>'	20. Productos de belleza','
	d10_otros_4	'=>'	21. Traslado al aeropuerto hotel','
	d10_otros_5	'=>'	21. Alimentos llevar a casa','
	d111	'=>'	D11. ¿Cuál es el nombre de la empresa de transporte terrestre nacional?: ___________','
	d12	'=>'	D12. El alquiler de vehículo fue realizado en: 1.(__) En Santander 2.(__) Fuera de Santander','
	d13_1	'=>'	1. Dentro de Santander (%): ___','
	d13_2	'=>'	2. Fuera de Santander (%): ___','
	d14_1	'=>'	1. Dentro de Santander (%): ___','
	d14_2	'=>'	2. Fuera de Santander (%): ___','
	d15_1	'=>'	1. Dentro de Santander (%): ___','
	d15_2	'=>'	2. Fuera de Santander (%): ___','
	d16_1	'=>'	1. Dentro de Santander (%): ___','
	d16_2	'=>'	2. Fuera de Santander (%): ___','
	d17_1	'=>'	1. Dentro de Santander (%): ___','
	d17_2	'=>'	2. Fuera de Santander (%): ___','
	d18_1	'=>'	1. Dentro de Santander (%): ___','
	d18_2	'=>'	2. Fuera de Santander (%): ___','
	d19_1	'=>'	1. Dentro de Santander (%): ___','
	d19_2	'=>'	2. Fuera de Santander (%): ___','
	d20_1	'=>'	1. Por mi','
	d20_2	'=>'	2. Por mi pareja/Novia(o)/Esposa(o)','
	d20_3	'=>'	3. Cada uno asumió sus gastos','
	d20_4	'=>'	4. Se sumaron todos los gastos y se dividió por partes iguales','
	d20_5	'=>'	5. Por otro(s) familiares(s)/Amigos(s)','
	d20_6	'=>'	6. Cada familia pagó lo que le correspondió','
	d20_7	'=>'	7. Por todos pero no se dividió en partes iguales','
	d20_8	'=>'	8. Totalmente por la empresa en la que trabajo o trabaja un integrante del grupo','
	d20_9	'=>'	9. Una parte fue pagada por la empresa en la que trabajo o trabaja un integrante del grupo','
	d20_10	'=>'	10. Una entidad que no es la empresa en la que trabajo o trabaja un integrante del grupo','
	d20_otro_1	'=>'	11. Familiar que no realizó viaje','
	d20_otro_2	'=>'	','
	d20_otro_3	'=>'	','
	d20_otro_4	'=>'	','
	d20_otro_5	'=>'	','
	e1_1	'=>'	1. Ya los conocía','
	e1_2	'=>'	2. Amigos y/o familiares','
	e1_3	'=>'	3. Búsquedas en internet','
	e1_4	'=>'	4. Medios de comunicación masiva (prensa, radio, televisión.)','
	e1_5	'=>'	5. El Portal VisitaSantander','
	e1_6	'=>'	6. Agencia de viajes','
	e1_7	'=>'	7. Guía turística impresa','
	e1_8	'=>'	8. Twitter','
	e1_9	'=>'	9. Facebook','
	e1_10	'=>'	10. Otras redes sociales','
	e1_11	'=>'	11. Correo electrónico','
	e1_12	'=>'	12. Avisos en internet','
	e1_13	'=>'	13. Blog','
	e1_otro_1	'=>'	Códigos de reserva','
	e1_otro_2	'=>'	14. Información académica de la Universidad','
	e1_otro_3	'=>'	15. Por reunión de negocio/congreso/convenciones','
	e1_otro_4	'=>'	16. Nací allí','
	e1_otro_5	'=>'	17. Mapa físico','
	e2_1	'=>'	1. Familiares','
	e2_2	'=>'	2. Hotel','
	e2_3	'=>'	3. Otros turistas','
	e2_4	'=>'	4. Busqué en internet','
	e2_5	'=>'	5. Redes sociales','
	e2_6	'=>'	6. Blog','
	e2_7	'=>'	7. Amigos','
	e2_8	'=>'	8. Visité el Portal VisitaSantander','
	e2_9	'=>'	9. Guías de turismo (persona)','
	e2_10	'=>'	10. Agencias de viajes o agencias operadoras','
	e2_11	'=>'	11. Habitantes de los municipios visitados','
	e2_12	'=>'	12. Guías de turismo impresas, revistas','
	e2_13	'=>'	13. Conductores de servicio público (De taxi, bus, buseta)','
	e2_14	'=>'	14.No busqué más información','
	e2_otro_1	'=>'	Códigos de reserva','
	e2_otro_2	'=>'	15. Policía','
	e2_otro_3	'=>'	16. En lugares turísticos','
	e2_otro_4	'=>'	17','
	e2_otro_5	'=>'	18','
	e3_1	'=>'	1. No compartí en redes sociales','
	e3_2	'=>'	2. FacebooK','
	e3_3	'=>'	3. Twitter ','
	e3_4	'=>'	4. Linkedin','
	e3_5	'=>'	5. Pinterest ','
	e3_6	'=>'	6. TripAdvisor ','
	e3_7	'=>'	7. Google+ ','
	e3_8	'=>'	8. Youtube ','
	e3_9	'=>'	9. Flickr ','
	e3_10	'=>'	10. Mensajería ( Skype, Whatsapp, messenger)','
	e3_11	'=>'	11. Instagram','
	e3_otro_1	'=>'	Códigos de reserva','
	e3_otro_2	'=>'	12','
	e3_otro_3	'=>'	13','
	e3_otro_4	'=>'	14','
	e3_otro_5	'=>'	15','
	e4	'=>'	E4. ¿Le gustaría que le enviáramos información sobre Santander a su correo electrónico?','
	e5	'=>'	E5. ¿Le gustaría que le enviáramos una invitación por redes sociales para seguir a Santander?','
	e5_1_1	'=>'	1.1 ¿Cómo podemos buscarlo en Facebook?','
	e5_1_2	'=>'	1.2 ¿Cómo podemos buscarlo en Twitter?','
	jefe_hogar	'=>'	'
        	
        	
]);
        
        try{
        
               \Excel::create('ExportacionInterno', function($excel) use($datos) {
        
                    $excel->sheet('Turismo interno', function($sheet) use($datos) {
                       
                
                        $sheet->fromArray($datos, null, 'A1', false, true);
                
                    });
                
                })->store('xlsx', public_path('excel/exports'));
                
                
                
                $exportacion->estado=2;
                $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
                $exportacion->save();
                
                return '/excel/exports/ExportacionInterno.xlsx'; 
        
        
        }catch(Exception $e){
            
            
            $exportacion=$e;
            $exportacion->estado=3;
            $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
            $exportacion->save();
            
        }
        
    }
    
    protected function ExportacionSostenibilidadpst($fecha_inicial,$fecha_final){
        
        $exportacion=new Exportacion();
        $exportacion->nombre="Exportacion Sostenibilidad PST";
        $exportacion->fecha_realizacion=\Carbon\Carbon::now();
        $exportacion->fecha_inicio=$fecha_inicial;
        $exportacion->fecha_fin=$fecha_final;
        $exportacion->estado=1;
        $exportacion->usuario_realizado=$this->user->username;
        $exportacion->hora_comienzo=\Carbon\Carbon::now()->format('h:i:s');
        $exportacion->save();
        
        $datos = \DB::select("SELECT *from exportacionsostenibilidadpst(?,?)", array($fecha_inicial ,$fecha_final));
        $array= json_decode( json_encode($datos), true);
        $datos=$array;
        array_unshift ($datos,[
                                'nombre_establecimiento'=>'NOMBRE DEL ESTABLECIMIENTO',
                                'codigo_encuesta'=>'CE',
                                'numero_rnt'=>'RNT',
                                'fecha'=>'FECHA',
                                'hora'=>'HORA',
                                'am_pm'=>'AM_PM',
                                'direccion'=>'DIRECCIÓN',
                                'nombre_contacto'=>'NOMBRE DEL CONTACTO',
                                'cargo'=>'CARGO',
                                'pst'=>'PST',
                                'celular'=>'CELULAR',
                                'email'=>'E-MAIL',
                                'telefono'=>'TELEFONO FIJO',
                                'lugar_encuesta'=>'LUGAR DE LA ENCUESTA',
                                'p1'=>'P.1',
                                'p2'=>'P.2',
                                'p3'=>'P.3',
                                'p3_1'=>'P.3.1',
                                'p4_a'=>'P.4.a',
                                'p4_b'=>'P.4.b',
                                'p4_c'=>'P.4.c',
                                'p4_d'=>'P.4.d',
                                'p4_e'=>'P.4.e',
                                'p4_f'=>'P.4.f',
                                'p4_g'=>'P.4.g',
                                'p4_h'=>'P.4.h',
                                'p5'=>'P.5',
                                'p6'=>'P.6',
                                'p6_1_a'=>'P.6.1.a',
                                'p6_1_b'=>'P.6.1.b',
                                'p6_1_c'=>'P.6.1.c',
                                'p6_1_d'=>'P.6.1.d',
                                'p6_1_e'=>'P.6.1.e',
                                'p6_1_f'=>'P.6.1.f',
                                'p6_1_g'=>'P.6.1.g',
                                'p6_1_h'=>'P.6.1.h',
                                'p6_1_i'=>'P.6.1.i',
                                'p6_2'=>'P.6.2',
                                'p6_3'=>'P.6.3',
                                'p7'=>'P.7',
                                'p7_1'=>'P.7.1',
                                'p7_2_a'=>'P.7.2.a',
                                'p7_2_b'=>'P.7.2.b',
                                'p7_2_c'=>'P.7.2.c',
                                'p7_2_d'=>'P.7.2.d',
                                'p7_2_e'=>'P.7.2.e',
                                'p7_2_f'=>'P.7.2.f',
                                'p8_a'=>'P.8.a',
                                'p8_b'=>'P.8.b',
                                'p8_c'=>'P.8.c',
                                'p8_d'=>'P.8.d',
                                'p8_e'=>'P.8.e',
                                'p8_f'=>'P.8.f',
                                'p8_g'=>'P.8.g',
                                'p8_h'=>'P.8.h',
                                'p8_1_a'=>'P.8.1.a',
                                'p8_1_b'=>'P.8.1.b',
                                'p8_1_c'=>'P.8.1.c',
                                'p8_1_d'=>'P.8.1.d',
                                'p8_1_e'=>'P.8.1.e',
                                'p8_1_f'=>'P.8.1.f',
                                'p8_1_g'=>'P.8.1.g',
                                'p8_2'=>'P.8.2',
                                'p8_2_1'=>'P.8.2.1',
                                'p9_a'=>'P.9.a',
                                'p9_b'=>'P.9.b',
                                'p9_c'=>'P.9.c',
                                'p9_d'=>'P.9.d',
                                'p9_e'=>'P.9.e',
                                'p9_f'=>'P.9.f',
                                'p9_g'=>'P.9.g',
                                'p9_h'=>'P.9.h',
                                'p10'=>'P.10',
                                'p11'=>'P.11',
                                'p12'=>'P.12',
                                'p12_1'=>'P.12.1',
                                'p13_a'=>'P.13.a',
                                'p13_b'=>'P.13.b',
                                'p13_c'=>'P.13.c',
                                'p13_d'=>'P.13.d',
                                'p13_e'=>'P.13.e',
                                'p13_f'=>'P.13.f',
                                'p13_g'=>'P.13.g',
                                'p14_a'=>'P.14.a',
                                'p14_b'=>'P.14.b',
                                'p14_c'=>'P.14.c',
                                'p14_d'=>'P.14.d',
                                'p14_e'=>'P.14.e',
                                'p14_f'=>'P.14.f',
                                'p14_g'=>'P.14.g',
                                'p14_h'=>'P.14.h',
                                'p15_a'=>'P.15.a',
                                'p15_b'=>'P.15.b',
                                'p15_c'=>'P.15.c',
                                'p15_d'=>'P.15.d',
                                'p15_e'=>'P.15.e',
                                'p15_f'=>'P.15.f',
                                'p15_g'=>'P.15.g',
                                'p15_h'=>'P.15.h',
                                'p15_i'=>'P.15.i',
                                'p15_j'=>'P.15.j',
                                'p15_k'=>'P.15.k',
                                'p15_l'=>'P.15.l',
                                'p15_m'=>'P.15.m',
                                'p16_a'=>'P.16.a',
                                'p16_b'=>'P.16.b',
                                'p16_c'=>'P.16.c',
                                'p16_d'=>'P.16.d',
                                'p16_e'=>'P.16.e',
                                'p16_f'=>'P.16.f',
                                'p16_g'=>'P.16.g',
                                'p16_h'=>'P.16.h',
                                'p16_i'=>'i',
                                'p17'=>'P.17',
                                'p17_1'=>'P.17.1',
                                'p17_2'=>'P.17.2',
                                'p18_a'=>'P.18.a',
                                'p18_b'=>'P.18.b',
                                'p18_c'=>'P.18.c',
                                'p18_d'=>'P.18.d',
                                'p18_e'=>'P.18.e',
                                'p18_f'=>'P.18.f',
                                'p18_g'=>'P.18.g',
                                'p18_h'=>'P.18.h',
                                'p19_a'=>'P.19.a',
                                'p19_b'=>'P.19.b',
                                'p19_c'=>'P.19.c',
                                'p19_d'=>'P.19.d',
                                'p19_e'=>'P.19.e',
                                'p19_f'=>'P.19.f',
                                'p19_g'=>'P.19.g',
                                'p20'=>'P.20',
                                'p20_1_1'=>'P.20.1.1',
                                'p20_1_2'=>'P.20.1.2',
                                'p21_a'=>'P.21.a',
                                'p21_b'=>'P.21.b',
                                'p21_c'=>'P.21.c',
                                'p21_d'=>'P.21.d',
                                'p21_e'=>'P.21.e',
                                'p21_f'=>'P.21.f',
                                'p21_g'=>'P.21.g',
                                'p21_h'=>'P.21.h',
                                'p22'=>'P.22',
                                'p22_1'=>'P.22.1',
                                'p22_2_1'=>'P.22.2.1',
                                'p22_2_2'=>'P.22.2.2',
                                'p22_2_3'=>'P.22.2.3',
                                'p22_2_4'=>'P.22.2.4',
                                'p23'=>'P.23',
                                'p24'=>'P.24',
                                'p24_1_a'=>'P.24.1.a',
                                'p24_1_b'=>'P.24.1.b',
                                'p24_1_c'=>'P.24.1.c',
                                'p24_1_d'=>'P.24.1.d',
                                'p24_1_e'=>'P.24.1.e',
                                'p24_1_f'=>'P.24.1.f',
                                'p24_1_g'=>'P.24.1.g',
                                'p24_1_h'=>'P.24.1.h',
                                'p24_1_i'=>'P.24.1.i',
                                'p24_1_j'=>'P.24.1.j',
                                'p24_1_k'=>'P.24.1.k',
                                'p24_1_l'=>'P.24.1.l',
                                'p24_1_m'=>'P.24.1.m',
                                'p24_1_n'=>'P.24.1.n',
                                'p24_2_a'=>'P.24.2.a',
                                'p24_2_b'=>'P.24.2.b',
                                'p24_2_c'=>'P.24.2.c',
                                'p24_2_d'=>'P.24.2.d',
                                'p24_2_e'=>'P.24.2.e',
                                'p24_2_f'=>'P.24.2.f',
                                'p24_2_g'=>'P.24.2.g',
                                'p24_2_h'=>'P.24.2.h',
                                'p24_2_i'=>'P.24.2.i',
                                'p25'=>'P.25',
                                'p26_a_a'=>'P.26.a.a',
                                'p26_b_a'=>'P.26.b.a',
                                'p26_c_a'=>'P.26.c.a',
                                'p26_d_a'=>'P.26.d.a',
                                'p26_e_a'=>'P.26.e.a',
                                'p26_f_a'=>'P.26.f.a',
                                'p26_g_a'=>'P.26.g.a',
                                'p26_h_a'=>'P.26.h.a',
                                'p26_a_b'=>'P.26.a.b',
                                'p26_b_b'=>'P.26.b.b',
                                'p26_c_b'=>'P.26.c.b',
                                'p26_d_b'=>'P.26.d.b',
                                'p26_e_b'=>'P.26.e.b',
                                'p26_f_b'=>'P.26.f.b',
                                'p26_g_b'=>'P.26.g.b',
                                'p26_h_b'=>'P.26.h.b',
                                'p27_a'=>'P.27.a',
                                'p27_b'=>'P.27.b',
                                'p27_c'=>'P.27.c',
                                'p27_d'=>'P.27.d',
                                'p27_e'=>'P.27.e',
                                'p27_f'=>'P.27.f',
                                'p27_g'=>'P.27.g',
                                'p27_h'=>'P.27.h',
                                'p27_i'=>'P.27.i',
                                'p27_j'=>'P.27.j',
                                'p27_k'=>'P.27.k',
                                'p27_l'=>'P.27.l',
                                'p28'=>'P.28',
                                'p29'=>'P.29',
                                'p30'=>'P.30'
 
                ]);
        
        try{
        
               \Excel::create('ExportacionSostenibilidadPst', function($excel) use($datos) {
        
                    $excel->sheet('Sostenibilidad pst', function($sheet) use($datos) {
                       
                
                        $sheet->fromArray($datos, null, 'A1', false, true);
                
                    });
                
                })->store('xlsx', public_path('excel/exports'));
                
                
                
                $exportacion->estado=2;
                $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
                $exportacion->save();
                
                return '/excel/exports/ExportacionSostenibilidadPst.xlsx'; 
        
        
        }catch(Exception $e){
            
            
            $exportacion=$e;
            $exportacion->estado=3;
            $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
            $exportacion->save();
            
        }
        
    }
    
    protected function ExportacionSostenibilidadhogares($fecha_inicial,$fecha_final){
        
        $exportacion=new Exportacion();
        $exportacion->nombre="Exportacion Sostenibilidad Hogares";
        $exportacion->fecha_realizacion=\Carbon\Carbon::now();
        $exportacion->fecha_inicio=$fecha_inicial;
        $exportacion->fecha_fin=$fecha_final;
        $exportacion->estado=1;
        $exportacion->usuario_realizado=$this->user->username;
        $exportacion->hora_comienzo=\Carbon\Carbon::now()->format('h:i:s');
        $exportacion->save();
        
        $datos = \DB::select("SELECT *from exportacionsostenibilidadhogares(?,?)", array($fecha_inicial ,$fecha_final));
        $array= json_decode( json_encode($datos), true);
        $datos=$array;
        
        try{
        
               \Excel::create('ExportacionSostenibilidadhogares', function($excel) use($datos) {
        
                    $excel->sheet('Sostenibilidad hogares ', function($sheet) use($datos) {
                       
                
                        $sheet->fromArray($datos, null, 'A1', false, true);
                
                    });
                
                })->store('xlsx', public_path('excel/exports'));
                
                
                
                $exportacion->estado=2;
                $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
                $exportacion->save();
                
                return '/excel/exports/ExportacionSostenibilidadhogares.xlsx'; 
        
        
        }catch(Exception $e){
            
            
            $exportacion=$e;
            $exportacion->estado=3;
            $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
            $exportacion->save();
            
        }
        
    }
    
    protected function ExportacionOfertayEmpleo($tipo,$mes){
        
        $exportacion=new Exportacion();
        $exportacion->nombre="Exportacion oferta y empleo";
        $exportacion->fecha_realizacion=\Carbon\Carbon::now();
        $exportacion->estado=1;
        $exportacion->usuario_realizado=$this->user->username;
        $exportacion->hora_comienzo=\Carbon\Carbon::now()->format('h:i:s');
        $exportacion->save();
        
        switch($tipo){
            
            case 1:
                 $datos = \DB::select("SELECT *from AgenciaViajes(?)", array($mes));
                 $nombre="AgenciaViajes";
                break;
            case 2:
                 $datos = \DB::select("SELECT *from AgenciaOperadoras(?)", array($mes));
                 $nombre="AgenciaOperadoras";
                break;
            case 3:
                 $datos = \DB::select("SELECT *from Alojamiento(?)", array($mes));
                 $nombre="Alojamiento";
                break;
            case 4:
                 $datos = \DB::select("SELECT *from Restaurantes(?)", array($mes));
                 $nombre="Restaurantes";
                break;
            case 5:
                 $datos = \DB::select("SELECT *from Transporte(?)", array($mes));
                 $nombre="Transporte";
                break;
            case 6:
                 $datos = \DB::select("SELECT *from empleo(?)", array($mes));
                 $nombre="Empleo";
                break;
        }
       
       
        $array= json_decode( json_encode($datos), true);
        $datos=$array;
        
        try{
        
               \Excel::create('ExportacionOfertayEmpleo', function($excel) use($datos,$nombre) {
        
                    $excel->sheet($nombre, function($sheet) use($datos) {
                       
                
                        $sheet->fromArray($datos, null, 'A1', false, true);
                
                    });
                
                })->store('xlsx', public_path('excel/exports'));
                
                
                
                $exportacion->estado=2;
                $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
                $exportacion->save();
                
                return '/excel/exports/ExportacionOfertayEmpleo.xlsx'; 
        
        
        }catch(Exception $e){
            
            
            $exportacion=$e;
            $exportacion->estado=3;
            $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
            $exportacion->save();
            
        }
        
        
    }
    
}
