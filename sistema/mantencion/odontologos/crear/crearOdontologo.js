 dentosys.controller('crearOdontologo', function($scope, $http, toaster, $window, $location) {

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
         $http.get('sistema/mantencion/odontologos/crear/verificaCorreoOdontologo.php', {
             params: {
                 correo: $scope.odontologo.correo
             }
         }).success(function(existe) {
             $scope.existe = existe[0];
             if ($scope.existe == 0) {
                 /* toaster.pop('success', "Email valido", 'Email valido', null, 'trustedHtml');*/
                 console.log($scope.odontologo);
                 $http.post('sistema/mantencion/odontologos/crear/crearOdontologo.php', $scope.odontologo)
                     .success(function(data) {
                         /*$http.post('sistema/usuarios/creacion/Odontologo/crearOdontologoMail.php', $scope.odontologo)
                             .success(function(data) {
                                 console.log(data);
                                 if (data == 1) {
                                     toaster.pop('success', "Correo Enviado", 'El correo a sido enviado correctamente', 5000, 'trustedHtml');
                                 } else {
                                     toaster.pop('error', "Error al Enviar Correo", 'El correo no a sido enviado', null, 'trustedHtml');
                                 }
                             })*/
                         if (data == 1) {
                             toaster.pop('success', "Guardar Odontologo", 'Formulario guardado con exito', 5000, 'trustedHtml');
                             $location.path('/mantencion');
                         } else {
                             toaster.pop('error', "Error", 'Error al Guardar', 5000, 'trustedHtml');
                         }
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