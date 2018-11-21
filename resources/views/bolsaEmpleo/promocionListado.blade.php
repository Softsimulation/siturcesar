<?php 
    $hasFilter = isset($_GET["nombreVacante"]) || isset($_GET["municipio"]) || isset($_GET["proveedor"]) || isset($_GET["tipoCargo"]) || isset($_GET["nivelEducacion"]);
?>
@extends('layout._publicLayout')

@section('Title', 'Bolsa de empleo - Vacantes')

@section('estilos')
<link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
<link href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet">
<style>
        #opciones{
            text-align:right;
            background-color: white;
            padding: 4px .5rem;
            margin-top: 1rem;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
            display: flex;
            justify-content: center;
            align-items: center;
            position:relative;
            z-index: 2;
            box-shadow: 0px -1px 5px -2px rgba(0,0,0,.3);
        }
        #opciones>button, #opciones form{
            display:inline-block;
            border: 0;
            margin: 0 2px;
        }
        #opciones button, #opciones a[role='button'] {
            box-shadow: 0px 1px 3px 0px rgba(0,0,0,.3);
        }
        #opciones button:hover, #opciones a[role='button']:hover{
            box-shadow: 0px 4px 12px 0px rgba(0,0,0,.2);
        }
        .input-group .form-control{
            font-size: 1rem;
            height: auto;
        }
        .input-group .input-group-addon {
            padding: 0;
        }
        .input-group .input-group-addon .btn{
            border-radius: 2px;
            border: 0;
        }
        .mdi::before {
            font-size: 1rem;
        }
        #collapseFilter{
            position: fixed;
            left: 0px;
            top: 0px;
            height: 100%;
            min-width: 250px;
            max-width: 280px;
            overflow: auto;
            background-color: rgba(255, 255, 255, 0.95);
            z-index: 100;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            padding: 1rem;
        }
        .input-group>.input-group-prepend:not(:first-child)>.input-group-text .btn {
            border-radius: 0;
            border: 0;
        }
        
        .input-group>.input-group-prepend:not(:first-child)>.input-group-text {
            padding: 0;
        }
        
        .card-header {
            padding: 2px .5rem;
        }
        .card-header .btn {
            padding: 0;
            color: #333;
            white-space: wrap;
        }
        .tile.tile-overlap .tile-img {
            background-image: url(/img/no-image.jpg);
            background-size: 100% auto;
            background-repeat: no-repeat;
            background-position: center center;
        }
        .label {
            display: inline-block;
            padding: .2rem .5rem;
            font-size: .875rem;
            font-weight: 500;
            border-radius: 2px;
            margin-bottom: 2px;
        }
        .tiles .tile{
            border: 1px solid rgba(0,0,0,.125);
            padding-bottom: 2.5rem;
        }
        .tile .tile-footer{
            position: absolute;
            bottom: .5rem;
            right: .5rem;
        }
        .list-group-item:last-child {
            border-radius: 0;
            border-bottom: 0;
        }
        
        .list-group-item:first-child {
            border-radius: 0;
            border-top: 0;
        }
        .list-group-item {
            border-left: 0;
            border-right: 0;
            padding: .5rem 1rem;
            border-color: #eee;
        }
        .list-group-item a{
        color:#555;
        text-decoration: underline;
        text-decoration-style: dotted;
        text-decoration-color: #ddd;
        
        }
        .list-group-item a:hover{
            text-decoration-color: dodgerblue;
        }
        .ionicons-list{
            font-size: 1.25rem;
            color: #ddd;
        }
    
    </style>
@endsection

