dentosys.controller('editarEjecutores', function($scope, $http, toaster, $window, $routeParams, $location) {

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

    $scope.obtenerEjecutores = function() {
        $http.get('sistema/mantencion/ejecutores/editar/listaEjecutores.php')
            .success(function(ejecutores) {
                $scope.listaEjecutor = ejecutores;               
            })           
    }
    $scope.obtenerEjecutores();

    $scope.editarEjecutor = function() {        
         $http.post('sistema/mantencion/ejecutores/editar/editarEjecutores.php', $scope.ejecutor)
             .success(function(data, response) {
                 if (data == 1) {
                     toaster.pop('success', "Editar Ejecutor", 'Formulario editado con exito', 5000, 'trustedHtml');
                     $location.path('/mantencion');
                 } else {                     
                         toaster.pop('error', "Error", 'Error al Guardar', null, 'trustedHtml');                     
                 }
             }).error(function(data) {
                 toaster.pop('error', "Error al Comunicarse con el servidor", 'Error al Guardar', null, 'trustedHtml');
             })
     }
})