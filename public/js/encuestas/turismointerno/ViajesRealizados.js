angular.module('interno.viajesrealizados', [])

.controller('viajes', function ($scope, serviInterno) {


    $scope.encuesta = {}
    $scope.PrincipalViaje = {};
    
     $scope.optionFecha = {
        calType: 'gregorian',
        format: 'YYYY-MM-DD',
        zIndex: 1060,
        autoClose: true,
        default: null,
        gregorianDic: {
            title: 'Fecha',
            monthsNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            daysNames: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            todayBtn: "Hoy"
        }
    };

    $scope.$watch('id', function () {
          if($scope.id){
              $("body").attr("class", "cbp-spmenu-push charging");
                serviInterno.getDatosViajes($scope.id).then(function (data) {
                   $scope.Datos = data.Enlaces;
                   $scope.Viajes = data.Viajes;
                   $scope.PrincipalViaje.id = data.Principal;
                   $("body").attr("class", "cbp-spmenu-push");
                      
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
                
        })
          }
    })


    $scope.editar = function (es) {
        $scope.errores = null;
        $scope.EstanciaForm.$setPristine();
        $scope.EstanciaForm.$setUntouched();

        $("body").attr("class", "cbp-spmenu-push charging")
        
        serviInterno.getDatoViaje(es.id).then(function (data) {
              $("body").attr("class", "cbp-spmenu-push");
                   $scope.edit = es;
                   $scope.encuesta = data.encuesta;
                   $scope.encuesta.Id = $scope.id;
                   $scope.encuesta.Crear = false;
                   $scope.encuesta.Idv = es.id;
                   if (data.encuesta.Numero != null) {
                       $scope.Total = data.encuesta.Numero - 1
                   }
                   if (data.encuesta.Inicio != null && data.encuesta.Fin != null) {
                       fechal = data.encuesta.Inicio.split('-')
                       fechas = data.encuesta.Fin.split('-')
                       $scope.encuesta.Inicio = new Date(fechal[0], (parseInt(fechal[1]) - 1), fechal[2])
                       $scope.encuesta.Fin = new Date(fechas[0], (parseInt(fechas[1]) - 1), fechas[2])

                   }
                   if (data.encuesta.Estancias == null) {
                       $scope.agregar();
                   }

                   $scope.ver = true;
                      
            }).catch(function () {
                  $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
        })
        



    }

    $scope.agregar = function () {
        $scope.estancia ={};
       
        if ($scope.encuesta.Estancias != null) {
            $scope.encuesta.Estancias.push($scope.estancia)


        } else {
            $scope.encuesta.Estancias = []
            $scope.encuesta.Principal = -1;
            $scope.encuesta.Estancias.push($scope.estancia)
      }

        $scope.EstanciaForm.$setUntouched();
        $scope.EstanciaForm.$setPristine();
        $scope.EstanciaForm.$submitted = false;

    }

    $scope.quitar = function (es) {
        if (es.Municipio == $scope.encuesta.Principal) {

            $scope.encuesta.Principal = 0;
        }

        $scope.encuesta.Estancias.splice($scope.encuesta.Estancias.indexOf(es), 1)
        $scope.EstanciaForm.$setUntouched();
        $scope.EstanciaForm.$setPristine();
        $scope.EstanciaForm.$submitted=false;
    }

    $scope.cambioselectpais= function (es) {

        es.Departamento = null;
        es.Municipio = null;


    }

    $scope.cambioselectdepartamento = function (es) {


        es.Municipio = null;
   

    }

    $scope.cambioselectmunicipio = function (es) {

        for (i = 0; i < $scope.encuesta.Estancias.length; i++) {
            if ($scope.encuesta.Estancias[i] != es) {
                if ($scope.encuesta.Estancias[i].Municipio == es.Municipio) {
                    es.Municipio = null;
                }
            }


        }
    }

    $scope.cambionoches = function (es) {

        if (es.Noches == 0) {
            es.Alojamiento = 15;

        }
    }

    $scope.cambioselectalojamiento = function (es) {

        if (es.Noches == 0) {

            es.Alojamiento = 15;

        } else {
            if (es.Alojamiento == 15) {
                es.Alojamiento = null;
            }
        }
    }

    $scope.verifica = function () {
        $scope.Total = $scope.encuesta.Numero - 1
        if ($scope.encuesta.Numero > 1 && $scope.encuesta.Numero != null) {
            $scope.encuesta.Personas = []
           
        } else {
            if ($scope.encuesta.Numero == 1) {
                $scope.encuesta.Personas = [1]
                $scope.encuesta.Numerohogar = null;
                $scope.encuesta.NumerohogarSinGasto = null;
                $scope.encuesta.Numerotros = null;
             
            } else {
                

                var i = $scope.encuesta.Personas.indexOf(1)
                if (i != -1) {
                    $scope.encuesta.Personas.splice(i, 1)
                }
            }
        }
    }

    $scope.existe = function (k) {

        if ($scope.encuesta.Personas != null) {

            for (i = 0; i < $scope.encuesta.Personas.length; i++){
            
                if ($scope.encuesta.Personas[i] == k ) {

                    return true

                }
            
            
            }
            if (k == 2) {

                $scope.encuesta.Numerohogar = 0;
                $scope.TotalD = $scope.Total

            }
            if(k == 3){
                
                $scope.encuesta.NumerohogarSinGasto = 0;
                $scope.TotalG = $scope.Total
            }

            if (k == 6) {
                $scope.encuesta.Numerotros = 0
                $scope.TotalF = $scope.Total
            }


        }

        return false



    }

    $scope.verificaT = function () {

            $scope.TotalF = $scope.Total - ($scope.encuesta.Numerohogar == null ? 0 : $scope.encuesta.Numerohogar ) - ($scope.encuesta.NumerohogarSinGasto == null ? 0 : $scope.encuesta.NumerohogarSinGasto ) 

      
            $scope.TotalD = $scope.Total  - ($scope.encuesta.Numerotros == null ? 0 : $scope.encuesta.Numerotros ) - ($scope.encuesta.NumerohogarSinGasto == null ? 0 : $scope.encuesta.NumerohogarSinGasto ) 

            $scope.TotalG = $scope.Total - ($scope.encuesta.Numerotros == null ? 0 : $scope.encuesta.Numerotros ) - ($scope.encuesta.Numerohogar == null ? 0 : $scope.encuesta.Numerohogar ) 
      
    

        

    }

    $scope.guardar = function () {


         if (!$scope.EstanciaForm.$valid) {
             swal("Error", "corrija los errores", "error")
             return
         }

         $scope.errores = null
         $("body").attr("class", "cbp-spmenu-push charging");
         if ($scope.encuesta.Id == null){
             $scope.encuesta.Id = $scope.id;
             $scope.encuesta.Crear = true;
         }
          serviInterno.guardarviaje($scope.encuesta).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success == true) {
                  
                    swal({
                        title: "Realizado",
                        text: "Se ha guardado satisfactoriamente el viaje.",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                        if ($scope.encuesta.Crear == true) {
                            
                                   $scope.$apply(function() {
                                    $scope.Viajes.push(data.viaje);
                                  });
                                     $scope.$apply(function() {
                                        $scope.ver = false;
                                        $scope.encuesta = {};
                                     });
                                    
                                    $scope.errores = null;
                                    $scope.error = null;
                                    $scope.EstanciaForm.$setPristine();
                                    $scope.EstanciaForm.$setUntouched();
                                    $scope.EstanciaForm.$submitted = false;
                               } else {
                                   $scope.edit.fecha_inicio = data.viaje.fecha_inicio;
                                   $scope.edit.fecha_final = data.viaje.fecha_final;
                                     $scope.$apply(function() {
                                    $scope.ver = false;
                                    $scope.encuesta = {};
                                     });
                                    $scope.errores = null;
                                    $scope.error = null;
                                    $scope.EstanciaForm.$setPristine();
                                    $scope.EstanciaForm.$setUntouched();
                                    $scope.EstanciaForm.$submitted = false;

                               }
                               
                           
                    }, 1000);
    
                
                } else {
                    swal("Error", "Por favor corrija los errores", "error");
                    $scope.errores = data.errores;
                }
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            })



 
    }

    $scope.eliminar = function (es) {


        swal({
            title: "¿Estas seguro que desea eliminar el viaje ?",
            text: "No será capaz de recuperar esta información!",
            type: "warning", showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Eliminar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {

          serviInterno.eliminarviaje(es).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success == true) {
                $scope.Viajes.splice($scope.Viajes.indexOf(es), 1);
                 swal("Exito", "Se realizó la operación exitosamente", "success");
                } else {
                    swal("Error", "Por favor corrija los errores", "error");
                    $scope.errores = data.errores;
                }
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            })

               


            } else {
                swal("Cancelado", "Ha cancelado la eliminación", "error");
            }
        });

    }

    $scope.cancelar = function () {
            $scope.ver = false;
            $scope.encuesta = {};
            $scope.errores = null;
            $scope.error = null;
            $scope.EstanciaForm.$setPristine();
            $scope.EstanciaForm.$setUntouched();
            $scope.EstanciaForm.$submitted = false;
                                
    }

    $scope.clearForm = function () {
        $scope.errores = null;
        $scope.error = null;
        $scope.EstanciaForm.$setPristine();
        $scope.EstanciaForm.$setUntouched();
        $scope.EstanciaForm.$submitted = false;

    }

    $scope.siguiente = function () {

        $scope.error = null
        if ($scope.PrincipalViaje.id == null) {
            swal("Error", "corrija los errores", "error")
            $scope.error = "Debe seleccionar un viaje como principal";
            return
        }

       
        $("body").attr("class", "cbp-spmenu-push charging");
        if ($scope.encuesta.Id == null) {
            $scope.encuesta.Id = $scope.id;
            $scope.encuesta.Crear = true;
        }
        
        $scope.env = {};
        $scope.env.id = $scope.id; 
        $scope.env.principal = $scope.PrincipalViaje.id;

        

        serviInterno.siguienteviaje($scope.env).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success == true) {
                                          swal({
                                   title: "Realizado",
                                   text: "Se ha guardado satisfactoriamente la sección.",
                                   type: "success",
                                   timer: 1000,
                                   showConfirmButton: false
                               });
                               setTimeout(function () {

                                  
                                       window.location.href = "/turismointerno/viajeprincipal/" + $scope.PrincipalViaje.id;
                                  


                                   $("body").attr("class", "cbp-spmenu-push")
                               }, 1000);
              
                } else {
                    swal("Error", "Por favor corrija los errores", "error");
                    $scope.errores = data.errores;
                }
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            })




    }




})

