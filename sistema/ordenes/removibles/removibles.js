 dentosys.controller('removibles' , function($scope, $http, toaster, $window, $routeParams, $location){ 
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
/*FUNCIONALIDAD VISTAS DATOS BASE Y ESPECIFICOS*/
    
     /*$scope.obtenerConvenios = function(){
        $http.get('sistema/ordenes/protesisFija/listaConvenios.php', {
             params: {
                 id: $scope.orden.origen.id
             }
         })
        .success(function(convenios){
            $scope.listaConvenios = convenios;           
        })
     }*/
     
       $scope.obtenerOrigenes = function(){
        $http.get('sistema/ordenes/listaOrigenesActivos.php')
        .success(function(origenes){
            $scope.listaOrigenes = origenes;           
        })
     }
       $scope.obtenerOrigenes();
     
      $scope.obtenerOdontologos = function(){
        $http.get('sistema/ordenes/listaOdontologos.php')
        .success(function(odontologos){
            $scope.listaOdontologos = odontologos;           
        })
     }
       $scope.obtenerOdontologos();
     
       $scope.editarOrden = function(){
        var orden = document.getElementById("idOrden").value;         
        /*$location.path('http://192.185.198.152/~dentosis/trabajos/#/editarOrden?orden='+orden);*/
        $location.path('/editarRemovibles').search({
                     orden: orden
                     /*tipo: 1*/
                 });
     }
     
/// Guardar Formulario
     $scope.envio = function(){        
        $http.post('sistema/ordenes/removibles/nuevaRemovible.php', $scope.orden)        
            .success(function(data){                
                var estado = data*1;
            switch(estado) {
                 case 1:
                     toaster.pop('error', "Error", 'Error al obtener Orden', null, 'trustedHtml');
                     break;
                 case 2:
                     toaster.pop('error', "Error", 'Error al guardar Orden', null, 'trustedHtml');
                     break;
                 case 3:
                    toaster.pop('error', "Error", 'Error al guardar Datos Especificos', null, 'trustedHtml');
                    break;
                default:
                     toaster.pop('success', "Guardar Removible", 'Formulario guardado con exito', 5000, 'trustedHtml');
                     $location.path('/editarRemovibles').search({
                     orden: parseInt(data)
                     /*tipo: 1*/
                 });
             }                 
            }).error( function(data){
            toaster.pop('error', "Error", 'Error al conectar con el servidor', null, 'trustedHtml');
        })
    }
     
})