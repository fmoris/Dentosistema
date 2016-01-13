dentosys.controller('Origen', function($scope, $http, toaster, $window, $location) {

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

    

 })