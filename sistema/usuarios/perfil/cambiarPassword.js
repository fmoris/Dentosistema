 dentosys.controller('cambiarPassword', function($scope, $http, toaster, $window, $location) {

     //cambia pagina depende del tipo de perfil
     switch (localStorage.getItem("permiso")) {
         case '1':
             //$('#loginModal').modal('show');
             break;
         case '2':
             //$('#loginModal').modal('show');
             break;
         case '99':
             break;
         default:
             $('#loginModal').modal('show');
             /*$location.path('/');*/
     }

     $scope.idperfil = localStorage.getItem("id");
     $scope.nombreperfil = localStorage.getItem("nombre");
     $scope.permiso = localStorage.getItem("permiso");

     switch ($scope.permiso * 1) {
         case 1:
             $scope.cargoperfil = "Odontologo"
             break;
         case 2:
             $scope.cargoperfil = "Origen"
             break;
         case 99:
             $scope.cargoperfil = "Administrador"
             break;

     }

     $scope.validaPassword = function() {
         $scope.datos = {};
         $scope.datos.password = $scope.perfil.oldpassword;
         $scope.datos.idperfil = localStorage.getItem("id");
         $scope.datos.permiso = localStorage.getItem("permiso");
         $http.post('sistema/usuarios/perfil/validaPassword.php', $scope.datos)
             .success(function(existe) {
                 $scope.existe = existe;
                 if ($scope.existe == 1) {
                     toaster.pop('success', "Contraseña Valida", 'Contraseña Valida', null, 'trustedHtml');
                     $("#pass1").prop('readonly', false);
                     $("#pass2").prop('readonly', false);
                     $("#password").prop('readonly', true);
                 } else {
                     toaster.pop('error', "Error", 'Contraseña invalida', null, 'trustedHtml');
                     document.getElementById("pass1").value = "";
                     document.getElementById("pass2").value = "";
                     $("#pass1").prop('readonly', true);
                     $("#pass2").prop('readonly', true);
                 }
             }).error(function(existe) {
                 toaster.pop('error', "Error", 'No se a podido validar, intentelo más tarde', null, 'trustedHtml');
             })
     }

     $scope.nuevoPassword = function() {
         if ($scope.perfil.pass1 == $scope.perfil.pass2) {
             $scope.datos = {};
             $scope.datos.password = $scope.perfil.pass1;
             $scope.datos.idperfil = localStorage.getItem("id");
             $scope.datos.permiso = localStorage.getItem("permiso");
             $http.post('sistema/usuarios/perfil/modificaPassword.php', $scope.datos)
                 .success(function(respuesta) {
                     if (respuesta != "error") {
                         $http.post('sistema/usuarios/perfil/obtieneDatosPerfil.php', $scope.datos)
                             .success(function(datosusuario) {
                                 $scope.datos = {};
                                 $scope.datos.password = $scope.perfil.pass1;
                                 $scope.datos.nombre = localStorage.getItem("nombre");
                                 $scope.datos.correo = datosusuario.correo;
                                 toaster.pop('success', "Contraseña Guardada Con Exito", 'Nueva Contraseña Guardada', null, 'trustedHtml');
                                 $http.post('sistema/usuarios/perfil/cambiarPasswordCorreo.php', $scope.datos)
                                     .success(function(data) {
                                         toaster.pop('success', "Correo Enviado", 'El correo a sido enviado correctamente', 5000, 'trustedHtml');
                                         $location.path('/perfil');
                                     })
                             }).error(function(datosusuario) {
                                 toaster.pop('error', "Error al enviar datos", 'Porfavor Intente mas tarde', null, 'trustedHtml');
                             })
                     } else {
                         toaster.pop('error', "Error al enviar datos", 'Porfavor Intente mas tarde', null, 'trustedHtml');
                     }
                 })
         } else {
             toaster.pop('error', "Las contraseñas no coinciden", 'Vuelva a Ingresar contraseñas', null, 'trustedHtml');
         }
     }

 })