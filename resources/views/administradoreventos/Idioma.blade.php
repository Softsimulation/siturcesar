
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

@section('app', 'ng-app="eventosApp"')

@section('controller','ng-controller="eventosIdiomaController"')

@section('titulo','Eventos')
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
<div class="alert alert-danger" ng-if="errores != null">
    <label><b>Errores:</b></label>
    <br />
    <div ng-repeat="error in errores" ng-if="error.length>0">
        -@{{error[0]}}
    </div>
</div>
<fieldset>
    <legend>Información básica</legend>
    <div class="alert alert-info">
        <p>Los campos marcados con asterisco (*) son obligatorios.</p>
    </div>
    <form novalidate role="form" name="editarIdiomaForm">
        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <div class="form-group" ng-class="{'has-error': (editarIdiomaForm.$submitted || editarIdiomaForm.nombre.$touched) && editarIdiomaForm.nombre.$error.required}">
                    <label for="nombre"><span class="asterisk">*</span> Nombre</label>
                    <input ng-model="evento.datosGenerales.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del evento (Máximo 150 caracteres)"/>
                    
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                    <label for="edicion">Edición</label>
                    <input ng-model="evento.datosGenerales.edicion" type="text" name="edicion" id="edicion" class="form-control" placeholder="Máximo 50 caracteres."/>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12">
                <div class="form-group" ng-class="{'has-error': (editarIdiomaForm.$submitted || editarIdiomaForm.descripcion.$touched) && editarIdiomaForm.descripcion.$error.required}">
                    <label for="descripcion"><span class="asterisk">*</span> Descripción</label>
                    <textarea style="resize: none;" ng-model="evento.datosGenerales.descripcion" rows="5" required name="descripcion" id="descripcion" class="form-control" placeholder="Descripción del evento (De 100 a 1,000 caracteres)"></textarea>
                   
                </div>
            </div>
            <div class="col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="horario">Horario</label>
                    <input ng-model="evento.datosGenerales.horario" type="text" name="horario" id="horario" class="form-control" placeholder="Máximo 255 caracteres."/>
                </div>
            </div>
            <div class="col-xs-12 text-center">
                <hr/>
                <button type="submit" ng-click="guardarDatosGenerales()" class="btn btn-lg btn-success">Guardar</button>
                <a href="{{asset('/administradoreventos')}}" class="btn btn-lg btn-default">Cancelar</a>
            </div>
        </div>
        
    </form>
</fieldset>

        
@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
<script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
<script src="{{asset('/js/administrador/eventos/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/eventos/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/eventos/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/eventos/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/eventos/services.js')}}"></script>
<script src="{{asset('/js/administrador/eventos/app.js')}}"></script>
@endsection
