angular.module('interno.gastos', [] )

.controller('gastos', function ($scope, $http, $window, serviInterno) {
    
    
    $scope.porcentajeGastoRubros = [];
    
    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging")
        serviInterno.getDataGastos($scope.id).then(function (data) {
            $scope.encuesta = data.encuesta;
            $scope.divisas = data.divisas;
            $scope.financiadores = data.financiadores;
            $scope.opcionesLugares = data.opcionesLugares;
            $scope.serviciosPaquetes = data.serviciosPaquetes;
            $scope.TipoProveedorPaquete = data.TipoProveedorPaquete;
            
            $scope.verNombreEmpresa  =  data.encuesta.empresaTransporte ? true : false;
            
            for(var i=0; i< $scope.encuesta.rubros.length ;i++){
                if($scope.encuesta.rubros[i].id==8){
                    $scope.rubroAlquilerVehiculo = $scope.encuesta.rubros[i];
                    $scope.changeRubros($scope.encuesta.rubros[i]); break;
                }
            }
            
            for(var i=0; i< $scope.encuesta.gastosServicosPaquetes.length ;i++){
               
               for (var j = 0; j < $scope.serviciosPaquetes.length; j++){
                    if ($scope.encuesta.gastosServicosPaquetes[i].servicio_paquete_id == $scope.serviciosPaquetes[j].id) { 
                        $scope.encuesta.gastosServicosPaquetes[i].nombre = $scope.serviciosPaquetes[j].nombre;
                        break;
                    }
                }
                
            }
            
            for(var i=0; i< $scope.encuesta.porcentajeGastoRubros.length ;i++){
                
                for (var j = 0; j < $scope.encuesta.rubros.length; j++){
                    if ($scope.encuesta.porcentajeGastoRubros[i].rubro_interno_id == $scope.encuesta.rubros[j].id) { 
                        $scope.encuesta.porcentajeGastoRubros[i].nombre = $scope.encuesta.rubros[j].nombre;
                        break;
                    }
                }

            }
            
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function () {
            swal("Error", "Error en la carga, por favor recarga la página", "error");
        });
    });

    $scope.guardar = function () {
        
        if (!$scope.GastoForm.$valid || $scope.encuesta.financiadores.length==0) {
            swal("Error", "Formulario incompleto corrige los errores", "error")
            return;
        }
        
        var data = angular.copy($scope.encuesta);
        data.id = $scope.id;
        data.rubros = [];
        
        for (var i = 0; i < $scope.encuesta.rubros.length; i++) {
            if($scope.encuesta.rubros[i].viajes_gastos_internos.length>0){
                
                var rubro = $scope.encuesta.rubros[i];
                
                if($scope.encuesta.noRealiceGastos){
                    if( rubro.viajes_gastos_internos[0].gastos_realizados_otros ){
                            data.rubros.push({
                                rubros_id : rubro.id,
                                gastos_realizados_otros : rubro.viajes_gastos_internos[0].gastos_realizados_otros
                            });  
                    }
                }
                else{
                        if( (rubro.viajes_gastos_internos[0].valor || rubro.viajes_gastos_internos[0].divisa_id) && rubro.viajes_gastos_internos[0].personas_cubrio ){
                            data.rubros.push({
                                rubros_id : rubro.id,
                                valor : rubro.viajes_gastos_internos[0].valor,
                                divisa_id : rubro.viajes_gastos_internos[0].divisa_id,
                                personas_cubrio : rubro.viajes_gastos_internos[0].personas_cubrio,
                                gastos_realizados_otros : rubro.viajes_gastos_internos[0].gastos_realizados_otros,
                                otro : rubro.viajes_gastos_internos[0].otro,
                                alquila_vehiculo_id : rubro.id==8 ? rubro.viajes_gastos_internos[0].alquila_vehiculo_id : null,
                            });  
                        }
                        else if(rubro.viajes_gastos_internos[0].gastos_realizados_otros){
                            data.rubros.push({
                                rubros_id : rubro.id,
                                gastos_realizados_otros : rubro.viajes_gastos_internos[0].gastos_realizados_otros
                            });  
                        }
                }
                
            }
        } 
        
        if(data.rubros.length==0 && !data.noRealiceGastos){
            swal("Error", "Debe llenar por lo menos un gasto, de lo contrario marque no realice ningun gasto.", 'info'); return;
        }
        
        for (var i = 0; i < $scope.encuesta.porcentajeGastoRubros.length; i++){
            if( ($scope.encuesta.porcentajeGastoRubros[i].dentro+$scope.encuesta.porcentajeGastoRubros[i].fuera) != 100 ){
                swal("Error", "La suma de los porcentajes gastados debe ser igual a 100%.", 'info'); return;
            }
        }
        for (var i = 0; i < $scope.encuesta.gastosServicosPaquetes.length; i++){
            if( ($scope.encuesta.gastosServicosPaquetes[i].dentro+$scope.encuesta.gastosServicosPaquetes[i].fuera) != 100 ){
                swal("Error", "La suma de los porcentajes gastados debe ser igual a 100%.", 'info'); return;
            }
        }
        
        $("body").attr("class", "cbp-spmenu-push charging");
        
        serviInterno.guardarGastos(data).then(function (data) {
            
            if(data.success == true) {

                 swal({
                     title: "Realizado",
                     text: "Se ha guardado satisfactoriamente la sección.",
                     type: "success",
                     timer: 1000,
                     showConfirmButton: false
                 });
                 setTimeout(function () {
                    window.location.href = "/turismointerno/fuentesinformacion/" + $scope.id;
                 }, 1000);
                 

            } else {
                 $("body").attr("class", "cbp-spmenu-push")
                 $scope.errores = data.errores;
                 swal("Error", "Error en el formulario, corrijalos", "error")
            }
             
             $("body").attr("class", "cbp-spmenu-push");
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la página", "error");
        })
        
        

    }
    
    
    $scope.changeServiciosPaquetes = function(s){
        if(s.id==9 || s.id==10 || s.id==11 ){
            if( $scope.encuesta.serviciosPaquetes.indexOf(s.id)!=-1 ){
               $scope.encuesta.gastosServicosPaquetes.push( { servicio_paquete_id:s.id, nombre: s.nombre} );
            }
            else{ 
                for(var i=0; i<$scope.encuesta.gastosServicosPaquetes.length;i++){
                    if( $scope.encuesta.gastosServicosPaquetes[i].servicio_paquete_id==s.id ){ 
                        $scope.encuesta.gastosServicosPaquetes.splice(i,1); break; 
                    }
                }
            }
        }
    }
  
    
    $scope.changeRubros = function(rb){
        
        
        if( rb.id==8 && rb.viajes_gastos_internos.length>0 ){
            $scope.verAlquilerVehiculo = ((rb.viajes_gastos_internos[0].valor || rb.viajes_gastos_internos[0].divisa_id) && rb.viajes_gastos_internos[0].personas_cubrio);
        }
        
        else if( rb.id==6 && rb.viajes_gastos_internos.length>0 ){
            $scope.verNombreEmpresa = ((rb.viajes_gastos_internos[0].valor || rb.viajes_gastos_internos[0].divisa_id) && rb.viajes_gastos_internos[0].personas_cubrio);
        }
        
        else if( (rb.id==12 || rb.id==13 || rb.id==14 || rb.id==15 || rb.id==16 || rb.id==17 || rb.id==18) && rb.viajes_gastos_internos.length>0 ){
            
            var sw = null;
            for(var i=0; i<$scope.encuesta.porcentajeGastoRubros.length;i++){
                if($scope.encuesta.porcentajeGastoRubros[i].rubro_interno_id==rb.id){ sw = i; break; }
            }
            
            if( ((rb.viajes_gastos_internos[0].valor || rb.viajes_gastos_internos[0].divisa_id) && rb.viajes_gastos_internos[0].personas_cubrio) ){
                if(sw==null){  
                    $scope.encuesta.porcentajeGastoRubros.push( { rubro_interno_id : rb.id, nombre : rb.nombre } ); 
                }
            }
            else{
                if(sw!=null){  $scope.encuesta.porcentajeGastoRubros.splice(sw,1); }
            }
        }
        
        return;
    }
    
    
    $scope.getNombreServicio =  function(id ){
        for (var i = 0; i < $scope.serviciosPaquetes.length; i++){
            if ($scope.serviciosPaquetes[i].servicio_paquete_id == id) { return $scope.serviciosPaquetes[i].nombre; }
        }
        return ;
    }
    
    $scope.changeNorealiceGastos = function(){
        if($scope.encuesta.noRealiceGastos==1){
            for(var i=0; i<$scope.encuesta.rubros.length; i++){
                $scope.encuesta.rubros[i].viajes_gastos_internos[0] = {};
            }
            $scope.encuesta.gastosServicosPaquetes = [];
            $scope.encuesta.porcentajeGastoRubros = [];
            $scope.verNombreEmpresa = false;
            $scope.empresaTransporte = null;
        }
    }
    
    
    $scope.clearDataViaje = function(){
        $scope.encuesta.gastosServicosPaquetes = [];
    }
    
})