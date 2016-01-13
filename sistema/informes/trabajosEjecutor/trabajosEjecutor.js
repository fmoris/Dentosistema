dentosys.controller('imprimirTrabajosEjecutor', function($scope, $http, toaster, $window, $routeParams, $location, $route,$anchorScroll) {

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
    
     $scope.returnDatetime = function(dateString){
         var regex = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/;
         var dateArray = regex.exec(dateString); 
         var dateObject =  new Date(
        (+dateArray[1]),
        (+dateArray[2])-1, // Careful, month starts at 0!
        (+dateArray[3]),
        (+dateArray[4]),
        (+dateArray[5]), // Careful, month starts at 0!
        (+dateArray[6])
        );
        return dateObject;

         }

    if (!$routeParams.id) {

    } else {        
        $scope.informeDetalle = {};
        $scope.informeDetalle.id = $routeParams.id;
        $scope.informeDetalle.inicio = $routeParams.inicio;
        $scope.informeDetalle.fin = $routeParams.fin;
        $scope.informeDetalle.nombre = $routeParams.nombre;
    }   

    $scope.envioTrabajoEjecutor = function() {
        $scope.hideFolio = true;      

        $http.post('sistema/informes/interminadosEjecutor.php', $scope.informeDetalle)
            .success(function(data, status) {
                $scope.interminadosEjecutor = data;
                console.log($scope.interminadosEjecutor);
                angular.forEach($scope.interminadosEjecutor, function(value, key){
                    angular.forEach(value.trabajos, function(item, key2){
                            item.fechaIngreso = $scope.returnDatetime(item.fechaIngreso);
                            item.fechaRequerida = $scope.returnDatetime(item.fechaRequerida);
                        })    
                    })
            
            })
         $http.post('sistema/informes/terminadosEjecutor.php', $scope.informeDetalle)
            .success(function(data, status) {
                $scope.terminadosEjecutor = data;
                console.log($scope.terminadosEjecutor);
                angular.forEach($scope.terminadosEjecutor, function(value, key){
                    angular.forEach(value.trabajos, function(item, key2){
                            item.fechaIngreso = $scope.returnDatetime(item.fechaIngreso);
                            item.fechaRequerida = $scope.returnDatetime(item.fechaRequerida);
                            item.fechaFin = $scope.returnDatetime(item.fechaFin);
                         
                            if (item.fecha.getTime() > item.fecha2.getTime()){
                                item.atrasado = true;
                            }
                        
                        })    
                    })
            
        })
    }
            
    
    $scope.envioTrabajoEjecutor(); 

    $scope.listaEjecutores = function() {
        $http.get('sistema/informes/listaEjecutores.php')
            .success(function(ejecutores) {
                $scope.listaEjecutores = ejecutores;
            })
    }
    $scope.listaEjecutores();

    $scope.arreglarFecha = function (fecha,a,b,c){        
        fecha.setHours(a,b,c,0);    
    }

    $scope.imprimirtrabajosEjecutor = function() {         
        $location.path('/imprimirTrabajosEjecutor').search({
            id: $scope.ejecutor.id,
            inicio: $scope.ejecutor.inicio,
            fin: $scope.ejecutor.fin,
            nombre: $("#impago_ejecutor_nombre :selected").text()
        });
    }

    $scope.vacio = function(data) {
        if (data.length < 1) {
            return true;
        } else {
            return false;
        }
    }    

    $scope.imprimir = function() {
        window.print();
    }

    $scope.irVista = function(data){
         var old = $location.hash();
         $location.hash(data);
         $anchorScroll();
         $location.hash(old);
     }
});