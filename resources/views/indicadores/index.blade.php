@extends('layout._IndicadoresLayout')


@section('app','ng-app="appIndicadores"')
@section('controller','ng-controller="IndicadoresCtrl"')

@section('estilos')

<link rel="stylesheet" href="{{asset('/js/plugins/pivotTable/dist/pivot.css')}}" type="text/css" />
<link rel="stylesheet" href="{{asset('/js/plugins/pivotTable/dist/c3.min.css')}}" type="text/css" />
<style type="text/css">
    #selectGrafica .btn-select{
        display: inline-flex;
        align-items: center;
        border-radius: 0;
        width: calc(100% - 26px);
    }
    #selectGrafica .btn-select i{
        font-size: 20px;
        margin-right: 5px;
    }
    #modalData td, #modalData th{ padding: 1px; }
    
    .filtros .input-group-addon{
        background-color: #009541!important;
        border-color: #009541!important;
        color: #fff!important;
        font-weight: 700!important;
    }
  
    .menu-descarga, .menu-descarga .dropdown{
            float: right;
    }
    .menu-descarga .dropdown button{
        display:flex;
        align-items:center;
        background: transparent;
    }
    .menu-descarga .dropdown button .material-icons{
        margin-right: .5rem;
    }
    #descargarTABLA, #descargarTABLA2{
        float: right;
        color: black;
    }
    #descargarTABLA i, #descargarTABLA2 i{
        font-size:2em;
    }
    .panel-body{
        padding:0!important;
        padding-top:20px !important;
    }
    .icono{
        height: 20px;
        margin-right: 5px;
    }
    .btn-outline-primary{
        background-color: white;
        color: #004A87;
        border-color: #004A87;
        border-radius: 6px;
    }
    .btn-outline-primary:hover{
        background-color: #004A87;
        color: white;
    }
    .dropdown-menu>li>a {
        text-align: left;
        white-space: normal;
    }
    .dropdown-menu{
        width: 100%;
        text-align:center;
    }
    .dropdown-menu>li>button:hover {
        background-color: #eee;
    }
    .dropdown-menu>li>button {
        display: block;
        font-weight: 400;
        line-height: 1.42857143;
        color: #333;
        white-space: normal;
        font-size: 1rem;
        width: 100%;
        border: 0;
        background-color: inherit;
        padding: .5rem 1rem;
    }
    #selectGrafica .btn-select{
        display: inline-flex;
        align-items: center;
        border-radius: 0;
    }
    #selectGrafica .btn-select i{
        font-size: 20px;
        margin-right: 5px;
    }
    #modalData td, #modalData th{ padding: 1px; }
    
    .filtros .input-group-addon{
        background-color: #009541!important;
        border-color: #009541!important;
        color: #fff!important;
        font-weight: 700!important;
    }
    .menu-descarga, .menu-descarga .dropdown{
            float: right;
    }
    .menu-descarga .dropdown button{
        border: none;
        background: transparent;
    }
    #descargarTABLA{
        float: right;
        color: black;
    }
    #descargarTABLA i{
        font-size:2em;
    }
    .panel-body{
        padding:0!important;
        padding-top:20px !important;
    }
    
</style>

@endsection


@section('content')

<div class="header-list">
    <div class="container">
        <h2 class="title-section"><small class="d-block">Indicador</small>@{{indicador.idiomas[0].nombre}}</h2>
        <div id="opciones">
            <div class="dropdown text-center" ng-init="buscarData( {{$indicadores[0]['id']}} )">
              <button type="button" class="btn btn-outline-primary text-uppercase dropdown-toggle"id="dropdownMenuIndicadores" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Ver más estadísticas <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuIndicadores">
                @foreach ($indicadores as $indicador)
                <button type="button" class="dropdown-item" ng-class="{'active': (indicadorSelect=={{$indicador['id']}}) }" ng-click="changeIndicador({{$indicador['id']}})">{{$indicador["idiomas"][0]['nombre']}}</button>
                @endforeach
              </div>
            </div>
        </div>
    </div>
    
</div>

<div ng-if="indicador == undefined" class="text-center">
    <img src="/img/spinner-200px.gif" alt="" role="presentation" style="display:inline-block; margin: 0 auto;">    
