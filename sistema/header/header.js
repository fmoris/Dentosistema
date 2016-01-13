dentosys.controller('headerController', function($scope, $http, toaster, $window, $routeParams, $location, $route,$anchorScroll) {

    $scope.id = localStorage.getItem("id");
    $scope.nombre = localStorage.getItem("nombre");
    $scope.permiso = localStorage.getItem("permiso");

    $scope.$watchCollection("datosLogin", function() {

        $scope.id = localStorage.getItem("id");
        $scope.nombre = localStorage.getItem("nombre");
        $scope.permiso = localStorage.getItem("permiso");
        if (localStorage.getItem("id") == null || localStorage.getItem("nombre") == null || localStorage.getItem("permiso") == null) {
            //toaster.pop('error', "Ingresar Usario", 'Vuelva a Ingresar su Usario y Contraseña', null, 'trustedHtml');
            //$location.path('/');
            $('#loginModal').modal('show');
        }

    })

    $scope.$watch(

        function() {
            return localStorage.getItem("id")
        },
        function() {

            $scope.id = localStorage.getItem("id")
        }

    )
    $scope.$watch(

        function() {
            return localStorage.getItem("nombre")
        },
        function() {

            $scope.nombre = localStorage.getItem("nombre")
        }

    )
    $scope.$watch(

        function() {
            return localStorage.getItem("permiso")
        },
        function() {

            $scope.permiso = localStorage.getItem("permiso")
        }

    )

    $scope.tipoUsuario = function() {

        if ($scope.permiso == "99") {
            return true;
        } else {
            return false;
        }
    }

    $scope.logout = function() {
        localStorage.clear();
        $location.path('/');
    }


    $scope.login = function() {

        $http.get('sistema/usuarios/login/login.php', {
            params: {
                /*correo: $scope.correo,
                password: $scope.password*/
                correo: document.getElementById("usuario").value,
                password: document.getElementById("password").value
            }
        }).success(function(usuario) {
            if (usuario == 0) {
                toaster.pop('error', "Error", 'Datos Ingresados Incorrectamente', null, 'trustedHtml');
            } else {

                localStorage.setItem("id", "" + usuario[0].id);
                localStorage.setItem("nombre", "" + usuario[0].nombre);
                localStorage.setItem("permiso", "" + usuario[0].permiso);

                $scope.id = localStorage.getItem("id");
                $scope.nombre = localStorage.getItem("nombre");
                $scope.permiso = localStorage.getItem("permiso");

                $('#loginModal').modal('hide');
                $route.reload();
                window.location.reload();
                $state.reload();

                /*switch ($scope.permiso) {
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

                }*/
                //$location.path('/buscaOrdenes');
            }
        }).error(function(usuario) {
            toaster.pop('error', "Error", 'Error al buscar usuario', null, 'trustedHtml');
        })
    }
    $scope.irVista = function(data){
         var old = $location.hash();
         $location.hash(data);
         $anchorScroll();
         $location.hash(old);
     }

})