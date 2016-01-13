dentosys.controller('imprimirPagosPorFecha', function($scope, $http, toaster, $window, $routeParams, $location, $route, $anchorScroll) {

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

    $scope.returnDatetime = function(dateString) {
        var regex = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/;
        var dateArray = regex.exec(dateString);
        var dateObject = new Date(
            (+dateArray[1]), (+dateArray[2]) - 1, // Careful, month starts at 0!
            (+dateArray[3]), (+dateArray[4]), (+dateArray[5]), // Careful, month starts at 0!
            (+dateArray[6])
        );
        return dateObject;

    }


    if (!$routeParams.inicio) {


    } else {
        $scope.informeDetalle = {};
        $scope.informeDetalle.inicio = $routeParams.inicio;
        $scope.informeDetalle.fin = $routeParams.fin;
    }

    $scope.envioPagosFecha = function() {

        $http.post('sistema/informes/pagosPorDia.php', $scope.informeDetalle)
            .success(function(data, status) {
                $scope.pagosPorDia = data;

                angular.forEach($scope.pagosPorDia.origenes, function(value, key) {
                    angular.forEach(value.odontologos, function(value2, key2) {
                        angular.forEach(value2.protesisFija, function(pFija, key3) {
                            pFija.fechaPago = $scope.returnDatetime(pFija.fechaPago);
                            pFija.entrega = $scope.returnDatetime(pFija.entrega);
                            if (pFija.fechaPago.getTime() > (pFija.entrega.getTime() + 2629740000)) {
                                pFija.atrasado = true;
                            }
                        })
                    })
                })

                angular.forEach($scope.pagosPorDia.origenes, function(value, key) {
                    angular.forEach(value.odontologos, function(value2, key2) {
                        angular.forEach(value2.colados, function(cldo, key3) {
                            cldo.fechaPago = $scope.returnDatetime(cldo.fechaPago);
                            cldo.entrega = $scope.returnDatetime(cldo.entrega);
                            if (cldo.fechaPago.getTime() > (cldo.entrega.getTime() + 2629740000)) {
                                cldo.atrasado = true;
                            }
                        })
                    })
                })

                angular.forEach($scope.pagosPorDia.origenes, function(value, key) {
                    angular.forEach(value.odontologos, function(value2, key2) {
                        angular.forEach(value2.removibles, function(rmble, key3) {
                            rmble.fechaPago = $scope.returnDatetime(rmble.fechaPago);
                            rmble.entrega = $scope.returnDatetime(rmble.entrega);
                            if (rmble.fechaPago.getTime() > (rmble.entrega.getTime() + 2629740000)) {
                                rmble.atrasado = true;
                            }
                        })
                    })
                })


            }) //Success
    }
    $scope.envioPagosFecha();

    $scope.vacio = function(data) {
        if (data.length < 1) {
            return true;
        } else {
            return false;
        }
    }

    $scope.imprimir = function() {
        window.print();
    }

    //----------------Informes fecha---------------------------//



    $scope.imprimirPagosPorFecha = function() {
        $location.path('/imprimirPagosPorFecha').search({
            inicio: $scope.pagos.inicio,
            fin: $scope.pagos.fin
        });
    }
    //----------------------------------------------//
    $scope.irVista = function(data) {
        var old = $location.hash();
        $location.hash(data);
        $anchorScroll();
        $location.hash(old);
    }




});