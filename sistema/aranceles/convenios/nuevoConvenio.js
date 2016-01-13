dentosys.controller('nuevoConvenio', function($scope, $http, toaster, $window, $routeParams, $location) {

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

    $scope.listaOrigenes = function() {
        $http.get('sistema/mantencion/perfiles/ActivarOrigen/listaOrigen.php')
            .success(function(origenes) {
                $scope.listaOrigen = origenes;
            }).error(function(origenes) {
                toaster.pop('error', "Error", 'Error al cargar lista de Origenes, porfavor intente nuevamente', null, 'trustedHtml');
            })
    }
    $scope.listaOrigenes();
    $scope.convenio = {};
 /*   $scope.convenio.labores = [];

    $scope.agregarLabor = function() {
        $scope.convenio.labores.push({
            id: 0
        });

    }

    $scope.listaLabores = function(data) {
        $scope.convenio.labores = [];
        $http.get('sistema/aranceles/convenios/listaLabores.php', {
            params: {
                clasi: data
            }
        }).success(function(datosDeLaRespuesta) {
            $scope.labores = datosDeLaRespuesta;
            //console.log($scope.labores);
        }).error(function(origenes) {
            toaster.pop('error', "Error", 'Error al cargar lista de Labores, porfavor intente nuevamente', null, 'trustedHtml');
        })
    }*/


    $scope.envio = function() {
        console.log($scope.convenio);
        $http.post('sistema/aranceles/convenios/nuevoConvenio.php', $scope.convenio)
            .success(function(data) {                
                toaster.pop('success', "Guardar", 'Formulario guardado con exito', 5000, 'trustedHtml');
                $location.path('/aranceles');
            }).error(function(data) {
                toaster.pop('error', "Error", 'Error al guardar, porfavor intente nuevamente', null, 'trustedHtml');
            })

    }
})