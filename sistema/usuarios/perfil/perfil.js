 dentosys.controller('perfil', function($scope, $http, toaster, $window, $location) {

     switch (localStorage.getItem("permiso")) {
         case '1':
             $location.path('/perfil');
             break;
         case '2':
             $location.path('/perfil');
             break;
         case '99':
             $location.path('/perfil');
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

     $scope.datosusuarios = function() {
         $scope.datos = {};
         $scope.datos.permiso = localStorage.getItem("permiso");
         $scope.datos.idperfil = localStorage.getItem("id");
         $http.post('sistema/usuarios/perfil/obtieneDatosPerfil.php', $scope.datos)
             .success(function(datos) {
                 $scope.perfil = datos;
             })
     }
     $scope.datosusuarios();

     




 })