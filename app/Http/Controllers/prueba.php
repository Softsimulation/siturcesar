<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Indicadores_medicion;
use App\Models\Tipos_grafica;
use App\Models\Idioma;
use App\Models\Indicadores_mediciones_idioma;
use App\Models\Tipo_Medicion_Indicador;
use Carbon\Carbon;



class prueba extends Controller
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
        //return $this->user;
        return view('IndicadoresMedicion.ListadoIndicadoresMedicion');
    }
}