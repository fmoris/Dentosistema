dentosys.controller('reordenarLabores', function($scope, $http, toaster, $window, $routeParams, $location, $route, $anchorScroll) {
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
    
     $scope.obtenerLabores = function(){
         $http.get('sistema/aranceles/detalleLabores.php')
            .success(function(data) {
                $scope.etapas = data;
         })
     }
      $scope.obtenerLabores();
     
     
     $scope.obtenerEtapas = function(){
         $http.get('sistema/aranceles/listaEtapas.php')
         .success(function(datosDeLaRespuesta) {
                 $scope.listaEtapas = datosDeLaRespuesta
             })
     }
     $scope.obtenerEtapas();
     
     $scope.editar = function(data){
         data.editar = !data.editar;
     }
        
     $scope.irVista = function(data){
         var old = $location.hash();
         $location.hash(data);
         $anchorScroll();
         $location.hash(old);
     }

    
    // GUARDAR LOS CAMBIOS
     $scope.ordenarLabores = function() {
         //console.log($scope.etapas);
        $http.post('sistema/aranceles/reordenarLabores/reordenarLabores.php', $scope.etapas)
             .success(function(data) {                 
                 toaster.pop('success', "Guardar Protesis Fija", 'Formulario guardado con exito', 5000, 'trustedHtml');
                 $location.path('/aranceles');
             }).error(function(data) {
                 toaster.pop('error', "Error", 'Error al Guardar', null, 'trustedHtml');
             })
     }
 })