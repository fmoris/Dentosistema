dentosys.controller('loginController', function($scope, $http, toaster, $window, $routeParams, $location) {

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
                        $location.path('/');

                }

    $scope.login = function() {
        $http.get('sistema/usuarios/login/login.php', {
            params: {
                correo: $scope.correo,
                password: $scope.password
            }
        }).success(function(usuario) {
            if (usuario == 0) {
                toaster.pop('error', "Error", 'Datos Ingresados Incorrectamente', null, 'trustedHtml');
            } else {                

                localStorage.setItem("id", ""+usuario[0].id); 
                localStorage.setItem("nombre", ""+usuario[0].nombre);
                localStorage.setItem("permiso", ""+usuario[0].permiso);                

                $scope.id =  localStorage.getItem("id");
                $scope.nombre = localStorage.getItem("nombre");
                $scope.permiso = localStorage.getItem("permiso");     
                          
                switch ($scope.permiso) {
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
                        $location.path('/');

                }
                //$location.path('/buscaOrdenes');
            }
        }).error(function(usuario) {
            toaster.pop('error', "Error", 'Error al buscar usuario', null, 'trustedHtml');
        })
    }

})