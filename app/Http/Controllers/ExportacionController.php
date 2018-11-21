<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\Exportarturismoreceptor;
use App\Http\Requests;
use App\Models\Exportacion;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
    
    public function postExportar(Request $request){
        
        $validator=\Validator::make($request->all(),['nombre'=>'required','fecha_inicial'=>'required|date|before:tomorrow','fecha_final'=>'required|date|before:tomorrow']);
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
    
}
