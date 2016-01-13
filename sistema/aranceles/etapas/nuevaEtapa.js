 dentosys.controller('nuevaEtapa', function($scope, $http, toaster, $window, $routeParams, $location) {

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

     //// obtener informacion de PHP
     $scope.etapa = {};

     $scope.crearEtapa = function() {        
         $http.post('sistema/aranceles/etapas/nuevaEtapa.php', $scope.etapa)
             .success(function(data) {                 
                 toaster.pop('success', "Guardar", 'Formulario guardado con exito', 5000, 'trustedHtml');
                 $location.path('/aranceles');
             }).error(function(data) {
                 toaster.pop('error', "Error", 'Error al guardar, porfavor intente nuevamente', null, 'trustedHtml');
             })
     }
 })