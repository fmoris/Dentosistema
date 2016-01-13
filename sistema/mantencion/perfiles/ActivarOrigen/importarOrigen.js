 dentosys.controller('importarOrigen', function($scope, $http, toaster, $window, $routeParams, $location) {

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
     
     $scope.listaOdontologos = function(){
        $http.get('sistema/mantencion/perfiles/ActivarOrigen/listaOrigen.php')
        .success(function(origenes){
            $scope.listaOrigen = origenes;           
        })
     }
     $scope.listaOdontologos();
     
     $scope.envio = function() {
         $http.get('sistema/usuarios/creacion/verificaCorreo.php', {
             params: {
                 rut: $scope.origen.correo
             }

         }).success(function(existe) {
             $scope.existe = existe[0];
             if ($scope.existe == 0) {
                 toaster.pop('success', "Email valido", 'Email valido', null, 'trustedHtml');
                 $scope.origen.tipo = 2;                 
                 $http.post('sistema/usuarios/creacion/guardaOrigen.php', $scope.origen)
                     .success(function(data, status) {
                         $location.path('/registro');
                         toaster.pop('success', "Guardar Origen", 'Formulario guardado con exito', 5000, 'trustedHtml');
                     }).error(function(data) {
                         toaster.pop('error', "Error", 'Error al Guardar', null, 'trustedHtml');
                     })
             } else {

                 toaster.pop('error', "Error", 'Email ya Existe', null, 'trustedHtml');

             }

         }).error(function(existe) {

             toaster.pop('error', "Error", 'Error al buscar', null, 'trustedHtml');

         })

     }

 })