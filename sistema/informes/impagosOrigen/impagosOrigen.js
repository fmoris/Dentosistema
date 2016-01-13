dentosys.controller('impagosOrigen', function($scope, $http, toaster, $window, $routeParams, $location, $route, $anchorScroll) {

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
        $scope.informeDetalle.nombreOrigen = $routeParams.nombre;
    }

    $scope.imprimirImpagosOrigen = function() {
        $location.path('/impagosOrigen').search({
            origen: $scope.origen.id,
            nombre: $("#listaOrigen :selected").text()
        });
    }

    $scope.obtenerOrigenes = function() {
        $http.get('sistema/pagos/listaOrigen.php')
            .success(function(origen) {
                $scope.listaOrigenes = origen;
            })
    }
    $scope.obtenerOrigenes();

    $scope.envioOrigen = function() {
        //$location.path('/informeTrabajoOrigen').search({param: $scope.origen.id});
        $http.post('sistema/informes/impagosOrigen.php', $scope.informeDetalle)
            .success(function(data, status) {
                $scope.trabajos = data;               
            })
    }
    $scope.envioOrigen();

    $scope.vacio = function(data) {
        if (data.length < 1) {
            return true;
        } else {
            return false;
        }
    }
    $scope.showFolio = true;

    $scope.imprimir = function() {
        window.print();
    }

    $scope.irVista = function(data) {
        var old = $location.hash();
        $location.hash(data);
        $anchorScroll();
        $location.hash(old);
    }

    $scope.returnDate = function(dateString) {
        var regex = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/;
        var dateArray = regex.exec(dateString);
        var dateObject = new Date(
            (+dateArray[1]), (+dateArray[2]) - 1, // Careful, month starts at 0!
            (+dateArray[3])
        );
        return dateObject;
    }   


});