 dentosys.controller('crearOdontologo', function($scope, $http, toaster, $window, $location) {

     switch (localStorage.getItem("permiso")) {
         case '1':
             $location.path('/buscaOrdenes');
             break;
         case '2':
             $location.path('/buscaOrdenesOrigen');
             break;
         case '99':
             $location.path('/nuevoOdontologo');
             break;
         default:
             $location.path('/');

     }

     $scope.envio = function() {
         $http.get('/dentosistema/sistema/usuarios/creacion/verificaCorreo.php', {
             params: {
                 rut: $scope.odontologo.correo
             }
         }).success(function(existe) {
             $scope.existe = existe[0];
             if ($scope.existe == 0) {
                 toaster.pop('success', "Email valido", 'Email valido', null, 'trustedHtml');
                 $scope.odontologo.tipo = 1;
                 $http.post('/dentosistema/sistema/usuarios/creacion/Odontologo/guardaOdontologo.php', $scope.odontologo)
                     .success(function(data, status) {
                         $location.path('/nuevoOdontologo');
                         toaster.pop('success', "Guardar Odontologo", 'Formulario guardado con exito', 5000, 'trustedHtml');
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