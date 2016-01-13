 dentosys.controller('pagos', function($scope, $http, toaster, $window, $location) {

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

     $scope.origen = {};
     $scope.origen.id = 0;
     $scope.odontologo = {};
     $scope.odontologo.id = 0;

     $scope.listaOdontologos = function() {
         $http.get('sistema/pagos/listaOdontologos.php')
             .success(function(odontologos) {
                 $scope.listaOdontologo = odontologos;
             })
     }
     $scope.listaOdontologos();
     $scope.listaOrigenes = function() {
         $http.get('sistema/pagos/listaOrigen.php')
             .success(function(origen) {
                 $scope.listaOrigen = origen;
             })
     }
     $scope.listaOrigenes();

     $scope.envioOrigen = function() {
         if ($scope.origen.id != 0) {
             $location.path('/pagarTrabajoOrigen').search({
                 param: $scope.origen.id
             });
         } else {
             toaster.pop('error', "Error", 'Seleccione un Origen', null, 'trustedHtml');
         }
     }
     $scope.envioOdontologo = function() {
         if ($scope.odontologo.id != 0) {
             $location.path('/pagarTrabajoOdontologo').search({
                 param: $scope.odontologo.id
             });
         } else {
             toaster.pop('error', "Error", 'Seleccione un Oodontologo', null, 'trustedHtml');
         }
     }





 });