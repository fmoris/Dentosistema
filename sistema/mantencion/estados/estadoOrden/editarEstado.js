 dentosys.controller('editarEstadoOrden', function($scope, $http, toaster, $window, $routeParams, $location) {

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
        $scope.estado = {};

     $scope.obtenerEstadoOrden = function() {
         $http.get('sistema/mantencion/estados/estadoOrden/listaEstado.php')
             .success(function(ejecutores) {
                 $scope.listaEstadoOrden = ejecutores;
             })
     }

     $scope.nombreOrden = function(){
        var estado = document.getElementById('listaOrden')[document.getElementById('listaOrden').selectedIndex].innerHTML;
        $scope.estado.nombre = estado;
     }

     $scope.envio = function() {        
        $http.get('sistema/mantencion/estados/estadoOrden/editarEstado.php', {
             params: {
                 nombre: $scope.estado.nombre,
                 id: $scope.listaestado
             }
         }).success(function(existe) {
             console.log(existe);
             if (existe == 1) {
                 toaster.pop('success', "Estado Guardado", 'Estado editado con exito', null, 'trustedHtml');
                 $location.path('/estados');
             } else {
                 toaster.pop('error', "Error", 'Estado nombre ya existe', null, 'trustedHtml');
             }
         }).error(function(existe) {
             toaster.pop('error', "Error", 'Error al editar', null, 'trustedHtml');
         })
     }
 })