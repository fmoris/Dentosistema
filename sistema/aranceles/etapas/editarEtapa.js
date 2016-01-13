dentosys.controller('editarEtapa', function($scope, $http, toaster, $window, $routeParams, $location, $route, $anchorScroll) {
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
    
     $scope.listaEtapas = function(){
         $http.get('sistema/aranceles/etapas/editarEtapas.php')
            .success(function(data) {
                $scope.etapas = data;
         })
     }
     $scope.editar = function(data){
         data.editar = !data.editar;
     }
     $scope.desactivar = function(data){
         angular.forEach(data.labores, function(value, key){
         value.obsoleto = data.obsoleto;
         value.editar = true;
         });
         
     }         
     
     $scope.detalles = function(data){
         data.detalles = !data.detalles;
     }
     $scope.listaEtapas();

     $scope.editarEtapa = function() {
         //console.log($scope.etapas);
        $http.post('sistema/aranceles/etapas/editarEtapa.php', $scope.etapas)
             .success(function(data) {                 
                 toaster.pop('success', "Guardar Protesis Fija", 'Formulario guardado con exito', 5000, 'trustedHtml');
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