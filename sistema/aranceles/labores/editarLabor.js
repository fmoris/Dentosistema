dentosys.controller('editarLabor', function($scope, $http, toaster, $window, $routeParams, $location) {
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
     $scope.labor = {};
     $scope.labores = {};

     $scope.obtenerLabores = function(inputData) {
         $http.get('sistema/aranceles/listaLabores.php', {
             params: {
             clasi: inputData}
         }).success(function(datosDeLaRespuesta) {
             $scope.labores = datosDeLaRespuesta;
             //console.log($scope.labores);
         })
     }



     $scope.listaOrigenes = function(idLabor) {
         $http.get('sistema/aranceles/precioPorOrigen.php', {
             params: {
                 labor: idLabor
             }
         }).success(function(datosDeLaRespuesta) {
                 $scope.labor.origenes = datosDeLaRespuesta
             })
     }
     $scope.listaOrigenes();

     $scope.editarLabor = function() {
         console.log("asdsadsad");
         $http.post('sistema/aranceles/labores/editarLabor.php', $scope.labor)
             .success(function(data) {                 
                 toaster.pop('success', "Guardar", 'Formulario guardado con exito', 5000, 'trustedHtml');
                 $location.path('/aranceles');
             }).error(function(data) {
                 toaster.pop('error', "Error", '>Error al Guardar', null, 'trustedHtml');
             })
     }
     $scope.precioBase = function(base){
        angular.forEach($scope.labor.origenes, function(value, key){
            value.precio = base;
            
        })
     }
     $scope.nombreBase = function(base){
        angular.forEach($scope.labor.origenes, function(value, key){
            value.nombre = base;
            
        })
     }
 })