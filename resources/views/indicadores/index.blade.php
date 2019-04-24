@extends('layout._IndicadoresLayout')


@section('app','ng-app="appIndicadores"')
@section('controller','ng-controller="IndicadoresCtrl"')

@section('estilos')

<link rel="stylesheet" href="{{asset('/js/plugins/pivotTable/dist/pivot.css')}}" type="text/css" />
<link rel="stylesheet" href="{{asset('/js/plugins/pivotTable/dist/c3.min.css')}}" type="text/css" />
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
    /*#opciones button, #opciones a[role='button'] {*/
    /*    box-shadow: 0px 1px 3px 0px rgba(0,0,0,.3);*/
    /*}*/
    /*#opciones button:hover, #opciones a[role='button']:hover{*/
    /*    box-shadow: 0px 4px 12px 0px rgba(0,0,0,.2);*/
    /*}*/
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
    /*.menu-descraga, .menu-descraga .dropdown{*/
    /*        float: right;*/
    /*}*/
    /*.menu-descraga .dropdown button{*/
    /*    display:flex;*/
    /*    align-items:center;*/
    /*    background: transparent;*/
    /*}*/
    /*.menu-descraga .dropdown button .material-icons{*/
    /*    margin-right: .5rem;*/
    /*}*/
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
    .icono{
        height: 22px;
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
    /*.menu-descraga, .menu-descraga .dropdown{*/
    /*        float: right;*/
    /*}*/
    /*.menu-descraga .dropdown button{*/
    /*    border: none;*/
    /*    background: transparent;*/
    /*}*/
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

<div class="container">
    
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
                                    <label for="SelectTemporada" class="sr-only">Temporadas</label>
                                    <div class="input-group mb-3">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="addon-TempoSelect">Temporadas</span>
                                      </div>
                                      <select class="form-control" id="SelectTemporada" ng-model="filtro.id" ng-change="filtrarDatos()" ng-options="t.id as t.temporada for t in periodos | filter:{ 'year': yearSelect.year }" ng-requerid="yearSelect.temporada"  >
                                        </select>
                                    </div>
                                </div>
                                
                                
                                @if( isset($aspectos) )
                                <div class="col-xs-12 col-md-3" ng-if="indicadorSelect==44">
                                    <div class="input-group" >
                                        <label for="aspecto" class="sr-only" >Aspecto </label>
                                        <div class="input-group mb-3">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text" id="addon-AspSelect">Aspecto</span>
                                          </div>
                                           <select class="form-control" ng-model="filtro.aspecto" id="aspecto" ng-change="filtrarDatos()" >
                                                <option value="" selectd >Todos</option>
                                                @for ($i = 0; $i < count($aspectos); $i++)
                                                   <option value="{{$aspectos[$i]->aspecto_evaluacion}}" >{{$aspectos[$i]->nombre}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                @if( isset($tipoExperiencia) )
                                <div class="col-xs-12 col-md-4" ng-if="indicadorSelect==61 || indicadorSelect==77">
                                    <label for="experiencia" class="sr-only" ng-init="filtro.tipoExperiencia='{{$tipoExperiencia[0]['key']}}' " >Tipo experiencia  </label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                         <span class="input-group-text" id="addon-AspSelect">Tipo experiencia </span>
                                        </div>
                                        <select class="form-control" ng-model="filtro.tipoExperiencia" id="experiencia" ng-change="filtrarDatos()" >
                                            <option value="{{$tipoExperiencia[0]['key']}}" >{{$tipoExperiencia[0]['nombre']}}</option>
                                            <option value="{{$tipoExperiencia[1]['key']}}" >{{$tipoExperiencia[1]['nombre']}}</option>
                                        </select>
                                    </div>
                                </div>
                                @endif
                                    
                                
                                
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
                                
                                <div class="col-12 col-sm-12 col-md-4 col-lg-3" >
                                    
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
                                
                                <div class="col-xs-12 col-sm-12 col-lg-2 menu-descraga" >
                                
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
                            </div>    
                        </form>
                    </div>
                    <div class="panel-body">
                        <canvas id="base" class="chart-base" chart-type="graficaSelect.codigo" fill="black" style="background: white;"
                          chart-data="data" chart-labels="labels" chart-series="series" chart-options="options" chart-colors="colores" chart-dataset-override="override" >
                        </canvas>
                        <div class="container text-right">
                            <a class="item-footer" href="http://www.citur.gov.co/" target="_blank" title="Ir a CITUR">
                                <img src="/Content/image/presentacion_CITUR-01.png" width="65">
                                <span class="sr-only">Ir a CITUR</span>
                            </a>
                        </div>
                        
                        
                    </div>
                </div>
               <div class="container">
                   <p class="text-center">
                       Descripción: @{{indicador.idiomas[0].descripcion}}
                   </p>
               </div>
               
               
                <div class="panel panel-default" ng-show="data.length>0" >
                        <div class="panel-heading pr-3 pl-3 d-flex justify-content-between align-items-center">
                            <legend id="tituloIndicadorGrafica"><i class="ion-ios-grid-view-outline"></i>  @{{tituloIndicadorGrafica}} </legend>
                            <button type="button" href id="descargarTABLA" class="btn btn-outline-success">
                                 <img src="/Content/graficas/excel.png" class="icono" ></img> <span class="d-none d-sm-inline-block">Decargar tabla</span>
                            </button>
                        </div>
                        <div class="panel-body" id="customers" style="overflow-x: auto;width: 100%;margin-right: 0;" >
                            
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
          <div id="tab2" class="tab-pane fade p-3">
              
                <button type="button" id="descargarPivotTable" class="btn btn-outline-success">
                     <img src="/Content/graficas/excel.png" class="icono" ></img>
                     Descargar en formato Excel
                </button>
              
                <div class="row" >
                    <div class="table-responsive col-12" style="max-height:490px">
                        <div id="tablaDinamica" style="min-height:430px;"></div>
                    </div>
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
    
    <script src="{{asset('/js/plugins/pivotTable/dist/pivot.js')}}"></script>
    <script src="{{asset('/js/plugins/pivotTable/dist/pivot.es.js')}}"></script>
    <script src="{{asset('/js/plugins/pivotTable/jquery-ui-touch-punch.js')}}"></script>
    <script src="{{asset('/js/plugins/pivotTable/dist/d3.min.js')}}"></script>
    <script src="{{asset('/js/plugins/pivotTable/dist/c3.min.js')}}"></script>
    <script src="{{asset('/js/plugins/pivotTable/dist/c3_renderers.js')}}"></script>
    
    
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
            
            var htmls = "";
            var uri = 'data:application/vnd.ms-excel;base64,';
            var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'; 
            var base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) };
            var format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }); };

            htmls = $("#customers").html()

            var ctx = { worksheet : 'Worksheet', table : htmls };

            var link = document.createElement("a");
            link.download = "datos.xls";
            link.href = uri + base64(format(template, ctx));
            link.click();
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
        
        
        $("#descargarPivotTable").on("click", function(){ 
            
            var htmls = "";
            var uri = 'data:application/vnd.ms-excel;base64,';
            var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'; 
            var base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) };
            var format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }); };

            htmls = $(".pvtRendererArea").html();

            var ctx = { worksheet : 'Worksheet', table : htmls };

            var link = document.createElement("a");
            link.download = "datos.xls";
            link.href = uri + base64(format(template, ctx));
            link.click();
        });
        
    </script>
    
@endsection