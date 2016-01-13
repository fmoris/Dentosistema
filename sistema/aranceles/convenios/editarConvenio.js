dentosys.controller('editarConvenio', function($scope, $http, toaster, $window, $routeParams, $location) {
	
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
    
$scope.obtenerConvenios = function(){
     $http.get('sistema/aranceles/convenios/listaConvenios.php')
        .success(function(data){
             $scope.listaConvenios = data;          
        })
   
}
$scope.obtenerConvenios();
    
$scope.seleccionaConvenio = function(){
     $http.get('sistema/aranceles/convenios/seleccionaConvenio.php', {
             params: {
                 id: $scope.id
             }
         })
        .success(function(data){
             $scope.convenio = data;  
             
        })
   
}  
})