.controller('viaje', function ($scope, serviInterno) {
    
    $scope.optionFecha = {
        calType: 'gregorian',
        format: 'YYYY-MM-DD',
        zIndex: 1060,
        autoClose: true,
        default: null,
        gregorianDic: {
            title: 'Fecha',
            monthsNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            daysNames: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            todayBtn: "Hoy"
        }
    };


    $scope.$watch('id', function () {
          if($scope.id){
              $("body").attr("class", "cbp-spmenu-push charging");
        serviInterno.getDatoViajePrincipal($scope.id).then(function (data) {
              $("body").attr("class", "cbp-spmenu-push");
                   $scope.Datos = data.Enlaces;
                   $scope.encuesta = data.encuesta;
                   $scope.encuesta.Id = $scope.id;
                   if (data.encuesta.Numero != null) {
                       $scope.Total = data.encuesta.Numero - 1
                   }
                   if (data.encuesta.Inicio != null && data.encuesta.Fin != null) {
                       fechal = data.encuesta.Inicio.split('-')
                       fechas = data.encuesta.Fin.split('-')
                       $scope.encuesta.Inicio = new Date(fechal[0], (parseInt(fechal[1]) - 1), fechal[2])
                       $scope.encuesta.Fin = new Date(fechas[0], (parseInt(fechas[1]) - 1), fechas[2])

                   }
                   if (data.encuesta.Estancias == null) {
                       $scope.agregar();
                   }

          
                      
            }).catch(function () {
                  $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
        })
          }
    })

    $scope.quitar = function (es) {
        if (es.Municipio == $scope.encuesta.Principal) {

            $scope.encuesta.Principal = 0;
        }

        $scope.encuesta.Estancias.splice($scope.encuesta.Estancias.indexOf(es), 1)
        $scope.EstanciaForm.$setUntouched();
        $scope.EstanciaForm.$setPristine();
        $scope.EstanciaForm.$submitted=false;
    }

    $scope.cambioselectpais= function (es) {

        es.Departamento = null;
        es.Municipio = null;


    }

    $scope.cambioselectdepartamento = function (es) {


        es.Municipio = null;
   

    }

    $scope.cambioselectmunicipio = function (es) {

        for (i = 0; i < $scope.encuesta.Estancias.length; i++) {
            if ($scope.encuesta.Estancias[i] != es) {
                if ($scope.encuesta.Estancias[i].Municipio == es.Municipio) {
                    es.Municipio = null;
                }
            }


        }
    }

    $scope.cambionoches = function (es) {

        if (es.Noches == 0) {
            es.Alojamiento = 15;

        }
    }

    $scope.cambioselectalojamiento = function (es) {

        if (es.Noches == 0) {

            es.Alojamiento = 15;

        } else {
            if (es.Alojamiento == 15) {
                es.Alojamiento = null;
            }
        }
    }

    $scope.verifica = function () {
        $scope.Total = $scope.encuesta.Numero - 1
        if ($scope.encuesta.Numero > 1 && $scope.encuesta.Numero != null) {
            $scope.encuesta.Personas = []
           
        } else {
            if ($scope.encuesta.Numero == 1) {
                $scope.encuesta.Personas = [1]
                $scope.encuesta.Numerohogar = null;
                $scope.encuesta.NumerohogarSinGasto = null;
                $scope.encuesta.Numerotros = null;
             
            } else {
                

                var i = $scope.encuesta.Personas.indexOf(1)
                if (i != -1) {
                    $scope.encuesta.Personas.splice(i, 1)
                }
            }
        }
    }

    $scope.existe = function (k) {

        if ($scope.encuesta.Personas != null) {

            for (i = 0; i < $scope.encuesta.Personas.length; i++){
            
                if ($scope.encuesta.Personas[i] == k ) {

                    return true

                }
            
            
            }
            if (k == 2) {

                $scope.encuesta.Numerohogar = 0;
                $scope.TotalD = $scope.Total

            }
            if(k == 3){
                
                $scope.encuesta.NumerohogarSinGasto = 0;
                $scope.TotalG = $scope.Total
            }

            if (k == 6) {
                $scope.encuesta.Numerotros = 0
                $scope.TotalF = $scope.Total
            }


        }

        return false



    }

    $scope.verificaT = function () {

            $scope.TotalF = $scope.Total - ($scope.encuesta.Numerohogar == null ? 0 : $scope.encuesta.Numerohogar ) - ($scope.encuesta.NumerohogarSinGasto == null ? 0 : $scope.encuesta.NumerohogarSinGasto ) 

      
            $scope.TotalD = $scope.Total  - ($scope.encuesta.Numerotros == null ? 0 : $scope.encuesta.Numerotros ) - ($scope.encuesta.NumerohogarSinGasto == null ? 0 : $scope.encuesta.NumerohogarSinGasto ) 

            $scope.TotalG = $scope.Total - ($scope.encuesta.Numerotros == null ? 0 : $scope.encuesta.Numerotros ) - ($scope.encuesta.Numerohogar == null ? 0 : $scope.encuesta.Numerohogar ) 
      
    

        

    }

    $scope.siguiente = function () {


         if (!$scope.EstanciaForm.$valid) {
             swal("Error", "corrija los errores", "error")
             return
         }

         $scope.errores = null
         $("body").attr("class", "cbp-spmenu-push charging");
        
       
          serviInterno.guardarviajePrincipal($scope.encuesta).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success == true) {
                  
                    swal({
                        title: "Realizado",
                        text: "Se ha guardado satisfactoriamente el viaje.",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                        
                            if (data.Sw == 1) {
                                       window.location.href = "/turismointerno/actividadesrealizadas/" + $scope.encuesta.Id;
                                   } else {
                                       window.location.href = "/turismointerno/transporte/" + $scope.encuesta.Id;
                                   }

                               
                           
                    }, 1000);
    
                
                } else {
                    swal("Error", "Por favor corrija los errores", "error");
                    $scope.errores = data.errores;
                }
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            })



 
    }


  



});