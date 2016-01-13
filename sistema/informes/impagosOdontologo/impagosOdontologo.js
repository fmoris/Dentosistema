dentosys.controller('impagosOdontologo', function($scope, $http, toaster, $window, $routeParams, $location, $route,$anchorScroll) {

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

    if (!$routeParams.origen) {

    } else {
        $scope.informeDetalle = {};
        $scope.informeDetalle.id = $routeParams.origen;
        $scope.informeDetalle.nombreOdontologo = $routeParams.nombre;
    }

    $scope.listaOdontologos = function() {
        $http.get('sistema/pagos/listaOdontologos.php')
            .success(function(odontologos) {
                $scope.listaOdontologo = odontologos;
            })
    }
    $scope.listaOdontologos();
    

    $scope.envioOdontologo = function() {        
        $scope.hideFolio = true;
        $http.post('sistema/informes/impagosOdontologo.php', $scope.informeDetalle)
            .success(function(data, status) {
                $scope.trabajos = data;
            })
    }
    $scope.envioOdontologo(); 

    $scope.imprimirImpagosOdontologo = function() {       
        $location.path('/impagosOdontologo').search({
            origen: $scope.odontologo.id,
            nombre: $("#listaOdontologo :selected").text()
        });
    }

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

    $scope.irVista = function(data){
         var old = $location.hash();
         $location.hash(data);
         $anchorScroll();
         $location.hash(old);
     }
});