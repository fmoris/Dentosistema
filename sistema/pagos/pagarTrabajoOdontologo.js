dentosys.controller('pagarTrabajoOdontologo', function($scope, $http, toaster, $window, $filter, $q, ngTableParams, $location, $route, $routeParams) {
    switch (localStorage.getItem("permiso")) {
        case '1':
            $location.path('/perfil');
            break;
        case '2':
            $location.path('/perfil');
            break;
        case '99':
            break;
        default:
            $('#loginModal').modal('show');
            /*$location.path('/');*/
    }

    $scope.descuento = 0;

    if (!$routeParams.param) {

    } else {
        $scope.datos = {};
        $scope.datos.id = $routeParams.param;
    }

    $http.post('sistema/pagos/listaImpagosOdontologo.php', $scope.datos)
        .success(function(data, status) {
            $scope.nombre = data.nombre;
            $scope.data = data.ordenes;
            $scope.tableParams = new ngTableParams({
                page: 1, // show first page
                count: 4, // count per page
                sorting: {
                    Orden: 'asc' // initial sorting
                }
            }, {
                total: $scope.data.length, // length of data
                getData: function($defer, params) { // use build-in angular filter
                    var orderedData = params.sorting ?
                        $filter('orderBy')($scope.data, params.orderBy()) :
                        data;
                    orderedData = params.filter ?
                        $filter('filter')(orderedData, params.filter()) :
                        orderedData;

                    $scope.users = orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());

                    params.total(orderedData.length); // set total for recalc pagination
                    $defer.resolve($scope.users);
                }
            });
        });
    var inArray = Array.prototype.indexOf ?
        function(val, arr) {
            return arr.indexOf(val)
        } :
        function(val, arr) {
            var i = arr.length;
            while (i--) {
                if (arr[i] === val) return i;
            }
            return -1
        };

    $scope.pacientes = function(column) {
        var def = $q.defer(),
            arr = [],
            names = [];
        $scope.data = $scope.data;
        $scope.$watch('data', function() {
            angular.forEach($scope.data, function(item) {
                if (inArray(item.paciente, arr) === -1) {
                    arr.push(item.paciente);
                    names.push({
                        'id': item.paciente,
                        'title': item.paciente
                    });
                }
            });
        });
        def.resolve(names);
        return def;
    };

    $scope.clasificaciones = function(column) {
        var def = $q.defer(),
            arr = [],
            names = [];
        $scope.data = $scope.data;
        $scope.$watch('data', function() {
            angular.forEach($scope.data, function(item) {
                if (inArray(item.clasificacion, arr) === -1) {
                    arr.push(item.clasificacion);
                    names.push({
                        'id': item.clasificacion,
                        'title': item.clasificacion
                    });
                }
            });
        });
        def.resolve(names);
        return def;
    };

    $scope.paga = function(inputData) {
        var outputData = {};
        outputData.idOrden = inputData.orden;
        outputData.clasi = inputData.idclasificacion;
        outputData.fechaPago = $scope.fechaPago;
        outputData.medioPago = $scope.medioPago;
        outputData.observacion = $scope.observacion;
        outputData.descuento = $scope.descuento;
        outputData.totalPago = $window.Math.round(inputData.totalorden - inputData.totalorden * $scope.descuento /100)
        console.log(outputData);
       $http.post('sistema/pagos/pagarTrabajo.php', outputData).success(function(data) {
                 $route.reload();
                 toaster.pop('success', "Guardar", 'Pago guardado con exito', 5000, 'trustedHtml');
             }).error(function(data) {
                 toaster.pop('error', "Error", '>Error al Efectuar el Pago', null, 'trustedHtml');
             })
    }
    $scope.aplicaDescuento = function() {
        $scope.totalPago = $window.Math.round($scope.totalOrdenes - $scope.totalOrdenes * $scope.descuento / 100);
    }
    $scope.pagar = function() {
        if (localStorage.getItem("permiso") == 99) {
            $scope.seleccion = [];
            $scope.totalOrdenes = 0;
            angular.forEach($scope.data, function(value, key) {
                if (value.check == "true") {
                    $scope.seleccion.push(value);
                    $scope.totalOrdenes += value.totalorden * 1;
                    console.log(value.totalorden);


                }
            })
            if ($scope.seleccion.length == 0) {
                toaster.pop('error', "Error", 'Seleccione Ordenes a pagar', null, 'trustedHtml');
                $('#myModal').modal('hide');
            } else {
                $('#myModal').modal('show');
            }
        }
    }
    $scope.confirmar = function() {
        if ($scope.descuento >= 0 && $scope.descuento <= 100) {
            angular.forEach($scope.seleccion, function(value, key) {
                $scope.paga(value);
            })
        } else {
            toaster.pop('error', "Error", 'El Descuento tiene que ser entre 0 y 100', null, 'trustedHtml');
        }


    }



});