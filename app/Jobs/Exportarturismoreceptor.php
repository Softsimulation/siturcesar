<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Exportacion;
use App\Models\Visitante;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Exportarturismoreceptor extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
     
    protected $fecha_inicio;
    protected $fecha_fin;
    protected $id; 
     
    public function __construct($fecha_inicio,$fecha_fin,$id)
    {
        $this->fecha_inicio=$fecha_inicio;
        $this->fecha_fin=$fecha_fin;
        $this->id=$id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        try{
        
        $columnas=["codigo","fecha","hora","am_pm","cod_lugar","cod_base","cod_encuestador_EN","cod_Grupo_CG","num_postal_NP","total_Per","perviven_Stder",
                   "noStder_men15","noStder_may15","noStder_adic_men15","noStder_adic_may15","excur_nino_jov","conteo_grup_noparticipan","A1","A2","A3","A3_1",
                   "A3_2","A4","A4_3_1","A4_5_1","otro_motivo","A5","A6","A7","A8_1","A8_2","A9_1","A9_2","A10","A11","cod_grupo_codificado","visitante","idioma",
                   "envio_encuesta","llamada","tipo_llamada","codigo_electronica","survey_id","physical_survey_id","current_page","A1","A1_1","A2","B1","B2","B3_1",
                   "B3_1_1","B3_1_2","B3_1_2_otro","B3_2","B3_2_1","B3_2_2","B3_2_2_otro","B3_3","B3_3_1","B3_3_2","B3_3_2_otro","B3_4","B3_4_1","B3_4_2","B3_4_2_otro",
                   "B3_5","B3_5_1","B3_5_2","B3_5_2_otro","B3_6","B3_6_1","B3_6_2","B3_6_2_otro","B3_7","B3_7_1","B3_7_2","B3_7_2_otro","B4","B5_1","B5_2","B5_3","B5_4",
                   "B5_5","B5_6","B5_7","B5_8","B5_9","B5_10","B5_11","B5_12","B5_13","B5_14","B5_15","B5_16","B5_17","B5_18","B5_otras_cuales","B5_otras_cuales_1",
                   "B5_otras_cuales_2","B5_otras_cuales_3","B5_otras_cuales_4","B5_otras_cuales_5","B5_4_1_1","B5_4_1_2","B5_4_1_3","B5_4_1_4","B5_4_1_5","B5_4_1_6",
                   "B5_4_1_7","B5_4_1_8","B5_4_1_9","B5_4_1_otros_cuales","B5_4_1_otros_cuales_1","B5_4_1_otros_cuales_2","B5_4_1_otros_cuales_3","B5_4_1_otros_cuales_4",
                   "B5_4_1_otros_cuales_5","B5_5_1_1","B5_5_1_2","B5_5_1_3","B5_5_1_4","B5_5_1_5","B5_5_1_6","B5_5_1_7","B5_6_1_1","B5_6_1_2","B5_6_1_3","B5_6_1_4","B5_6_1_5",
                   "B5_6_1_6","B5_6_1_7","B5_6_1_8","B5_6_1_otros_cuales","B5_6_1_otros_cuales_1","B5_6_1_otros_cuales_2","B5_6_1_otros_cuales_3","B5_6_1_otros_cuales_4",
                   "B5_6_1_otros_cuales_5","B5_8_1_1","B5_8_1_2","B5_8_1_3","B5_8_1_otros_cuales","B5_8_1_otros_cuales_1","B5_8_1_otros_cuales_2","B5_8_1_otros_cuales_3",
                   "B5_8_1_otros_cuales_4","B5_8_1_otros_cuales_5","B5_10_1_1","B5_10_1_2","B5_10_1_3","B5_10_1_4","B5_10_1_5","B5_10_1_6","B5_10_1_7","B5_10_1_otros_cuales",
                   "B5_10_1_otros_cuales_1","B5_10_1_otros_cuales_2","B5_10_1_otros_cuales_3","B5_10_1_otros_cuales_4","B5_10_1_otros_cuales_5","C1","C2","D1","D2_1","D2_2",
                   "D2_3","D2_4","D2_5","D2_6","D2_7","D2_8","D8_1","D2_otros_cuales","D2_otros_cuales_1","D2_otros_cuales_2","D2_otros_cuales_3","D2_otros_cuales_4",
                   "D2_otros_cuales_5","E1","E1_1_1","E1_1_2","E1_1_3","E1_1_4","E1_1_ninguna","E1_1_otros_cuales","E1_1_otros_cuales_6","E1_1_otros_cuales_7","E1_1_otros_cuales_8",
                   "E1_1_otros_cuales_9","E1_1_otros_cuales_10","E2","E2_1","E3","E3_1","E4_1","E4_2","E4_3","E4_4","E4_5","E4_6","E4_7","E4_8","E4_otros_servicios","E4_otros_servicios_1",
                   "E4_otros_servicios_2","E4_otros_servicios_3","E4_otros_servicios_4","E4_otros_servicios_5","E4_otros_servicios_6","E5_99","E5_1","E5_1_1","E5_1_1_1","E5_2_1",
                   "E5_2","E5_1_2","E5_2_2","E5_3","E5_1_3","E5_2_3","E5_4","E5_1_4","E5_2_4","E5_5","E5_1_5","E5_2_5","E5_6","E5_1_6","E5_2_6","E5_7","E5_1_7","E5_2_7","E5_8","E5_1_8",
                   "E5_2_8","E5_9","E5_1_9","E5_2_9","E5_10","E5_1_10","E5_2_10","E5_11","E5_1_11","E5_2_11","E5_12","E5_1_12","E5_2_12","E5_13","E5_1_13","E5_2_13","E5_14","E5_1_14",
                   "E5_2_14","E5_15","E5_1_15","E5_2_15","E5_otros_gastos","E5_otros_gastos_1","E5_otros_gastos_2","E5_otros_gastos_3","E5_otros_gastos_4","E5_otros_gastos_5","E7",
                   "E8","E9","E10_1","E10_2","E10_3","E10_4","E10_5","E10_6","E10_7","E10_8","E10_9","E10_10","E10_Otro","E10_Otro_1","E10_Otro_2","E10_Otro_3","E10_Otro_4","E10_Otro_5",
                   "F1","F1_1","F1_2","F1_3","F1_4","F1_5","F1_6","F1_7","F2","F2_8","F2_9","F2_10","F2_11","F2_12","F13","F14","F15","F16","F17","F18","F19","F20","F21","F22","F3",
                   "F3_1","F3_2","F3_3","F3_4","F3_5","F4","F5","F6","F7","G1_1","G1_2","G1_3","G1_4","G1_5","G1_otras_cuales","G1_otras_cuales_1","G1_otras_cuales_2","G1_otras_cuales_3",
                   "G1_otras_cuales_4","G1_otras_cuales_5","G2_1","G2_2","G2_3","G2_4","G2_5","G2_otras_cuales","G2_otras_cuales_1","G2_otras_cuales_2","G2_otras_cuales_3","G2_otras_cuales_4",
                   "G2_otras_cuales_5","G3_1","G3_2","G3_3","G3_4","G3_5","G3_otros_cuales","G3_otros_cuales_1","G3_otros_cuales_2","G3_otros_cuales_3","G3_otros_cuales_4","G3_otros_cuales_5",
                   "G4","G5","G5_1_1","G5_1_2"];
        $datos=[];
        $datos[]=$columnas;
        $visitante=Visitante::get();
        foreach($visitante as $visit){
            
            $fila=[];
            
            $fila[]=$visit->codigo_grupo;
            $aux=new \Carbon\Carbon($visit->fecha_aplicacion, 'Europe/London');
            $fila[]=($visit->fecha_aplicacion!= null)?$aux->format('d-m-Y'):"";
            $fila[]=($visit->fecha_aplicacion!= null)?$aux->format('h:i:s'):"";
            $fila[]=($visit->fecha_aplicacion!= null)?$aux->format('A'):"";
            $fila[]=$visit->lugar_aplicacion_id;
            $fila[]=$visit->codigo_encuesta;
            $fila[]=$visit->encuestador_creada;
            $fila[]=$visit->codigo_grupo;
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]=$visit->fecha_llegada;
            $fila[]=$visit->fecha_salida;
            $fila[]=$visit->municipioResidencia->nombre;
            $fila[]=$visit->municipioResidencia->departamento->nombre;
            $fila[]=$visit->municipioResidencia->departamento->paise->paisesConIdiomas->where('idioma_id',1)->first()->nombre;
            $fila[]=$visit->motivosViaje->motivosViajeConIdiomas->where('idiomas_id',1)->first()->nombre;
            $fila[]=($visit->visitantesTransito != null)?$visit->visitantesTransito->horas_transito:"";
            $fila[]=(count($visit->tiposAtencionSaluds)>0)?$visit->tiposAtencionSaluds->first()->tiposAtencionSaludConIdiomas->where('idiomas_id',1)->first()->nombre:"";
            $fila[]=($visit->otrosMotivo != null)?$visit->otrosMotivo->otro_motivo:"";
            $fila[]=$visit->opcionesLugare->opcionesLugaresConIdiomas->where('idiomas_id',1)->first()->nombre;
            $fila[]=($visit->sexo==0)?"Femenino":"Masculino";
            $fila[]=$visit->edad;
            $fila[]=$visit->nombre;
            $fila[]="";
            $fila[]=$visit->email;
            $fila[]="";
            $fila[]=$visit->celular;
            $fila[]=$visit->telefono;
            $fila[]="";
            $fila[]="esvisianteono";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]=$visit->municipioResidencia->departamento->paise->paisesConIdiomas->where('idioma_id',1)->first()->nombre;
            $fila[]=$visit->municipioResidencia->departamento->nombre;
            $fila[]=$visit->municipioResidencia->nombre;
            $aux=new \Carbon\Carbon($visit->salida, 'Europe/London');
            $fila[]=$aux->diffinDays($visit->fecha_llegada);
            $fila[]=count($visit->municipiosVisitadosMagdalenas);
            $municipios=$visit->municipiosVisitadosMagdalenas->sortBy('id');
            
            $fila[]=(count($municipios)>0)?$municipios[0]->municipio->nombre:"";
            $fila[]=(count($municipios)>0)?$municipios[0]->numero_noches:"";
            $fila[]=(count($municipios)>0)?$municipios[0]->tiposAlojamiento->tiposAlojamientoConIdiomas->where('idiomas_id',1)->first()->nombre:"";
            $fila[]="";
            
            $fila[]=(count($municipios)>1)?$municipios[1]->municipio->nombre:"";
            $fila[]=(count($municipios)>1)?$municipios[1]->numero_noches:"";
            $fila[]=(count($municipios)>1)?$municipios[1]->tiposAlojamiento->tiposAlojamientoConIdiomas->where('idiomas_id',1)->first()->nombre:"";
            $fila[]="";
            
            $fila[]=(count($municipios)>2)?$municipios[2]->municipio->nombre:"";
            $fila[]=(count($municipios)>2)?$municipios[2]->numero_noches:"";
            $fila[]=(count($municipios)>2)?$municipios[2]->tiposAlojamiento->tiposAlojamientoConIdiomas->where('idiomas_id',1)->first()->nombre:"";
            $fila[]="";
            
            $fila[]=(count($municipios)>3)?$municipios[3]->municipio->nombre:"";
            $fila[]=(count($municipios)>3)?$municipios[3]->numero_noches:"";
            $fila[]=(count($municipios)>3)?$municipios[3]->tiposAlojamiento->tiposAlojamientoConIdiomas->where('idiomas_id',1)->first()->nombre:"";
            $fila[]="";
            
            $fila[]=(count($municipios)>4)?$municipios[4]->municipio->nombre:"";
            $fila[]=(count($municipios)>4)?$municipios[4]->numero_noches:"";
            $fila[]=(count($municipios)>4)?$municipios[4]->tiposAlojamiento->tiposAlojamientoConIdiomas->where('idiomas_id',1)->first()->nombre:"";
            $fila[]="";
            
            $fila[]=(count($municipios)>5)?$municipios[5]->municipio->nombre:"";
            $fila[]=(count($municipios)>5)?$municipios[5]->numero_noches:"";
            $fila[]=(count($municipios)>5)?$municipios[5]->tiposAlojamiento->tiposAlojamientoConIdiomas->where('idiomas_id',1)->first()->nombre:"";
            $fila[]="";
            
            $fila[]=(count($municipios)>6)?$municipios[6]->municipio->nombre:"";
            $fila[]=(count($municipios)>6)?$municipios[6]->numero_noches:"";
            $fila[]=(count($municipios)>6)?$municipios[6]->tiposAlojamiento->tiposAlojamientoConIdiomas->where('idiomas_id',1)->first()->nombre:"";
            $fila[]="";
            
            $fila[]=(count($municipios)>0)?$municipios->where('destino_principal',true)->first()->municipio->nombre:"";
            
            $fila[]=($visit->actividadesRealizadasPorVisitantes->where('actividades_realizadas_id',1)->count()>0)?"Si":"No";
            $fila[]=($visit->actividadesRealizadasPorVisitantes->where('actividades_realizadas_id',2)->count()>0)?"Si":"No";
            $fila[]=($visit->actividadesRealizadasPorVisitantes->where('actividades_realizadas_id',3)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('actividades_realizadas_id',4)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('actividades_realizadas_id',5)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('actividades_realizadas_id',6)->count()>0)?"Si":"No";
            $fila[]=($visit->actividadesRealizadasPorVisitantes->where('actividades_realizadas_id',7)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('actividades_realizadas_id',8)->count()>0)?"Si":"No";
            $fila[]=($visit->actividadesRealizadasPorVisitantes->where('actividades_realizadas_id',9)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('actividades_realizadas_id',10)->count()>0)?"Si":"No";
            $fila[]=($visit->actividadesRealizadasPorVisitantes->where('actividades_realizadas_id',11)->count()>0)?"Si":"No";
            $fila[]=($visit->actividadesRealizadasPorVisitantes->where('actividades_realizadas_id',12)->count()>0)?"Si":"No";
            $fila[]=($visit->actividadesRealizadasPorVisitantes->where('actividades_realizadas_id',13)->count()>0)?"Si":"No";
            $fila[]=($visit->actividadesRealizadasPorVisitantes->where('actividades_realizadas_id',14)->count()>0)?"Si":"No";
            $fila[]=($visit->actividadesRealizadasPorVisitantes->where('actividades_realizadas_id',15)->count()>0)?"Si":"No";
            $fila[]=($visit->actividadesRealizadasPorVisitantes->where('actividades_realizadas_id',16)->count()>0)?"Si":"No";
            $fila[]=($visit->actividadesRealizadasPorVisitantes->where('actividades_realizadas_id',17)->count()>0)?"Si":"No";
            $fila[]=($visit->actividadesRealizadasPorVisitantes->where('actividades_realizadas_id',18)->count()>0)?"Si":"No";
            $aux2=$visit->actividadesRealizadasPorVisitantes->where('actividades_realizadas_id',19);
            $fila[]=(count($aux2)>0)?$aux2->first()->otro:"";
            $aux2=$visit->opcionesActividadesRealizadas->where('id',22);
            $fila[]=(count($aux2)>0)?$aux2->first()->pivot->otro:"";
            $aux2=$visit->opcionesActividadesRealizadas->where('id',26);
            $fila[]=(count($aux2)>0)?$aux2->first()->pivot->otro:"";
            $aux2=$visit->opcionesActividadesRealizadas->where('id',34);
            $fila[]=(count($aux2)>0)?$aux2->first()->pivot->otro:"";
            $fila[]="";
            $fila[]="";
            
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',1)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',2)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',3)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',4)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',5)->count()>0)?"Si":"No";
            $fila[]="";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',6)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',7)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',8)->count()>0)?"Si":"No";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',9)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',10)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',11)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',12)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',13)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',14)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',15)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',16)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',17)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',18)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',19)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',20)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',21)->count()>0)?"Si":"No";
            $aux2=$visit->opcionesActividadesRealizadas->where('id',22);
            $fila[]=(count($aux2)>0)?$aux2->first()->pivot->otro:"";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',23)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',24)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',25)->count()>0)?"Si":"No";
            $aux2=$visit->opcionesActividadesRealizadas->where('id',26);
            $fila[]=(count($aux2)>0)?$aux2->first()->pivot->otro:"";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',27)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',28)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',29)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',30)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',31)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',32)->count()>0)?"Si":"No";
            $fila[]=($visit->opcionesActividadesRealizadas->where('id',33)->count()>0)?"Si":"No";
            $aux2=$visit->opcionesActividadesRealizadas->where('id',34);
            $fila[]=(count($aux2)>0)?$aux2->first()->pivot->otro:"";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]=($visit->tiposTransporteLlegada != null)?$visit->tiposTransporteLlegada->tiposTransporteConIdiomas->where('idiomas_id',1)->first()->nombre:"";
            $fila[]=($visit->tiposTransporteInterno != null)?$visit->tiposTransporteInterno->tiposTransporteConIdiomas->where('idiomas_id',1)->first()->nombre:"";
            $fila[]=$visit->tamaño_grupo_visitante;
            $fila[]=($visit->tiposAcompañantesVisitantes->where('id',1)->count()>0)?"Si":"No";
            $fila[]=($visit->tiposAcompañantesVisitantes->where('id',2)->count()>0)?"Si":"No";
            $fila[]=($visit->tiposAcompañantesVisitantes->where('id',3)->count()>0)?"Si":"No";
            $fila[]=($visit->tiposAcompañantesVisitantes->where('id',5)->count()>0)?"Si":"No";
            $fila[]=($visit->tiposAcompañantesVisitantes->where('id',6)->count()>0)?"Si":"No";
            $fila[]=($visit->tiposAcompañantesVisitantes->where('id',7)->count()>0)?"Si":"No";
            $fila[]=($visit->tiposAcompañantesVisitantes->where('id',8)->count()>0)?"Si":"No";
            $fila[]=($visit->tiposAcompañantesVisitantes->where('id',9)->count()>0)?"Si":"No";
            $fila[]=($visit->tiposAcompañantesVisitantes->where('id',9)->count()>0)?$visit->otrosTurista->numero_otros:"";
            $fila[]=($visit->tiposAcompañantesVisitantes->where('id',10)->count()>0)?"Si":"No";
            $fila[]=($visit->tiposAcompañantesVisitantes->where('id',11)->count()>0)?"Si":"No";
            $fila[]=($visit->tiposAcompañantesVisitantes->where('id',12)->count()>0)?$visit->otrosAcompañantesViaje->nombre:"";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]=($visit->visitantePaqueteTuristico != null)?"Si":"No";
            $fila[]=($visit->visitantePaqueteTuristico != null)?($visit->visitantePaqueteTuristico->municipios->where('id',4184)->count()>0)?"Si":"":"";
            $fila[]=($visit->visitantePaqueteTuristico != null)?($visit->visitantePaqueteTuristico->municipios->where('id',4207)->count()>0)?"Si":"":"";
            $fila[]=($visit->visitantePaqueteTuristico != null)?($visit->visitantePaqueteTuristico->municipios->where('id',4208)->count()>0)?"Si":"":"";
            $fila[]=($visit->visitantePaqueteTuristico != null)?($visit->visitantePaqueteTuristico->municipios->where('id',4870)->count()>0)?"Si":"":"";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]=($visit->visitantePaqueteTuristico != null)?$visit->visitantePaqueteTuristico->costo_paquete:"";
            $fila[]=($visit->visitantePaqueteTuristico != null)?$visit->visitantePaqueteTuristico->personas_cubrio:"";
            $fila[]=($visit->visitantePaqueteTuristico != null)?$visit->visitantePaqueteTuristico->tipoProveedorPaquete->tipoProveedorPaqueteConIdiomas->where('idiomas_id',1)->first()->nombre:"";
            $fila[]=($visit->visitantePaqueteTuristico != null)?($visit->visitantePaqueteTuristico->tipo_proveedor_paquete_id == 1)?$visit->visitantePaqueteTuristico->opcionesLugares->first()->opcionesLugaresConIdiomas->where('idiomas_id',1)->first()->nombre:"":"";
            $fila[]=($visit->visitantePaqueteTuristico != null)?($visit->visitantePaqueteTuristico->serviciosPaquetes->where('id',0)->count()>0)?"Si":"":"";
            $fila[]=($visit->visitantePaqueteTuristico != null)?($visit->visitantePaqueteTuristico->serviciosPaquetes->where('id',1)->count()>0)?"Si":"":"";
            $fila[]=($visit->visitantePaqueteTuristico != null)?($visit->visitantePaqueteTuristico->serviciosPaquetes->where('id',2)->count()>0)?"Si":"":"";
            $fila[]=($visit->visitantePaqueteTuristico != null)?($visit->visitantePaqueteTuristico->serviciosPaquetes->where('id',3)->count()>0)?"Si":"":"";
            $fila[]=($visit->visitantePaqueteTuristico != null)?($visit->visitantePaqueteTuristico->serviciosPaquetes->where('id',4)->count()>0)?"Si":"":"";
            $fila[]=($visit->visitantePaqueteTuristico != null)?($visit->visitantePaqueteTuristico->serviciosPaquetes->where('id',5)->count()>0)?"Si":"":"";
            $fila[]=($visit->visitantePaqueteTuristico != null)?($visit->visitantePaqueteTuristico->serviciosPaquetes->where('id',6)->count()>0)?"Si":"":"";
            $fila[]=($visit->visitantePaqueteTuristico != null)?($visit->visitantePaqueteTuristico->serviciosPaquetes->where('id',7)->count()>0)?"Si":"":"";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            
            $fila[]=($visit->gastosVisitantes->count()==0)?"Si":"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',1)->count()>0)?"Si":"No";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',1)->count()>0)?$visit->gastosVisitantes->where('rubros_id',1)->first()->cantidad_pagada_magdalena:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',1)->count()>0 && $visit->gastosVisitantes->where('rubros_id',1)->first()->divisas_magdalena != null)?$visit->gastosVisitantes->where('rubros_id',1)->first()->divisaMag->divisasConIdiomas->where('idiomas_id',1)->first()->nombre:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',1)->count()>0)?$visit->gastosVisitantes->where('rubros_id',1)->first()->personas_cubiertas:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',2)->count()>0)?"Si":"No";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',2)->count()>0)?$visit->gastosVisitantes->where('rubros_id',2)->first()->cantidad_pagada_magdalena:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',2)->count()>0)?$visit->gastosVisitantes->where('rubros_id',2)->first()->personas_cubiertas:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',3)->count()>0)?"Si":"No";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',3)->count()>0)?$visit->gastosVisitantes->where('rubros_id',3)->first()->cantidad_pagada_magdalena:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',3)->count()>0)?$visit->gastosVisitantes->where('rubros_id',3)->first()->personas_cubiertas:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',4)->count()>0)?"Si":"No";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',4)->count()>0)?$visit->gastosVisitantes->where('rubros_id',4)->first()->cantidad_pagada_magdalena:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',4)->count()>0)?$visit->gastosVisitantes->where('rubros_id',4)->first()->personas_cubiertas:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',5)->count()>0)?"Si":"No";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',5)->count()>0)?$visit->gastosVisitantes->where('rubros_id',5)->first()->cantidad_pagada_magdalena:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',5)->count()>0)?$visit->gastosVisitantes->where('rubros_id',5)->first()->personas_cubiertas:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',6)->count()>0)?"Si":"No";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',6)->count()>0)?$visit->gastosVisitantes->where('rubros_id',6)->first()->cantidad_pagada_magdalena:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',6)->count()>0)?$visit->gastosVisitantes->where('rubros_id',6)->first()->personas_cubiertas:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',7)->count()>0)?"Si":"No";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',7)->count()>0)?$visit->gastosVisitantes->where('rubros_id',7)->first()->cantidad_pagada_magdalena:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',7)->count()>0)?$visit->gastosVisitantes->where('rubros_id',7)->first()->personas_cubiertas:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',8)->count()>0)?"Si":"No";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',8)->count()>0)?$visit->gastosVisitantes->where('rubros_id',8)->first()->cantidad_pagada_magdalena:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',8)->count()>0)?$visit->gastosVisitantes->where('rubros_id',8)->first()->personas_cubiertas:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',9)->count()>0)?"Si":"No";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',9)->count()>0)?$visit->gastosVisitantes->where('rubros_id',9)->first()->cantidad_pagada_magdalena:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',9)->count()>0)?$visit->gastosVisitantes->where('rubros_id',9)->first()->personas_cubiertas:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',10)->count()>0)?"Si":"No";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',10)->count()>0)?$visit->gastosVisitantes->where('rubros_id',10)->first()->cantidad_pagada_magdalena:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',10)->count()>0)?$visit->gastosVisitantes->where('rubros_id',10)->first()->personas_cubiertas:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',11)->count()>0)?"Si":"No";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',11)->count()>0)?$visit->gastosVisitantes->where('rubros_id',11)->first()->cantidad_pagada_magdalena:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',11)->count()>0)?$visit->gastosVisitantes->where('rubros_id',11)->first()->personas_cubiertas:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',12)->count()>0)?"Si":"No";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',12)->count()>0)?$visit->gastosVisitantes->where('rubros_id',12)->first()->cantidad_pagada_magdalena:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',12)->count()>0)?$visit->gastosVisitantes->where('rubros_id',12)->first()->personas_cubiertas:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',13)->count()>0)?"Si":"No";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',13)->count()>0)?$visit->gastosVisitantes->where('rubros_id',13)->first()->cantidad_pagada_magdalena:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',13)->count()>0)?$visit->gastosVisitantes->where('rubros_id',13)->first()->personas_cubiertas:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',14)->count()>0)?"Si":"No";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',14)->count()>0)?$visit->gastosVisitantes->where('rubros_id',14)->first()->cantidad_pagada_magdalena:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',14)->count()>0)?$visit->gastosVisitantes->where('rubros_id',14)->first()->personas_cubiertas:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',15)->count()>0)?"Si":"No";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',15)->count()>0)?$visit->gastosVisitantes->where('rubros_id',15)->first()->cantidad_pagada_magdalena:"";
            $fila[]=($visit->gastosVisitantes->where('rubros_id',15)->count()>0)?$visit->gastosVisitantes->where('rubros_id',15)->first()->personas_cubiertas:"";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]=($visit->visitanteTransporteTerrestre != null)?$visit->visitanteTransporteTerrestre->nombre_empresa:"";
            $fila[]=($visit->opcionesLugares->count()>0)?$visit->opcionesLugares->first()->opcionesLugaresConIdiomas->where('idiomas_id',1)->first()->nombre:"";
            $fila[]=($visit->opcionesLugaresG->count()>0)?$visit->opcionesLugaresG->first()->opcionesLugaresConIdiomas->where('idiomas_id',1)->first()->nombre:"";
            $fila[]=($visit->financiadoresViajes->where('id',1)->count()>0)?"Si":"No";
            $fila[]=($visit->financiadoresViajes->where('id',2)->count()>0)?"Si":"No";
            $fila[]=($visit->financiadoresViajes->where('id',3)->count()>0)?"Si":"No";
            $fila[]=($visit->financiadoresViajes->where('id',4)->count()>0)?"Si":"No";
            $fila[]=($visit->financiadoresViajes->where('id',5)->count()>0)?"Si":"No";
            $fila[]=($visit->financiadoresViajes->where('id',6)->count()>0)?"Si":"No";
            $fila[]=($visit->financiadoresViajes->where('id',7)->count()>0)?"Si":"No";
            $fila[]=($visit->financiadoresViajes->where('id',8)->count()>0)?"Si":"No";
            $fila[]=($visit->financiadoresViajes->where('id',9)->count()>0)?"Si":"No";
            $fila[]=($visit->financiadoresViajes->where('id',10)->count()>0)?"Si":"No";
            $fila[]=($visit->otrosFinanciadoresViaje != null)?$visit->otrosFinanciadoresViaje->nombre:"No";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]=($visit->calificacions->whereIn('item_evaluar_id',[1,2,3,4,5,6,7])->count()>0)?"Si":"No";
            $fila[]=($visit->calificacions->where('item_evaluar_id',1)->count()>0)?$visit->calificacions->where('item_evaluar_id',1)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',2)->count()>0)?$visit->calificacions->where('item_evaluar_id',2)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',3)->count()>0)?$visit->calificacions->where('item_evaluar_id',3)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',4)->count()>0)?$visit->calificacions->where('item_evaluar_id',4)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',5)->count()>0)?$visit->calificacions->where('item_evaluar_id',5)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',6)->count()>0)?$visit->calificacions->where('item_evaluar_id',6)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',7)->count()>0)?$visit->calificacions->where('item_evaluar_id',7)->first()->calificacion:"";
            $fila[]=($visit->calificacions->whereIn('item_evaluar_id',[8,9,10,11,12])->count()>0)?"Si":"No";
            $fila[]=($visit->calificacions->where('item_evaluar_id',8)->count()>0)?$visit->calificacions->where('item_evaluar_id',8)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',9)->count()>0)?$visit->calificacions->where('item_evaluar_id',9)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',10)->count()>0)?$visit->calificacions->where('item_evaluar_id',10)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',11)->count()>0)?$visit->calificacions->where('item_evaluar_id',11)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',12)->count()>0)?$visit->calificacions->where('item_evaluar_id',12)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',13)->count()>0)?$visit->calificacions->where('item_evaluar_id',13)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',14)->count()>0)?$visit->calificacions->where('item_evaluar_id',14)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',12)->count()>0)?$visit->calificacions->where('item_evaluar_id',12)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',17)->count()>0)?$visit->calificacions->where('item_evaluar_id',17)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',18)->count()>0)?$visit->calificacions->where('item_evaluar_id',18)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',19)->count()>0)?$visit->calificacions->where('item_evaluar_id',19)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',20)->count()>0)?$visit->calificacions->where('item_evaluar_id',20)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',21)->count()>0)?$visit->calificacions->where('item_evaluar_id',21)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',22)->count()>0)?$visit->calificacions->where('item_evaluar_id',22)->first()->calificacion:"";
            $fila[]=($visit->calificacions->where('item_evaluar_id',23)->count()>0)?$visit->calificacions->where('item_evaluar_id',23)->first()->calificacion:"";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]="";
            $fila[]=($visit->valoracionGeneral != null)?$visit->valoracionGeneral->calificacion:"";
            $fila[]=($visit->valoracionGeneral != null)?$visit->valoracionGeneral->volveria:"";
            $fila[]=($visit->valoracionGeneral != null)?$visit->valoracionGeneral->recomendaria:"";
            $fila[]=($visit->valoracionGeneral != null)?$visit->valoracionGeneral->veces_visitadas:"";
            
            $fila[]=($visit->fuentesInformacionAntesViajes->where('id',1)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionAntesViajes->where('id',2)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionAntesViajes->where('id',3)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionAntesViajes->where('id',4)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionAntesViajes->where('id',5)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionAntesViajes->where('id',10)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionAntesViajes->where('id',6)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionAntesViajes->where('id',7)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionAntesViajes->where('id',8)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionAntesViajes->where('id',14)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionAntesViajes->where('id',9)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionDuranteViajes->where('id',13)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionDuranteViajes->where('id',1)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionDuranteViajes->where('id',2)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionDuranteViajes->where('id',3)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionDuranteViajes->where('id',4)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionDuranteViajes->where('id',5)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionDuranteViajes->where('id',6)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionDuranteViajes->where('id',7)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionDuranteViajes->where('id',8)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionDuranteViajes->where('id',9)->count()>0)?"Si":"";
            $fila[]=($visit->fuentesInformacionDuranteViajes->where('id',10)->count()>0)?"Si":"";
            $fila[]=($visit->redesSociales->where('id',1)->count()>0)?"Si":"";
            $fila[]=($visit->redesSociales->where('id',2)->count()>0)?"Si":"";
            $fila[]=($visit->redesSociales->where('id',3)->count()>0)?"Si":"";
            $fila[]=($visit->redesSociales->where('id',8)->count()>0)?"Si":"";
            $fila[]=($visit->redesSociales->where('id',11)->count()>0)?"Si":"";
            $fila[]=($visit->redesSociales->where('id',4)->count()>0)?"Si":"";
            $fila[]=($visit->redesSociales->where('id',5)->count()>0)?"Si":"";
            $fila[]=($visit->redesSociales->where('id',6)->count()>0)?"Si":"";
            $fila[]=($visit->redesSociales->where('id',7)->count()>0)?"Si":"";
            $fila[]=($visit->redesSociales->where('id',9)->count()>0)?"Si":"";
            $fila[]=($visit->redesSociales->where('id',10)->count()>0)?"Si":"";
            
            $fila[]=($visit->invitacion_correo)?"Si":"No";
            $fila[]=($visit->visitanteCompartirRede != null)?"Si":"No";
            $fila[]=($visit->visitanteCompartirRede != null)?$visit->visitanteCompartirRede->nombre_facebook:"No";
            $fila[]=($visit->visitanteCompartirRede != null)?$visit->visitanteCompartirRede->nombre_twitter:"No";
            
            $datos[]=$fila;
        }
        
        \Excel::create('Exportacion', function($excel) use($datos) {

            $excel->sheet('Turismo receptor', function($sheet) use($datos) {
        
                $sheet->rows($datos);
        
            });
        
        })->store('xlsx', public_path('excel/exports'));
        
        
        $exportacion=Exportacion::find($this->id);
        $exportacion->estado=2;
        $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
        $exportacion->save();
        
        
        }catch(Exception $e){
            
            $exportacion=Exportacion::find($this->id);
            $exportacion=$e;
            $exportacion->estado=3;
            $exportacion->hora_fin=\Carbon\Carbon::now()->format('h:i:s');
            $exportacion->save();
            
        }
        
    }
}
