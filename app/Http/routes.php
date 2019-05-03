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
Route::controller('/indicadoresMedicion','IndicadoresMedicionController');
Route::controller('/factoresExpansion','FactorExpansionController');
Route::get('/PlanificaTuViaje','InformacionDepartamentoCtrl@PlanificaTuViaje');
Route::get('/Departamento/AcercaDe','InformacionDepartamentoCtrl@AcercaDe');
Route::get('/Departamento/Requisitos','InformacionDepartamentoCtrl@Requisitos');
Route::controller('/InformacionDepartamento','InformacionDepartamentoCtrl');

Route::controller('/promocionInforme','PublicoInformeController');
Route::controller('/informes','InformesCtrl');
Route::get('/Mapa', 'MapaCtrl@getIndex');
Route::get('/Mapa/getData', 'MapaCtrl@getData');

Route::controller('/EstadisticasSecundarias','EstadisticasSecundariasCtrl');
Route::controller('/MuestraMaestra','MuestraMaestraCtrl');

Route::controller('/indicadores','IndicadoresCtrl');


Route::get('/encuestaAdHoc/{encuesta}/registro', 'EncuestaDinamicaCtrl@getRegistrodeusuarios' );
Route::get('/encuestaAdHoc/{encuesta}', 'EncuestaDinamicaCtrl@encuesta' );
Route::get('/llenarEncuestaAdHoc/{idEncuesta}', 'EncuestaDinamicaCtrl@anonimos' );
Route::controller('/encuesta','EncuestaDinamicaCtrl');

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

Route::controller('/quehacer', 'QueHacerController');

Route::group(['middleware' => 'cors'], function(){
    
        Route::controller('/authapi', 'ApiAuthController');
         Route::controller('/turismointernoapi','TurismoInternoCorsController');
        Route::group(['middleware'=> 'jwt.auth'], function () {
           
     
            Route::controller('/turismoreceptoroapi','TurismoReceptorCorsController');
        });
});
Route::controller('/usuario','UsuarioController');

Route::controller('/sostenibilidadpst', 'SostenibilidadPstController');

Route::controller('/sostenibilidadhogares','SostenibilidadHogaresController');
Route::controller('/login','LoginController');


Route::controller('/importarRnt','ImportacionRntController');


Route::group(['prefix' => 'publicaciones','middleware'=>'auth'], function () {
    
    Route::get('/listadonuevas', 'PublicacionController@publicaciones');
    Route::get('/crear', 'PublicacionController@CrearPublicacion');
    Route::get('/editar/{id}', 'PublicacionController@EditarPublicacion');
    Route::get('/listado', 'PublicacionController@ListadoPublicaciones');
    Route::get('/listadoadmin', 'PublicacionController@ListadoPublicacionesAdmin');
    Route::get('/getPublicacion', 'PublicacionController@getPublicacion');
    Route::get('/getListadoPublico', 'PublicacionController@getListadoPublico');
    Route::get('/getListado', 'PublicacionController@getListado');
    Route::post('/guardarPublicacion', 'PublicacionController@guardarPublicacion' );
    Route::post('/editPublicacion', 'PublicacionController@editPublicacion' );
    Route::post('/eliminarPublicacion', 'PublicacionController@eliminarPublicacion' );
    Route::post('/cambiarEstadoPublicacion', 'PublicacionController@cambiarEstadoPublicacion' );
    Route::get('/getPublicacionEdit/{id}', 'PublicacionController@getPublicacionEdit');
    Route::post('/EstadoPublicacion', 'PublicacionController@EstadoPublicacion' );
    
});

Route::controller('/bolsaEmpleo','BolsaEmpleoController');

Route::controller('/promocionBolsaEmpleo','PublicoBolsaEmpleoController');

Route::controller('/postulado','PostuladoController');


Route::controller('/noticias','NoticiaController');
Route::controller('/promocionNoticia','PublicoNoticiaController');
Route::controller('/promocionInforme','PublicoInformeController');
Route::controller('/promocionPublicacion','PublicoPublicacionController');
Route::controller('/sliders','SliderController');
Route::controller('/suscriptores','SuscriptoreController');

Route::controller('/calcularindicadores', 'IndicadorAdministradorController');

Route::controller('/visitante', 'VisitanteController');

Route::controller('/', 'HomeController');