@section('content')
    <div class="header-list without-options">
        <div class="container">
            <h2 class="title-section">Bolsa de empleo <small class="d-block">Vacantes</small></h2>
            <!--<div id="opciones">-->
            <!--    <button type="button" class="btn btn-outline-dark d-none d-sm-inline-block" onclick="changeViewList(this,'listado','tile-list')" title="Vista de lista"><span class="mdi mdi-view-sequential" aria-hidden="true"></span><span class="sr-only">Vista de lista</span></button>-->
            <!--    <button type="button" class="btn btn-outline-dark d-none d-sm-inline-block" onclick="changeViewList(this,'listado','')" title="Vista de mosaico"><span class="mdi mdi-view-grid" aria-hidden="true"></span><span class="sr-only">Vista de mosaico</span></button>-->
            <!--    <form class="form-inline">-->
            <!--        <input type="hidden" name="proveedor" value="@if(isset($_GET['proveedor'])){{$_GET['proveedor']}}@endif">-->
            <!--        <input type="hidden" name="municipio" value="@if(isset($_GET['municipio'])){{$_GET['municipio']}}@endif">-->
            <!--        <input type="hidden" name="tipoCargo" value="@if(isset($_GET['tipoCargo'])){{$_GET['tipoCargo']}}@endif">-->
            <!--        <input type="hidden" name="nivelEducacion" value="@if(isset($_GET['nivelEducacion'])){{$_GET['nivelEducacion']}}@endif">-->
            <!--        <div class="col-auto">-->
            <!--          <label class="sr-only" for="searchMain">Buscador general</label>-->
            <!--          <div class="input-group border-0">-->
            <!--            <input type="text" class="form-control" id="searchMain" name="nombreVacante" placeholder="¿Qué vacante busca?" maxlength="255">-->
            <!--            <div class="input-group-prepend">-->
            <!--              <div class="input-group-text border-0">-->
            <!--                  <button type="submit" class="btn btn-success" title="Buscar"><span class="mdi mdi-magnify" aria-hidden="true"></span> Buscar</button>-->
            <!--              </div>-->
            <!--            </div>-->
            <!--          </div>-->
            <!--        </div>-->
            <!--    </form>-->
            <!--    <button class="btn btn-outline-dark mr-sm-1" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">-->
            <!--        <span class="mdi mdi-filter" aria-hidden="true"></span> Filtrar-->
            <!--    </button>-->
            <!--    @if($hasFilter)-->
            <!--    <a role="button" class="btn btn-outline-dark" href="/promocionBolsaEmpleo/vacantes">-->
            <!--        <span class="mdi mdi-filter-remove" aria-hidden="true"></span> Reiniciar filtros-->
            <!--    </a>-->
                 
            <!--    @endif-->
                <!--<button type="button" class="btn btn-default"><span class="mdi mdi-filter" aria-hidden="true" title="Filtrar resultados" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter"></span><span class="sr-only">Filtrar resultados</span></button>-->
            <!--</div>-->
        </div>
        
    </div>
    <div class="container pt-3">
      <div class="card card-body">
        <form method="GET" action="/promocionBolsaEmpleo/vacantes">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="form-group">
                        <label for="nombreVacante" class="control-label">Nombre de vacante</label>
                        <input class="form-control" type="text" name="nombreVacante" id="nombreVacante" maxlength="255" placeholder="¿Qué desea buscar?" @if(isset($_GET["nombreVacante"])) value="{{$_GET['nombreVacante']}}" @endif/>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="municipio" class="control-label">Municipio</label>
                        <select class="form-control" id="municipio" name="municipio">
                            <option value="" selected disabled>Seleccione el nivel de educación</option>
                            @foreach($municipios as $municipio)
                                <option value="{{$municipio->id}}" @if(isset($_GET["municipio"]) && $_GET['municipio'] == $municipio->id) selected @endif>{{$municipio->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="proveedor" class="control-label">Proveedor</label>
                        <select class="form-control" id="proveedor" name="proveedor">
                            <option value="" selected disabled>Seleccione un proveedor</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{$proveedor->id}}" @if(isset($_GET["proveedor"]) && $_GET['proveedor'] == $proveedor->id) selected @endif>{{$proveedor->razon_social}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="tipoCargo" class="control-label">Tipo de cargo</label>
                        <select class="form-control" id="tipoCargo" name="tipoCargo">
                            <option value="" selected disabled>Seleccione un tipo de cargo</option>
                            @foreach($tiposCargos as $cargo)
                                <option value="{{$cargo->id}}" @if(isset($_GET["tipoCargo"]) && $_GET['tipoCargo'] == $cargo->id) selected @endif>{{$cargo->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="nivelEducacion" class="control-label">Nivel de educación</label>
                        <select class="form-control" id="nivelEducacion" name="nivelEducacion">
                            <option value="" selected disabled>Seleccione un nivel de educación</option>
                            @foreach($nivelesEducacion as $nivel)
                                <option value="{{$nivel->id}}" @if(isset($_GET["nivelEducacion"]) && $_GET['nivelEducacion'] == $nivel->id) selected @endif>{{$nivel->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-12 col-md-3 text-center" style="align-self: flex-end">
    				<button type="submit" class="btn btn-block btn-success" style="margin-bottom: 1rem;">
    				    <span class="ion-search"></span>
    				    Buscar
				    </button>
    			</div>
			</div>
        </form>
      </div>
    </div>
    
    
    <div class="container">
        @if($hasFilter)
        <div class="text-center" style="margin-bottom: 1rem;">
            <a role="button" class="btn btn-outline-dark" href="/promocionBolsaEmpleo/vacantes"><span class="mdi mdi-filter-remove" aria-hidden="true"></span> Reiniciar filtros</a>
           
        </div>
            
        @endif
        @if(Session::has('message'))
            <div class="alert alert-info" role="alert" style="text-align: center;">{{Session::get('message')}}</div>
        @endif
    
        <div class="tiles">
        @foreach($vacantes as $vacante)
            <!--<div class="card" style="width: 18rem;">-->
            <!--  <img class="card-img-top" src=".../100px180/?text=Image cap" alt="Card image cap">-->
            <!--  <div class="card-body">-->
            <!--    <h5 class="card-title text-uppercase"><a href="/promocionBolsaEmpleo/ver/{{$vacante->id}}">{{$vacante->nombre}}</a></h5>-->
                <!--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
            <!--  </div>-->
            <!--  <ul class="list-group list-group-flush">-->
            <!--    <li class="list-group-item">-->
            <!--          <div class="media">-->
            <!--              <div class="media-left">-->
            <!--                    <span class="media-object ionicons-list ion-android-home"></span>-->
            <!--                    <span class="sr-only">Ofertante</span>-->
            <!--              </div>-->
            <!--              <div class="media-body">-->
            <!--                  <p class="media-heading p-0 m-0"><a href="/promocionBolsaEmpleo/vacantes?proveedor={{$vacante->proveedores_rnt_id}}">{{$vacante->proveedoresRnt->razon_social}} <small>{{$vacante->proveedoresRnt->nit}}</small></a></p>-->
            <!--              </div>-->
            <!--          </div>-->
            <!--      </li>-->
            <!--      <li class="list-group-item">-->
            <!--          <div class="media">-->
            <!--              <div class="media-left">-->
            <!--                    <span class="media-object ionicons-list ion-android-pin"></span>-->
            <!--                    <span class="sr-only">Ubicación</span>-->
            <!--              </div>-->
            <!--              <div class="media-body">-->
            <!--                  <p class="media-heading p-0 m-0">-->
            <!--                      {{$vacante->proveedoresRnt->direccion}}. <a href="/promocionBolsaEmpleo/vacantes?municipio={{$vacante->municipio_id}}">{{$vacante->municipio->nombre}}</a>-->
            <!--                  </p>-->
            <!--              </div>-->
            <!--          </div>-->
            <!--      </li>-->
            <!--      <li class="list-group-item">-->
            <!--          <div class="media">-->
            <!--              <div class="media-left">-->
            <!--                    <span class="media-object ionicons-list ion-university"></span>-->
            <!--                    <span class="sr-only">Nivel de educación</span>-->
            <!--              </div>-->
            <!--              <div class="media-body">-->
            <!--                  <p class="media-heading p-0 m-0">-->
            <!--                      <a href="/promocionBolsaEmpleo/vacantes?nivelEducacion={{$vacante->nivel_educacion_id}}">{{$vacante->nivelEducacion->nombre}}</a>-->
            <!--                  </p>-->
            <!--              </div>-->
            <!--          </div>    -->
            <!--      </li>-->
            <!--      <li class="list-group-item">-->
            <!--          <div class="media">-->
            <!--              <div class="media-left">-->
            <!--                    <span class="media-object ionicons-list ion-podium"></span>-->
            <!--                    <span class="sr-only">Tipo de cargo</span>-->
            <!--              </div>-->
            <!--              <div class="media-body">-->
            <!--                  <p class="media-heading p-0 m-0">-->
            <!--                      <a href="/promocionBolsaEmpleo/vacantes?tipoCargo={{$vacante->tipo_cargo_vacante_id}}">{{$vacante->tiposCargosVacante->nombre}}</a>-->
            <!--                  </p>-->
            <!--              </div>-->
            <!--          </div>      -->
            <!--      </li>-->
            <!--  </ul>-->
            <!--  <div class="card-body">-->
            <!--    <a href="#" class="card-link">Card link</a>-->
            <!--    <a href="#" class="card-link">Another link</a>-->
            <!--  </div>-->
            <!--</div>-->
        
        
            <div class="tile">
                <div class="tile-body">
                    <div class="tile-caption">
                        <h3 class="text-uppercase"><a href="/promocionBolsaEmpleo/ver/{{$vacante->id}}">{{$vacante->nombre}}</a></h3>
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">
                          <div class="media">
                              <div class="media-left mr-1">
                                    <span class="media-object ionicons-list ion-android-home"></span>
                                    <span class="sr-only">Ofertante</span>
                              </div>
                              <div class="media-body">
                                  <p class="media-heading p-0 m-0"><a href="/promocionBolsaEmpleo/vacantes?proveedor={{$vacante->proveedores_rnt_id}}">{{$vacante->proveedoresRnt->razon_social}} <small>{{$vacante->proveedoresRnt->nit}}</small></a></p>
                              </div>
                          </div>
                      </li>
                      <li class="list-group-item">
                          <div class="media">
                              <div class="media-left mr-1">
                                    <span class="media-object ionicons-list ion-android-pin"></span>
                                    <span class="sr-only">Ubicación</span>
                              </div>
                              <div class="media-body">
                                  <p class="media-heading p-0 m-0">
                                      {{$vacante->proveedoresRnt->direccion}}. <a href="/promocionBolsaEmpleo/vacantes?municipio={{$vacante->municipio_id}}">{{$vacante->municipio->nombre}}</a>
                                  </p>
                              </div>
                          </div>
                      </li>
                      <li class="list-group-item">
                          <div class="media">
                              <div class="media-left mr-1">
                                    <span class="media-object ionicons-list ion-university"></span>
                                    <span class="sr-only">Nivel de educación</span>
                              </div>
                              <div class="media-body">
                                  <p class="media-heading p-0 m-0">
                                      <a href="/promocionBolsaEmpleo/vacantes?nivelEducacion={{$vacante->nivel_educacion_id}}">{{$vacante->nivelEducacion->nombre}}</a>
                                  </p>
                              </div>
                          </div>    
                      </li>
                      <li class="list-group-item">
                          <div class="media">
                              <div class="media-left mr-1">
                                    <span class="media-object ionicons-list ion-podium"></span>
                                    <span class="sr-only">Tipo de cargo</span>
                              </div>
                              <div class="media-body">
                                  <p class="media-heading p-0 m-0">
                                      <a href="/promocionBolsaEmpleo/vacantes?tipoCargo={{$vacante->tipo_cargo_vacante_id}}">{{$vacante->tiposCargosVacante->nombre}}</a>
                                  </p>
                              </div>
                          </div>      
                      </li>
                    </ul>
                    
                    <div class="text-right tile-footer">
                        <a role="button" href="/postulado/postular/{{$vacante->id}}" class="btn btn-sm btn-outline-success">Postularme</a>
                        <a role="button" href="/promocionBolsaEmpleo/ver/{{$vacante->id}}" class="btn btn-sm btn-outline-secondary">Ver más</a>
                    </div>
                </div>
            </div>
            <br>
        @endforeach
        </div>
    
        
        <div class="row">
    		{{$vacantes->links()}}
    	</div>
    </div>
    
    
@endsection