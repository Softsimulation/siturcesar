angular.module('encuestas.datos_encuestado', [])

.controller("crear", ['$scope', 'receptorServi','$filter', function ($scope, receptorServi,$filter) {
    $scope.encuesta = {};
    $scope.departamentod = {};
    
    $scope.fechaActual = "'" + formatDate(new Date()) + "'";
    $scope.optionFecha = {
        calType: 'gregorian',
        format: 'DD/MM/YYYY hh:mm',
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
    
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [day,month,year].join('/');
    }
    
    $scope.$watch('id', function () {
        receptorServi.informacionCrear().then(function (data) {
            $scope.grupos = data.grupos;
            $scope.encuestadores = data.encuestadores;
            $scope.lugares = data.lugar_nacimiento;
            $scope.paises = data.paises;
            $scope.motivos = data.motivos;
            $scope.medicos = data.medicos;
            $scope.departamentos_colombia = data.departamentos;
            $scope.lugares_aplicacion = data.lugares_aplicacion;
        }).catch(function () {
            swal("Error", "No se realizo la solicitud, reinicie la página");
        });
    })

    $scope.otro = function () {
        if ($scope.encuesta.Otro == "") {
            $scope.encuesta.Motivo = null;
        } else {
            $scope.encuesta.Motivo = 18;
        }
    }

    $scope.cambiomotivo = function () {
        if ($scope.encuesta.Motivo != 18) {
            $scope.encuesta.Otro = "";
        }
    }

    $scope.changedepartamento = function () {
        $scope.departamento = "";
        $scope.departamentos = [];
        if ($scope.pais_residencia != null) {
            
            receptorServi.getDepartamento($scope.pais_residencia).then(function (data) {
                $scope.departamentos = data;
            }).catch(function () {
                swal("Error", "No se realizo la solicitud, reinicie la página", "error");
            })
        }
    }

    $scope.changemunicipio = function () {
        $scope.encuesta.Municipio = "";
        $scope.municipios = [];
        if ($scope.departamento != null) {
            
            receptorServi.getMunicipio($scope.departamento).then(function (data) {
                $scope.municipios = data;
            }).catch(function () {
                swal("Error", "No se realizo la solicitud, reinicie la página", "error");
            })
            
        }
    }

    $scope.changemunicipiocolombia = function () {
        $scope.encuesta.Destino = "";
        $scope.municipios_colombia = [];
        if ($scope.departamentod.id != null) {
            
            receptorServi.getMunicipio($scope.departamentod.id).then(function (data) {
                $scope.municipios_colombia = data;
            }).catch(function () {
                swal("Error", "No se realizo la solicitud, reinicie la página", "error");
            })
        }
    }

    $scope.guardar = function () {
        
        if ($scope.DatosForm.$valid) {
            $("body").attr("class", "charging");
            
            // var split1 = $scope.encuesta.fechaAplicacion.split(" ");
            // split1 = split1[0].split("/");
            // var fechaAp = new Date(split1[2], split1[1] - 1, split1[0]);
            // var mes = fechaAp.getMonth() +1;
            // var anio = fechaAp.getFullYear();
            // var encuestador = $filter('filter')($scope.encuestadores, {'id':parseInt($scope.encuesta.Encuestador)}, true);
            // var codigoEncuestador = encuestador[0].codigo;
            // $scope.encuesta.codigo_grupo = anio+'_'+mes+'_'+codigoEncuestador+'_'+$scope.encuesta.codigo_encuesta;
            
            receptorServi.guardarCrearEncuesta($scope.encuesta).then(function (data) {
                $("body").attr("class", "");
                
                if (data.success) {

                    swal({
                        title: "Realizado",
                        text: "Sección guardada exitosamente",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                        if (data.terminada == 1) {
                            window.location = "/turismoreceptor/listadoencuestas";
                        } else {
                            window.location = "/turismoreceptor/seccionestancia/"+data.id;
                        }
                    }, 1000);
                } else {
                    swal("Error", "Hay errores en el formulario corrigelos", "error");
                    $scope.errores = data.errores;
                }
            }).catch(function () {
                $("body").attr("class", "");
                swal("Error", "No se realizo la solicitud, reinicie la página", "error");
            })
        } else {
            swal("Error", "Formulario incompleto corrige los errores", "error");
        }

    }

}])

