 dentosys.controller('nuevoEjecutor', function($scope, $http, toaster, $window, $routeParams, $location) {
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

     /// Guardar Formulario
     $scope.crearEjecutor = function() {
         $http.post('sistema/mantencion/ejecutores/crear/guardaEjecutor.php', $scope.ejecutor)
             .success(function(data, response) {
                 if (data == 1) {
                     toaster.pop('success', "Guardar Ejecutor", 'Formulario guardado con exito', 5000, 'trustedHtml');
                     $location.path('/mantencionr');
                 } else {
                     if (data == 0) {
                         toaster.pop('error', "Error", 'Nombre ya Existe', null, 'trustedHtml');
                     } else {
                         toaster.pop('error', "Error", 'Error al Guardar', null, 'trustedHtml');
                     }
                 }
             }).error(function(data) {
                 toaster.pop('error', "Error al Comunicarse con el servidor", 'Error al Guardar', null, 'trustedHtml');
             })
     }
 })