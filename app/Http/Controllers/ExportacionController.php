<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\Exportarturismoreceptor;
use App\Http\Requests;
use App\Models\Exportacion;

class ExportacionController extends Controller
{
  
    
    public function getIndex(){
        
        return view('exportacion.Index');
        
    }
    
    public function postExportar(Request $request){
        
        $validator=\Validator::make($request->all(),['nombre'=>'required','fecha_inicial'=>'required|date|before:tomorrow','fecha_final'=>'required|date|before:tomorrow']);
        if($validator->fails()){
            
            return ["success"=>false,"errores"=>$validator->errors()];
            
        }
        
        switch($request->nombre){
            
            case 'receptor': 
                $this->ExportacionTurismoReceptor2($request->fecha_inicial,$request->fecha_final);
            break;
            
        }
        
        return ["success"=>true];
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
        
        
        $this->dispatchNow(new Exportarturismoreceptor($fecha_inicial,$fecha_final,$exportacion->id));
        
    }
    
}