.controller("editar", ['$scope', 'receptorServi','$filter',function ($scope, receptorServi,$filter) {
    
    $scope.fechaActual = "'" + formatDate(new Date()) + "'";
    $scope.optionFecha = {
        calType: 'gregorian',
        format: 'DD/MM/YYYY hh:mm',
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
    
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [day,month,year].join('/');
    }
    
    $scope.encuesta = {};
    $scope.departamentod = {};
    $scope.$watch("id", function () {

        if ($scope.id != null) {

            $("body").attr("class", "charging");
            
            receptorServi.getDatosEditarDatos($scope.id).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                data.datos = data.datos;
                $scope.departamentos = data.departamentosr;
                $scope.municipios = data.municipiosr;
                $scope.municipios_colombia = data.municipiosd;
                $scope.grupos = data.datos.grupos;
                $scope.encuestadores = data.datos.encuestadores;
                $scope.lugares = data.datos.lugar_nacimiento;
                $scope.paises = data.datos.paises;
                $scope.motivos = data.datos.motivos;
                $scope.medicos = data.datos.medicos;
                $scope.lugares_aplicacion = data.datos.lugares_aplicacion;
                $scope.departamentos_colombia = data.datos.departamentos;
                $scope.encuesta = data.visitante;
                $scope.pais_residencia = data.visitante.Pais;
                $scope.departamento = data.visitante.Departamento;
                $scope.departamentod.id = data.visitante.DepartamentoDestino;
                fechal = data.visitante.Llegada.split('-');
                fechas = data.visitante.Salida.split('-');
                $scope.encuesta.Llegada = new Date(fechal[0], (parseInt(fechal[1]) - 1), fechal[2]);
                $scope.encuesta.Salida = new Date(fechas[0], (parseInt(fechas[1]) - 1), fechas[2]);
                
                if(data.visitante.fechaAplicacion != null){
                    var split1 = data.visitante.fechaAplicacion.split(" ");
                    var split2 = split1[1].split(":");
                    split1 = split1[0].split("-");
                    var fechaAp = new Date(split1[0], split1[1] - 1, split1[2],split2[0],split2[1]);
                    $scope.encuesta.fechaAplicacion = fechaAp;    
                }
                
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            });
        }
    })

    $scope.otro = function () {
        if ($scope.encuesta.Otro == "") {
            $scope.encuesta.Motivo = null;
        } else {
            $scope.encuesta.Motivo = 18;
        }
    }

    $scope.cambiomotivo = function () {
        if ($scope.encuesta.Motivo != 18) {
            $scope.encuesta.Otro = "";
        }
    }

    $scope.changedepartamento = function () {
        $scope.departamento = "";
        $scope.departamentos = [];
        if ($scope.pais_residencia != null) {
            
            receptorServi.getDepartamento($scope.pais_residencia).then(function (data) {
                $scope.departamentos = data;
            }).catch(function () {
                swal("Error", "No se realizo la solicitud, reinicie la página", "error");
            })
        }
    }

    $scope.changemunicipio = function () {
        $scope.encuesta.Municipio = "";
        $scope.municipios = [];
        if ($scope.departamento != null) {
            
            receptorServi.getMunicipio($scope.departamento).then(function (data) {
                $scope.municipios = data;
            }).catch(function () {
                swal("Error", "No se realizo la solicitud, reinicie la página", "error");
            })
            
        }
    }

    $scope.changemunicipiocolombia = function () {
        $scope.encuesta.Destino = "";
        $scope.municipios_colombia = [];
        if ($scope.departamentod.id != null) {
            
            receptorServi.getMunicipio($scope.departamentod.id).then(function (data) {
                $scope.municipios_colombia = data;
            }).catch(function () {
                swal("Error", "No se realizo la solicitud, reinicie la página", "error");
            })
        }
    }

    $scope.guardar = function () {

        if ($scope.DatosForm.$valid) {
            $("body").attr("class", "charging");
            
            //var split1 = $scope.encuesta.fechaAplicacion.split(" ");
            //var hora = split1[1];
            // split1 = split1[0].split("/");
            // var fechaAp = new Date(split1[2], split1[1] - 1, split1[0]);
            // var mes = fechaAp.getMonth() +1;
            // var anio = fechaAp.getFullYear();
            //var encuestador = $filter('filter')($scope.encuestadores, {'id':parseInt($scope.encuesta.Encuestador)}, true);
            //var codigoEncuestador = encuestador[0].codigo;
            //$scope.encuesta.codigo_grupo = anio+'_'+mes+'_'+codigoEncuestador+'_'+$scope.encuesta.codigo_encuesta;
            
            receptorServi.guardarEditarDatos($scope.encuesta).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success) {
                    swal({
                        title: "Realizado",
                        text: "Sección guardada exitosamente",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                        if (data.terminada == 1) {
                            window.location = "/turismoreceptor/listadoencuestas";
                        } else {
                            window.location = "/turismoreceptor/seccionestancia/"+$scope.id;
                        }
                    }, 1000);
                } else {
                    swal("Error", "Hay errores en el formulario corrigelos", "error");
                    $scope.errores = data.errores;
                }  
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            });
        } else {
            swal("Error", "Formulario incompleto corrige los errores", "error");
        }

    }

}])