
@extends('layout._AdminLayout')

@section('title', 'Editar idioma')

@section('estilos')
    <style>
        .image-preview-input {
            position: relative;
            overflow: hidden;
            margin: 0px;
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .image-preview-input input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }

        .image-preview-input-title {
            margin-left: 2px;
        }

        .messages {
            color: #FA787E;
        }

        
    </style>
@endsection

@section('TitleSection', 'Editar idioma')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('app', 'ng-app="rutasApp"')

@section('controller','ng-controller="rutasIdiomaController"')

@section('titulo','Rutas turisticas')
@section('subtitulo','Formulario para la modificación de información en otro idioma')

@section('content')
<div class="text-center">
    <div class="alert alert-info">
        <p>Idioma a modificar:</p>
        <h3 style="margin: 0">@{{idioma.nombre}}</h3>
    </div>
    
</div>
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <input type="hidden" ng-model="idIdioma" ng-init="idIdioma={{$idIdioma}}" />
    <div class="col-col-sm-12">
        <a href="{{asset('/administradorrutas')}}">Volver al listado</a>
    </div>
        <!--Información básica-->
        
        <form novalidate role="form" name="editarIdiomaForm">
            <fieldset>
                <legend>Información básica</legend>
                <div class="alert alert-info">
                    <p>Los campos marcados con asterisco (*) son obligatorios.</p>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group" ng-class="{'has-error': (editarIdiomaForm.$submitted || editarIdiomaForm.nombre.$touched) && editarIdiomaForm.nombre.$error.required}">
                            <label for="nombre"><span class="asterisk">*</span> Nombre</label>
                            <input ng-model="ruta.datosGenerales.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre de la ruta (Máximo 150 caracteres)"/>
                            
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group" ng-class="{'has-error': (editarIdiomaForm.$submitted || editarIdiomaForm.descripcion.$touched) && editarIdiomaForm.descripcion.$error.required}">
                            <label for="descripcion"><span class="asterisk">*</span> Descripción</label>
                            <textarea style="resize: none;" ng-model="ruta.datosGenerales.descripcion" rows="5" required name="descripcion" id="descripcion" class="form-control" placeholder="Descripción de la ruta (De 100 a 1,000 caracteres)"></textarea>
                            
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="recomendaciones">Recomendaciones</label>
                            <textarea ng-model="ruta.datosGenerales.recomendacion" style="resize: none;" rows="5" name="recomendaciones" id="recomendaciones" class="form-control" placeholder="De 100 a 1,000 caracteres."></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 text-center">
                        <hr/>
                        <button type="submit" ng-click="guardarDatosGenerales()" class="btn btn-lg btn-success">Guardar</button>
                        <a href="{{asset('/administradoractividades')}}" class="btn btn-lg btn-default">Cancelar</a>
                    </div>
                </div>
            </fieldset>
            
        </form>
@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
<script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/services.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/app.js')}}"></script>
@endsection
