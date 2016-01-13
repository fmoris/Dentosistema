 dentosys.controller('buscaOrdenes', function($scope, $http, toaster, $window, $filter, $q, ngTableParams, $location, $route) {

     switch (localStorage.getItem("permiso")) {
         case '1':
             $location.path('/buscaOrdenesOdontologo');
             break;
         case '2':
             $location.path('/buscaOrdenesOrigen');
             break;
         case '99':
             $location.path('/buscaOrdenesAdmin');
             break;
         default:
              $('#loginModal').modal('show');

     }



 });