</div>

<a class="item-footer" style="position: fixed; z-index: 1000; left: 0;" href="http://www.citur.gov.co/" target="_blank"  >
    <img src="/Content/image/presentacion_CITUR-01.png" width="65">
</a>

<div class="container" ng-init="indicadorSelect={{$indicadores[0]['id']}}" ng-show="indicador != undefined">
    
    <br>
    
    <div ng-if="indicador == undefined" class="text-center">
        <img src="/spinner-200px.gif" alt="" role="presentation" style="display:inline-block; margin: 0 auto;">    
    </div>
    
    <div class="card" ng-init="indicadorSelect={{$indicadores[0]['id']}}" ng-show="indicador != undefined">
    
    <ul class="nav">
      <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab1">Información</a></li>
      <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab2">Tabla dinamica</a></li>
    </ul>
    
    <div class="tab-content">
      <div id="tab1" class="tab-pane fade show active">
            
            <div class="panel panel-default" ng-show="data3.length>0" >
                <div class="panel-heading pl-3 pr-3">
                    <div class="row filtros" >
                       
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3" >
                                    
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <button class="btn btn-secondary input-group-text dropdown-toggle" style="z-index: 0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Grafica</button>
                                <div class="dropdown-menu text-left">
                                  <button class="dropdown-item" type="button" ng-repeat="item in indicador.graficas" ng-click="changeTipoGrafica3(item)">
                                      <img src="@{{item.icono}}" class="icono" ></img> @{{item.nombre}}
                                  </button>
                                  
                                </div>
                              </div>
                              <p class="form-control text-truncate">
                                  <img src="@{{graficaSelect.icono}}" class="icono" ></img> @{{graficaSelect.nombre || " "}}
                              </p>
                            </div>
                            
                        </div> 
                       
                    </div> 
                </div>
                <div class="panel-body">
                    
                    <div class="row" >
                        <div class="col-md-12" >
                            <div class="menu-descarga" >
                                <div class="dropdown">
                                  <button class="btn btn-outline-primary dropdown-toggle w-100" id="dropdownMenuButton" type="button" data-toggle="dropdown">
                                      <i class="ion-android-download"></i> Descargar
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <button type="button" class="dropdown-item" id="descargarPNG3">Descargar gráfica: PNG</button>
                                    <button type="button" class="dropdown-item" id="descargarPDF3">Descargar gráfica: PDF</button>
                                    <button type="button" class="dropdown-item" id="descargarGraficaTabla3">Descargar gráfica y tabla de datos: PDF</button>
                                  </div>
                                </div>
                            </div>
                            
                            <canvas id="base3" class="chart-base" chart-type="graficaSelect3.codigo" fill="black" style="background: white;"
                              chart-data="data3" chart-labels="labels3" chart-series="series3" chart-options="options3" chart-colors="colores" chart-dataset-override="override3" >
                            </canvas>
                        </div>
                        <div class="col-md-12" >
                            <hr>
                            <div class="panel-heading">
                                <i class="material-icons">table_chart</i> <span id="tituloIndicadorGrafica3" > @{{tituloIndicadorGrafica3}} </span>
                                <a href id="descargarTABLA2" >
                                     <img src="/Content/graficas/excel.png" class="icono" ></img>
                                </a>
                            </div>
                            
                            <div id="TablaDatos3" class="table-responsive" >
                                <table class="table table-striped" ng-if="!series2" >
                                    <thead>
                                      <tr>
                                        <th>@{{indicador.idiomas[0].eje_x}} </th>
                                        <th>Cantidad</th>
                                        <th ng-if="dataExtra" >Media</th>
                                        <th ng-if="dataExtra" >Mediana</th>
                                        <th ng-if="dataExtra" >Moda</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr  ng-repeat="label in labels3" >
                                        <td>@{{label}}</td>
                                        <td>@{{data3[0][$index]}}</td>
                                        <td ng-if="dataExtra" >@{{dataExtra.media[$index]}}</td>
                                        <td ng-if="dataExtra" >@{{dataExtra.mediana[$index]}}</td>
                                        <td ng-if="dataExtra" >@{{dataExtra.moda[$index]}}</td>
                                      </tr>
                                    </tbody>
                                </table>
                            
                                <table class="table table-striped" ng-if="series3" >
                                    <thead>
                                      <tr>
                                        <th></th>
                                        <th ng-repeat="item in labels3" >@{{item}}</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr ng-repeat="datos in data3 track by $index" >
                                        <td>@{{series3[$index]}}</td>
                                        <td ng-repeat="d in datos track by $index">@{{d}}</td>
                                      </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                </div>
            </div>
            
            <div class="panel panel-default" ng-show="data2.length>0" >
                <div class="panel-heading pl-3 pr-3">
                    <div class="row filtros" >
                       
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3" >
                                    
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <button class="btn btn-secondary input-group-text dropdown-toggle" style="z-index: 0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Grafica</button>
                                <div class="dropdown-menu text-left">
                                  <button class="dropdown-item" type="button" ng-repeat="item in indicador.graficas" ng-click="changeTipoGrafica2(item)">
                                      <img src="@{{item.icono}}" class="icono" ></img> @{{item.nombre}}
                                  </button>
                                  
                                </div>
                              </div>
                              <p class="form-control text-truncate">
                                  <img src="@{{graficaSelect.icono}}" class="icono" ></img> @{{graficaSelect.nombre || " "}}
                              </p>
                            </div>
                            
                        </div> 
                        
                    </div> 
                </div>
                <div class="panel-body">
                    
                    <div class="row" >
                        <div class="col-md-12" >
                            <div class="menu-descarga" >
                            
                                <div class="dropdown">
                                  <button class="btn btn-outline-primary dropdown-toggle w-100" id="dropdownMenuButton" type="button" data-toggle="dropdown">
                                      <i class="ion-android-download"></i> Descargar
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <button type="button" class="dropdown-item" id="descargarPNG2">Descargar gráfica: PNG</button>
                                    <button type="button" class="dropdown-item" id="descargarPDF2">Descargar gráfica: PDF</button>
                                    <button type="button" class="dropdown-item" id="descargarGraficaTabla2">Descargar gráfica y tabla de datos: PDF</button>
                                  </div>
                                </div>
                                
                            </div>
                            
                            <canvas id="base2" class="chart-base" chart-type="graficaSelect2.codigo" fill="black" style="background: white;"
                              chart-data="data2" chart-labels="labels2" chart-series="series2" chart-options="options2" chart-colors="colores" chart-dataset-override="override2" >
                            </canvas>
                        </div>
                        <div class="col-md-12" >
                            <hr>
                            <div class="panel-heading">
                                <i class="material-icons">table_chart</i> <span id="tituloIndicadorGrafica2" > @{{tituloIndicadorGrafica2}} </span>
                                <a href id="descargarTABLA2" >
                                     <img src="/Content/graficas/excel.png" class="icono" ></img>
                                </a>
                            </div>
                            
                            <div id="TablaDatos2" class="table-responsive" >
                                <table class="table table-striped" ng-if="!series2" >
                                    <thead>
                                      <tr>
                                        <th>@{{indicador.idiomas[0].eje_x}} </th>
                                        <th>Cantidad</th>
                                        <th ng-if="dataExtra" >Media</th>
                                        <th ng-if="dataExtra" >Mediana</th>
                                        <th ng-if="dataExtra" >Moda</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr  ng-repeat="label in labels2" >
                                        <td>@{{label}}</td>
                                        <td>@{{data2[0][$index]}}</td>
                                        <td ng-if="dataExtra" >@{{dataExtra.media[$index]}}</td>
                                        <td ng-if="dataExtra" >@{{dataExtra.mediana[$index]}}</td>
                                        <td ng-if="dataExtra" >@{{dataExtra.moda[$index]}}</td>
                                      </tr>
                                    </tbody>
                                </table>
                            
                            
                                <table class="table table-striped" ng-if="series2" >
                                    <thead>
                                      <tr>
                                        <th></th>
                                        <th ng-repeat="item in labels2" >@{{item}}</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr ng-repeat="datos in data2 track by $index" >
                                        <td>@{{series2[$index]}}</td>
                                        <td ng-repeat="d in datos track by $index">@{{d}}</td>
                                      </tr>
                                    </tbody>
                                </table>
                            
                            </div>
                        </div>
                    </div>
                    
                    
                    
                </div>
            </div>
            
            
            <div class="panel panel-default">
                <div class="panel-heading pl-3 pr-3">
                    <form name="form" >
                        <div class="row filtros" >
                            <div class="col-12 col-sm-12 col-md-4 col-lg-3" >
                                <label for="yearSelect" class="sr-only">Periodo</label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="addon-periodo">Periodo</span>
                                  </div>
                                  <select class="form-control" ng-model="yearSelect" id="yearSelect" ng-change="changePeriodo()" ng-options="y as y.year for y in periodos | unique: 'year'" required aria-describedby="addon-periodo">
                                    </select>
                                </div>
                                
                            </div>
                            
                            <div class="col-12 col-sm-12 col-md-4 col-lg-3" ng-show="yearSelect.mes" >
                                <label for="mesSelect" class="sr-only">Mes</label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="addon-mesSelect">Mes</span>
                                  </div>
                                  <select class="form-control" ng-model="mesSelect" id="mesSelect" ng-change="filtro.id=mesSelect.id;filtro.mes=mesSelect.mes;filtrarDatos()" ng-options="m as m.mes for m in periodos | filter:{ 'year': yearSelect.year }" ng-required="yearSelect.mes"  >
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4" ng-show="yearSelect.temporada" >
                                <label for="SelectTemporada" class="sr-only">Temporada</label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="addon-TempoSelect">Temporada</span>
                                  </div>
                                  <select class="form-control" id="SelectTemporada" ng-model="filtro.id" ng-change="filtrarDatos()" ng-options="t.id as t.temporada for t in periodos | filter:{ 'year': yearSelect.year }" ng-requerid="yearSelect.temporada"  >
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4" ng-show="yearSelect.trimestre" >
                                <label for="SelectTrimestre" class="sr-only">Trimestre</label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="addon-Trimestre">Trimestre</span>
                                  </div>
                                  <select class="form-control" id="SelectTrimestre" ng-model="filtro.id" ng-change="filtro.id=SelectTrimestre.id;filtro.trimestre=SelectTrimestre.trimestre;filtrarDatos()" ng-options="t.id as t.trimestre for t in periodos | filter:{ 'year': yearSelect.year }" ng-requerid="yearSelect.trimestre"  >
                                   </select>
                                </div>
                            </div>
                            
                            <div class="col-12 col-sm-12 col-md-4 col-lg-3" ng-if="indicadorSelect==5">
                                
                                <label for="SelectTipoGasto" class="sr-only">Gasto promedio</label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="addon-SelectTipoGasto">Gasto promedio</span>
                                  </div>
                                  <select class="form-control" ng-model="filtro.tipoGasto" id="SelectTipoGasto" ng-change="filtrarDatos()" >
                                        <option value="1" selected>Total</option>
                                        <option value="2">Por día</option>
                                    </select>
                                </div>
                            </div>
                                
                            <div class="col-xs-12 col-sm-6 col-md-3" >
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <button class="btn btn-secondary input-group-text dropdown-toggle" style="z-index: 0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Grafica</button>
                                    <div class="dropdown-menu text-left">
                                      <button class="dropdown-item" type="button" ng-repeat="item in indicador.graficas" ng-click="changeTipoGrafica(item)">
                                          <img src="@{{item.icono}}" class="icono" ></img> @{{item.nombre}}
                                      </button>
                                      
                                    </div>
                                  </div>
                                  <p class="form-control text-truncate">
                                      <img src="@{{graficaSelect.icono}}" class="icono" ></img> @{{graficaSelect.nombre || " "}}
                                  </p>
                                </div>
                            </div> 
                            
                        </div>    
                    </form>
                </div>
                <div class="panel-body">
                    
                    <div class="row" >
                        <div class="col-md-12" >
                            
                            <div class="menu-descarga" >
                            
                                <div class="dropdown">
                                  <button class="btn btn-outline-primary dropdown-toggle w-100" id="dropdownMenuButton" type="button" data-toggle="dropdown">
                                      <i class="ion-android-download"></i> Descargar
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <button type="button" class="dropdown-item" id="descargarPNG">Descargar gráfica: PNG</button>
                                    <button type="button" class="dropdown-item" id="descargarPDF">Descargar gráfica: PDF</button>
                                    <button type="button" class="dropdown-item" id="descargarGraficaTabla">Descargar gráfica y tabla de datos: PDF</button>
                                  </div>
                                </div>
                                
                            </div>
                            
                            <canvas id="base" class="chart-base" chart-type="graficaSelect.codigo" fill="black" style="background: white;"
                              chart-data="data" chart-labels="labels" chart-series="series" chart-options="options" chart-colors="colores" chart-dataset-override="override" >
                            </canvas>
                        </div>
                        
                        <div class="col-md-12" >
                            <hr>
                            <div class="panel-heading">
                                <i class="material-icons">table_chart</i> <span id="tituloIndicadorGrafica" > @{{tituloIndicadorGrafica}} </span>
                                <a href id="descargarTABLA" >
                                     <img src="/Content/graficas/excel.png" class="icono" ></img>
                                </a>
                            </div>
                            <div id="TablaDatos" class="table-responsive" >
                                <table class="table table-striped" ng-if="!series" >
                                    <thead>
                                      <tr>
                                        <th>@{{indicador.idiomas[0].eje_x}} </th>
                                        <th>Cantidad</th>
                                        <th ng-if="dataExtra" >Media</th>
                                        <th ng-if="dataExtra" >Mediana</th>
                                        <th ng-if="dataExtra" >Moda</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr  ng-repeat="label in labels" >
                                        <td>@{{label}}</td>
                                        <td>@{{data[0][$index]}}</td>
                                        <td ng-if="dataExtra" >@{{dataExtra.media[$index]}}</td>
                                        <td ng-if="dataExtra" >@{{dataExtra.mediana[$index]}}</td>
                                        <td ng-if="dataExtra" >@{{dataExtra.moda[$index]}}</td>
                                      </tr>
                                    </tbody>
                                </table>
                                
                                <table class="table table-striped" ng-if="series" >
                                    <thead>
                                      <tr>
                                        <th></th>
                                        <th ng-repeat="item in labels" >@{{item}}</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr ng-repeat="datos in data track by $index" >
                                        <td>@{{series[$index]}}</td>
                                        <td ng-repeat="d in datos track by $index">@{{d}}</td>
                                      </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    
                    
                    
                </div>
            </div>
           
           <p>
               <b>Descripción</b>: @{{indicador.idiomas[0].descripcion}}
           </p>
           
    
      </div>
      <div id="tab2" class="tab-pane fade p-3">
          
            <a href id="descargarPivotTable" >
                 <img src="/Content/graficas/excel.png" class="icono" ></img>
            </a>
          
            <div class="row" >
                <div class="table-responsive col-lg-12 col-md-12 col-sm-12" style="max-height:490px">
                    <div id="tablaDinamica" style="min-height:430px;"></div>
                </div>
            </div>
      </div>
    </div>
    
    
    
    
