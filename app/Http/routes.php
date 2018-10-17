<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::get('/', function () {
    
    return view('home.index');
    
    
});

Route::get('/QueHacer','HomeController@viewQueHacer');
Route::get('/Experiencias','HomeController@viewExperiencias');
Route::get('/PST','HomeController@viewPST');

Route::controller('/temporada','TemporadaController');
Route::controller('/turismointerno','TurismoInternoController');

Route::controller('/turismoreceptor','TurismoReceptorController');

Route::controller('/grupoviaje','GrupoViajeController');
Route::controller('/exportacion','ExportacionController');

Route::controller('/administrarpaises', 'AdministrarPaisesController');

Route::controller('/administrardepartamentos', 'AdministrarDepartamentosController');

Route::controller('/administrarmunicipios', 'AdministrarMunicipiosController');
Route::controller('/ofertaempleo','OfertaEmpleoController');

Route::controller('/administradorproveedores', 'AdministradorProveedoresController');

Route::controller('/administradoreventos', 'AdministradorEventosController');

Route::controller('/administradorrutas', 'AdministradorRutasController');

Route::controller('/administradoratracciones', 'AdministradorAtraccionController');

Route::controller('/administradoractividades', 'AdministradorActividadesController');

Route::controller('/administradordestinos', 'AdministradorDestinosController');

// Public Jáder
Route::controller('/atracciones', 'AtraccionesController');

Route::controller('/actividades', 'ActividadesController');

Route::controller('/destinos', 'DestinosController');

Route::controller('/rutas', 'RutasTuristicasController');

Route::controller('/eventos', 'EventosController');

Route::controller('/proveedor', 'ProveedoresController');

Route::group(['middleware' => 'cors'], function(){
    
        Route::controller('/authapi', 'ApiAuthController');
        Route::group(['middleware'=> 'jwt.auth'], function () {
            Route::controller('/turismointernoapi','TurismoInternoCorsController');
       
            Route::controller('/turismoreceptoroapi','TurismoReceptorCorsController');
        });
});
Route::controller('/usuario','UsuarioController');

Route::controller('/sostenibilidadpst', 'SostenibilidadPstController');

Route::controller('/sostenibilidadhogares','SostenibilidadHogaresController');
Route::controller('/login','LoginController');


Route::controller('/importarRnt','ImportacionRntController');

Route::get('/detalle', function () {
    
    return view('publico.detalle.index');
    
    
});

Route::controller('/bolsaEmpleo','BolsaEmpleoController');

Route::controller('/promocionBolsaEmpleo','PublicoBolsaEmpleoController');

Route::controller('/postulado','PostuladoController');

