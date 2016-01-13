dentosys.controller('editarMetales', function($scope, $http, toaster, $window, $routeParams, $location, $route, $anchorScroll) {
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
     //// obtener informacion de PHP
     $scope.etapa = {};
     $scope.etapas ={};
    
     $scope.obtenerMetales = function(){
         $http.get('sistema/aranceles/metales/listaMetales.php')
            .success(function(data) {
                angular.forEach(data, function(value, key){
                value.editar = false;
         });
             $scope.listaMetales = data;
         })
     }
     $scope.editar = function(data){
         data.editar = !data.editar;
     }
       
     
     
     $scope.obtenerMetales();

     $scope.editarMetales = function() {
         //console.log($scope.etapas);
        $http.post('sistema/aranceles/metales/editarMetales.php', $scope.listaMetales)
             .success(function(data) {                 
                 toaster.pop('success', "Guardar Metales", 'Formulario guardado con exito', 5000, 'trustedHtml');
                 $location.path('/aranceles');
             }).error(function(data) {
                 toaster.pop('error', "Error", 'Error al Guardar', null, 'trustedHtml');
             })
     }
     $scope.irVista = function(data){
         var old = $location.hash();
         $location.hash(data);
         $anchorScroll();
         $location.hash(old);
     }
 })