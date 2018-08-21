<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    
    public function viewQueHacer(){
        
        
        $lugares = [];
        $nombresEj = ['Parque de la Leyenda Vallenata “Consuelo Araujo Noguera”', 'Mi pedazo de acordeón', 'Coliseo Cubierto y Los Poporos', 'La Sirena de Hurtado y el Río Guatapuri ', 'La plaza Alfonso López Pumarejo'];
        for ($i = 0; $i < 5; $i++) {
            $lugar = new Lugar;
            $lugar->id = $i + 1;
            $lugar->nombre = $nombresEj[$i];
            $lugar->imagen = "http://www.valledupar.com/sistema-noticias/data/upimages/valledupar_poporos2.jpg";
            $lugar->alt = "Imagen de Parque de la Leyenda Vallenata “Consuelo Araujo Noguera”";
            $lugar->rating = rand (0*10, 5*10) / 10;
            $lugar->esFavorito = false;
            $lugar->estado = rand (0, 1);
            array_push($lugares, $lugar);
        }
        return view('publico.listados.queHacer',compact('lugares'));
        
    }
    public function viewExperiencias(){
        
        
        $lugares = [];
        $nombresEj = ['Parque de la Leyenda Vallenata “Consuelo Araujo Noguera”', 'Mi pedazo de acordeón', 'Coliseo Cubierto y Los Poporos', 'La Sirena de Hurtado y el Río Guatapuri ', 'La plaza Alfonso López Pumarejo'];
        for ($i = 0; $i < 5; $i++) {
            $lugar = new Lugar;
            $lugar->id = $i + 1;
            $lugar->nombre = $nombresEj[$i];
            $lugar->imagen = "http://www.valledupar.com/sistema-noticias/data/upimages/valledupar_poporos2.jpg";
            $lugar->alt = "Imagen de Parque de la Leyenda Vallenata “Consuelo Araujo Noguera”";
            $lugar->rating = rand (0*10, 5*10) / 10;
            $lugar->esFavorito = false;
            $lugar->estado = rand (0, 1);
            array_push($lugares, $lugar);
        }
        return view('publico.listados.experiencias',compact('lugares'));
        
    }
    public function viewPST(){
        
        
        $lugares = [];
        $nombresEj = ['Parque de la Leyenda Vallenata “Consuelo Araujo Noguera”', 'Mi pedazo de acordeón', 'Coliseo Cubierto y Los Poporos', 'La Sirena de Hurtado y el Río Guatapuri ', 'La plaza Alfonso López Pumarejo'];
        for ($i = 0; $i < 5; $i++) {
            $lugar = new Lugar;
            $lugar->id = $i + 1;
            $lugar->nombre = $nombresEj[$i];
            $lugar->imagen = "http://www.valledupar.com/sistema-noticias/data/upimages/valledupar_poporos2.jpg";
            $lugar->alt = "Imagen de Parque de la Leyenda Vallenata “Consuelo Araujo Noguera”";
            $lugar->rating = rand (0*10, 5*10) / 10;
            $lugar->esFavorito = false;
            $lugar->estado = rand (0, 1);
            array_push($lugares, $lugar);
        }
        return view('publico.listados.pst',compact('lugares'));
        
    }
}
class Lugar
{
    public $id;
    public $nombre;
    public $imagen;
    public $alt;
    public $rating;
    public $esFavorito;
    public $estado;
}