</div>

@endsection


@section('javascript')
    <script src="{{asset('/js/plugins/jspdf.min.js')}}"></script>
    <script src="{{asset('/js/plugins/Chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-filter.js')}}"></script>
    <script src="{{asset('/js/indicadores/appIndicadores.js')}}"></script>
    <script src="{{asset('/js/indicadores/servicios.js')}}"></script> 
    
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="{{asset('/js/plugins/pivotTable/dist/pivot.js')}}"></script>
    <script src="{{asset('/js/plugins/pivotTable/dist/pivot.es.js')}}"></script>
    <script src="{{asset('/js/plugins/pivotTable/jquery-ui-touch-punch.js')}}"></script>
    <script src="{{asset('/js/plugins/pivotTable/dist/d3.min.js')}}"></script>
    <script src="{{asset('/js/plugins/pivotTable/dist/c3.min.js')}}"></script>
    <script src="{{asset('/js/plugins/pivotTable/dist/c3_renderers.js')}}"></script>
    
    
    <script>
        
        $("#descargarPNG3").on("click", function(){ descargar( "base3", $("#tituloIndicadorGrafica3").html() ); });
        
        $("#descargarPDF3").on("click", function(){ descargarPDF( "base3" , $("#tituloIndicadorGrafica3").html() ); });
        
        $("#descargarGraficaTabla3").on("click", function(){ descargarGraficaDatosPDF( "TablaDatos3", "base3" , $("#tituloIndicadorGrafica3").html() ); });
        
        $("#descargarTABLA3").on("click", function(){ descargarTabla( "TablaDatos3" , $("#tituloIndicadorGrafica3").html() ); });
        
        ///////////////////////////////////////////
        
        $("#descargarPNG2").on("click", function(){ descargar( "base2", $("#tituloIndicadorGrafica2").html() ); });
        
        $("#descargarPDF2").on("click", function(){ descargarPDF( "base2" , $("#tituloIndicadorGrafica2").html() ); });
        
        $("#descargarGraficaTabla2").on("click", function(){ descargarGraficaDatosPDF( "TablaDatos2", "base2" , $("#tituloIndicadorGrafica2").html() ); });
        
        $("#descargarTABLA2").on("click", function(){ descargarTabla( "TablaDatos2" , $("#tituloIndicadorGrafica2").html() ); });
        
        ///////////////////////////////////////
        
        $("#descargarPNG").on("click", function(){ descargar( "base", $("#tituloIndicadorGrafica").html() ); });
        
        $("#descargarPDF").on("click", function(){ descargarPDF( "base" , $("#tituloIndicadorGrafica").html() ); });
        
        $("#descargarGraficaTabla").on("click", function(){ descargarGraficaDatosPDF( "TablaDatos", "base" , $("#tituloIndicadorGrafica").html() ); });
        
        $("#descargarTABLA").on("click", function(){ descargarTabla( "TablaDatos" , $("#tituloIndicadorGrafica").html() ); });
        
        /////////////////////////////////////////
        
        function descargar(id, titulo){
            
            var canvas = document.getElementById(id);
            
            var link = document.createElement("a");
            link.download = titulo;
            link.href = canvas.toDataURL();
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        
        function descargarPDF(id, titulo){
            var canvas = document.getElementById(id);
            var pdf = new jsPDF('l', 'pt', 'letter');
            pdf.addImage(canvas.toDataURL(), 'JPEG', 0, 20, 800,400);
            pdf.save( titulo +".pdf");
        }
        
        function descargarGraficaDatosPDF(idTabla, idGrafica , titulo){
            var pdf = new jsPDF('l', 'pt', 'letter');
            
            var canvas = document.getElementById(idGrafica);
            var imgData = canvas.toDataURL();
             
            var margins = { top: 50, bottom: 20, left: 20, width: 522 };
    
            pdf.addImage(imgData, 'JPEG', 0, 20, 800,400);
            
            pdf.addPage();
            pdf.text(20, 20, titulo );
            
            pdf.fromHTML( $('#'+idTabla )[0], margins.left,  margins.top, 
                { 
                    'width': margins.width, // max width of content on PDF
                    'elementHandlers': { '#bypassme': function (element, renderer) { return true; } }
                },
                function (dispose) { pdf.save( titulo +'.pdf'); },
                margins
            );
        }
        
        function descargarTabla(id, titulo){
            var htmls = "";
            var uri = 'data:application/vnd.ms-excel;base64,';
            var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'; 
            var base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) };
            var format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }); };

            htmls = $("#"+id).html()

            var ctx = { worksheet : 'Worksheet', table : htmls };

            var link = document.createElement("a");
            link.download = titulo;
            link.href = uri + base64(format(template, ctx));
            link.click();
        }
        
        /////////////////////////////////////////
        
        
        
        $("#descargarPivotTable").on("click", function(){ 
            
            var htmls = "";
            var uri = 'data:application/vnd.ms-excel;base64,';
            var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'; 
            var base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) };
            var format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }); };

            htmls = $(".pvtRendererArea").html();

            var ctx = { worksheet : 'Worksheet', table : htmls };

            var link = document.createElement("a");
            link.download = $("#tituloIndicadorGrafica").html();
            link.href = uri + base64(format(template, ctx));
            link.click();
        });
        
    </script>
    
@endsection