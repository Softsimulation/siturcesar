@extends('layout._IndicadoresLayout')


@section('app','ng-app="appIndicadores"')
@section('controller','ng-controller="secundariasCtrl"')

@section('estilos')

<style type="text/css">
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
    .menu-descraga, .menu-descraga .dropdown{
            float: right;
    }
    .menu-descraga .dropdown button{
        display:flex;
        align-items:center;
        background: transparent;
    }
    .menu-descraga .dropdown button .material-icons{
        margin-right: .5rem;
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
    .header-list:before{
        background-image: url(/img/bg_banner_indicadores_black.png);
        background-size: auto 200%;
    }
    .nav .nav-link:not(.active):hover {
        background-color: whitesmoke;
        border-bottom: 2px solid #eee;
    }
    .nav .nav-link.active {
        border-bottom: 2px solid #ddd;
        font-weight: bold;
        background-color: whitesmoke;
    }
    .nav {
        justify-content: center;
        margin-bottom: 1rem;
    }
    .dropdown-item{
        padding: .25rem 1rem;
        white-space: normal;
        cursor: pointer;
    }
</style>

@endsection

@section('content')
<div class="header-list">
    <div class="container">
        <h2 class="title-section"><small class="d-block">Estadisticas secundarias</small> @{{indicador.nombre}}</h2>
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
<div class="container pt-3">

    <div class="card pt-3" ng-init="indicadorSelect={{$indicadores[0]['id']}}" >
        
        <!--<ul class="list-group" ng-init="buscarData( {{$indicadores[0]['id']}} )" >-->
        <!--    @foreach ($indicadores as $indicador)-->
        <!--        <li class="list-group-item" ng-click="changeIndicador({{$indicador['id']}})" ng-class="{'active': (indicadorSelect=={{$indicador['id']}}) }" role="button">-->
        <!--          {{$indicador["nombre"]}}-->
        <!--        </li>-->
        <!--    @endforeach-->
        <!--</ul>-->
        
        
        <div class="panel panel-default">
            <div class="panel-heading pl-3 pr-3">
                <form name="form" >
                    <div class="row filtros" >
                        <div class="col-12 col-sm-6 col-md-6 col-lg-5">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="inputPeriodo">Período</span>
                              </div>
                              <select class="form-control" ng-model="filtro.year" id="inputPeriodo" ng-change="filtrarDatos()" ng-options="y.id as y.anio for y in periodos" required >
                                  <option value="" selected disabled>Seleccione un período</option>
                                </select>
                            </div>
                            
                        </div>
                        
                        
                        <div class="col-12 col-sm-6 col-md-6 col-lg-5">
                            
                            <div class="input-group mb-3" id="selectGrafica">
                                 <div class="input-group-prepend">
                                    <span class="input-group-text">Gráfica</span>
                                 </div>
                                 <p class="form-control d-flex align-items-middle"><img src="@{{graficaSelect.icono}}" alt=""> @{{graficaSelect.nombre || " "}}</p>
                                 <!--<input type="text" class="form-control" aria-label="Gráfica" readonly>-->
                                  <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <span class="sr-only">Seleccionar gráfica</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                      <button type="button" class="dropdown-item d-flex align-items-middle" ng-repeat="item in indicador.graficas" ng-click="changeTipoGrafica(item)"><img src="@{{item.icono}}" alt=""> @{{item.nombre}}</button>
                                      <button type="button" class="dropdown-item" ng-if="indicador.graficas.length == 0">No hay tipos de gráfica disponible</button>
                                    </div>
                                  </div>
                            </div>
                            
                            
                        </div> 
                        
                        <div class="col-12 col-sm-12 col-md-12 col-lg-2 menu-descraga d-flex justify-content-center text-center" >
                        
                            <div class="dropdown">
                              <button class="btn btn-outline-primary dropdown-toggle" id="dropdownMenuButton" type="button" data-toggle="dropdown">
                                  <i class="ion-android-download"></i> Descargar
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button type="button" class="dropdown-item" id="descargarPNG">Descargar gráfica: PNG</button>
                                <button type="button" class="dropdown-item" id="descargarPDF">Descargar gráfica: PDF</button>
                                <button type="button" class="dropdown-item" id="descargarGraficaTabla">Descargar gráfica y tabla de datos: PDF</button>
                              </div>
                              
                              <!--<ul class="dropdown-menu dropdown-menu-right">-->
                              <!--  <li><a href id="descargarPNG" >Descargar grafica : PNG</a></li>-->
                               <!-- <li><a href id="descargarJPG" >Download JPG image</a></li> -->
                              <!--  <li><a href id="descargarPDF" >Descargar grafica : PDF</a></li>-->
                              <!--  <li><a href id="descargarGraficaTabla" >Descargar grafica y tabla de datos : PDF</a></li>-->
                              <!--</ul>-->
                            </div>
                            
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="panel-body">
                <canvas id="base" class="chart-base" chart-type="graficaSelect.codigo" fill="black" style="background: white;"
                  chart-data="data" chart-labels="labels" chart-series="series" chart-options="options" chart-colors="colores" chart-dataset-override="override" >
                </canvas>
                
                <!--
                <a class="item-footer" style="float:left;margin-bottom:-20px;" href data-toggle="modal" data-target="#modalData"  >
                    <i class="material-icons">table_chart</i> Tabla de datos
                </a>
                -->
                <div class="container text-right">
                    <a class="item-footer" href="http://www.citur.gov.co/" target="_blank" title="Ir a CITUR">
                        <img src="/Content/image/presentacion_CITUR-01.png" width="65">
                        <span class="sr-only">Ir a CITUR</span>
                    </a>
                </div>
                
            </div>
        </div>
        
        
        <div class="panel panel-default" ng-show="data.length>0" >
                <div class="panel-heading pr-3 pl-3 d-flex justify-content-between align-items-center">
                    <legend id="tituloIndicadorGrafica"><i class="ion-ios-grid-view-outline"></i>  @{{tituloIndicadorGrafica}} </legend>
                    <button type="button" href id="descargarTABLA" class="btn btn-outline-success">
                         <img src="/Content/graficas/excel.png" class="icono" style="height: 22px;"></img> <span class="d-none d-sm-inline-block">Decargar tabla</span>
                    </button>
                </div>
                <div class="panel-body" id="customers" style="overflow-x: auto;width: 100%;margin-right: 0;">
                    
                    <table class="table table-striped" ng-if="!series"   >
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
                            <td>@{{data[$index]}}</td>
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
<!--
<div class="modal" tabindex="-1" role="dialog" id="modalData" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> @{{indicador.idiomas[0].nombre}} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
-->

@endsection





@section('javascript')
    <script src="{{asset('/js/plugins/jspdf.min.js')}}"></script>
    <script src="{{asset('/js/plugins/Chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/chartsjs-plugin-data-labels.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-filter.js')}}"></script>
    <script src="{{asset('/js/indicadores/appIndicadores.js')}}"></script>
    <script src="{{asset('/js/indicadores/servicios.js')}}"></script> 
    
    <script>
    
        $("#descargarPNG").on("click", function(){
            var canvas = document.getElementById("base");
            descargar( canvas.toDataURL() );
        });
        
        $("#descargarJPG").on("click", function(){
            var canvas = document.getElementById("base");
            descargar( canvas.toDataURL() );
        });
        
        $("#descargarPDF").on("click", function(){
            var canvas = document.getElementById("base");
            var imgData = canvas.toDataURL();
            var pdf = new jsPDF('l', 'pt', 'letter');
            pdf.addImage(imgData, 'JPEG', 0, 20, 800,400);
            pdf.save("download.pdf");
        });
        
        function descargar(img){
            var link = document.createElement("a");
            link.download = "Grafica";
            link.href = img;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        
        
        $("#descargarTABLA").on("click", function(){ 
            
            var pdf = new jsPDF('l', 'pt', 'letter');
            pdf.text(20, 20, $("#tituloIndicadorGrafica").html() );

            var margins = { top: 50, bottom: 20, left: 20, width: 522 };
    
            pdf.fromHTML( $('#customers')[0], margins.left, margins.top,
                { 
                    'width': margins.width, // max width of content on PDF
                    'elementHandlers': { '#bypassme': function (element, renderer) { return true; } }
                },
                function (dispose) { 
                    pdf.save('datos.pdf');
                },
                margins
            );
            
        });
        
        $("#descargarGraficaTabla").on("click", function(){ 
            
            var pdf = new jsPDF('l', 'pt', 'letter');
            
            
            var canvas = document.getElementById("base");
            var imgData = canvas.toDataURL();
             
            var margins = { top: 50, bottom: 20, left: 20, width: 522 };
    
            pdf.addImage(imgData, 'JPEG', 0, 20, 800,400);
            
            pdf.addPage();
            pdf.text(20, 20, $("#tituloIndicadorGrafica").html() );
            
            pdf.fromHTML( $('#customers')[0], margins.left,  margins.top, 
                { 
                    'width': margins.width, // max width of content on PDF
                    'elementHandlers': { '#bypassme': function (element, renderer) { return true; } }
                },
                function (dispose) { pdf.save('datos.pdf'); },
                margins
            );
            
        });
        
    </script>
    
@endsection