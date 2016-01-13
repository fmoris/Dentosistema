 dentosys.controller('importarOdontologo', function($scope, $http, toaster, $window, $location) {

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
     
     $scope.listaOdontologos = function() {
         $http.get('sistema/mantencion/perfiles/ActivarOdontologo/listaOdontologos.php')
             .success(function(odontologos) {
                 $scope.listaOdontologo = odontologos;
             })
     }
     $scope.listaOdontologos();

     $scope.envio = function() {
         $http.get('sistema/mantencion/odontologos/verificaCorreoOdontologo.php', {
             params: {
                 rut: $scope.odontologo.correo
             }
         }).success(function(existe) {
             $scope.existe = existe[0];
             if ($scope.existe == 0) {
                 toaster.pop('success', "Email valido", 'Email valido', null, 'trustedHtml');
                 $scope.odontologo.tipo = 2;
                 $http.post('sistema/mantencion/perfiles/ActivarOdontologo/guardaOdontologo.php', $scope.odontologo)
                     .success(function(data) {
                         $http.post('sistema/mantencion/perfiles/ActivarOdontologo/ImportarOdontologoMail.php', $scope.odontologo)
                             .success(function(data) {
                                 console.log(data);
                                 if (data == 1) {
                                     toaster.pop('success', "Correo Enviado", 'El correo a sido enviado correctamente', 5000, 'trustedHtml');
                                 } else {
                                     toaster.pop('error', "Error al Enviar Correo", 'El correo no a sido enviado', null, 'trustedHtml');
                                 }
                             })
                         $location.path('/registro');
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