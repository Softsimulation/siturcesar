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
        
        $columnas=["codigo","fecha","hora","am_pm","cod_lugar","cod_base","cod_encuestador_EN","cod_Grupo_CG","num_postal_NP","total_Per","perviven_Stder",
                   "noStder_men15","noStder_may15","noStder_adic_men15","noStder_adic_may15","excur_nino_jov","conteo_grup_noparticipan","A1","A2","A3","A3_1",
                   "A3_2","A4","A4_3_1","A4_5_1","otro_motivo","A5","A6","A7","A8_1","A8_2","A9_1","A9_2","A10","A11","cod_grupo_codificado","visitante","idioma",
                   "envio_encuesta","llamada","tipo_llamada","codigo_electronica"];
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
        
        
        
    }
}
