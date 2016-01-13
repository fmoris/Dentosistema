 dentosys.controller('nuevoEstadoTrabajo', function($scope, $http, toaster, $window, $routeParams, $location) {
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
         $http.get('sistema/mantencion/estados/estadoTrabajo/nuevoEstado.php', {
             params: {
                 nombre: $scope.estado.nombre
             }
         }).success(function(existe) {
            console.log(existe);             
             if (existe == 1) {
                 toaster.pop('success', "Estado Guardado", 'Estado agregado con exito', null, 'trustedHtml');
                 $location.path('/estados');
                
             } else {
                 toaster.pop('error', "Error", 'Estado ya Existe', null, 'trustedHtml');
             }
         }).error(function(existe) {
             toaster.pop('error', "Error", 'Error al insertar', null, 'trustedHtml');
         })
     }
    
 })