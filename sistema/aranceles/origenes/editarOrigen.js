 dentosys.controller('editarOrigen', function($scope, $http, toaster, $window, $routeParams, $location, $route, $anchorScroll) {
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
     $scope.origen = {};
     $scope.origen.origen = {};
     $scope.origen.labor = {};
     $scope.etapas = {};
     $scope.labores = {};

     $scope.listaLabores = function(idOrigen) {
         $http.get('sistema/aranceles/precioPorLabor.php', {
             params: {
                 origen: idOrigen
             }
         }).success(function(datosDeLaRespuesta) {
             $scope.origen.datos = datosDeLaRespuesta;
             $scope.origen.nombre = $scope.origen.origen.nombre; 
             //console.log($scope.origen.datos);
         })
     }
     $scope.listaLabores(0);

     $scope.listaOrigen = function() {
         $http.get('sistema/aranceles/listaOrigen.php')
             .success(function(datosDeLaRespuesta) {
                 $scope.origenes = datosDeLaRespuesta;
             })
     }
     $scope.listaOrigen();

     $scope.editarOrigen = function() {
         console.log("asdsadsad");
         $http.post('sistema/aranceles/origenes/editarOrigen.php', $scope.origen)
             .success(function(data) {                 
                 toaster.pop('success', "Guardar", 'Formulario guardado con exito', 5000, 'trustedHtml');
                 $location.path('/aranceles');
             }).error(function(data) {
                 toaster.pop('error', "Error", '>Error al Guardar', null, 'trustedHtml');
             })
     }
     
     $scope.mostrar = function(data){
         angular.forEach($scope.origen.datos, function(clasi, key){
                    angular.forEach(clasi.etapas, function(etapa, key2){
                        angular.forEach(etapa.labores, function(labor, key3){
                            labor.activo = data;
                        }) 
                    }) 
          })
         
     }
     
     $scope.nombresPorDefecto = function(){
           angular.forEach($scope.origen.datos, function(clasi, key){
                    angular.forEach(clasi.etapas, function(etapa, key2){
                        angular.forEach(etapa.labores, function(labor, key3){
                            labor.nombreEspecial = labor.nombre;
                        }) 
                    }) 
          })
              
     }
     
     

     $scope.irVista = function(data){
         var old = $location.hash();
         $location.hash(data);
         $anchorScroll();
         $location.hash(old);
     }
 })