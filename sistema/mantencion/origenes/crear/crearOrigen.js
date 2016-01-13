 dentosys.controller('crearOrigen', function($scope, $http, toaster, $window, $location) {

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


     $scope.envio = function() {
         $http.post('sistema/mantencion/origenes/crear/crearOrigen.php', $scope.origen)
             .success(function(data, status) {
                 if (data == 1) {
                     toaster.pop('success', "Guardar Origen", 'Formulario guardado con exito', 5000, 'trustedHtml');
                     $location.path('/mantencion');
                 } else {
                     toaster.pop('error', "Error", 'Error al Guardar', 5000, 'trustedHtml');
                 }
             }).error(function(data) {
                 toaster.pop('error', "Error", 'Error al Guardar', null, 'trustedHtml');
             })
     }

 })