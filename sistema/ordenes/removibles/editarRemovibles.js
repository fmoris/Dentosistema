 dentosys.controller('editarRemovibles', function($scope, $http, toaster, $window, $routeParams, $location, $anchorScroll, $route) {
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

     if (!$routeParams.orden || $routeParams.orden == null || $routeParams.orden == 0) {
         toaster.pop('error', "Error", 'Orden no Valida', null, 'trustedHtml');
         $location.path('/buscaOrdenes');

     } else {
         $scope.informeDetalle = {};
         $scope.informeDetalle.orden = $routeParams.orden;
         /*$scope.informeDetalle.tipo = $routeParams.tipo;*/
     }
     

     $scope.orden = {};
     /*$scope.idOrden = 46486;*/
    $scope.idOrden = $routeParams.orden;
     $scope.clasi = 3;
     /*$scope.orden.clasi = $routeParams.tipo;*/
     $scope.trabajos = {};
     $scope.item = {};
     $scope.item.precioOld = 0;
     $scope.item.cantidad = 0;
     /*PARSER DE FECHAS*/

     $scope.returnDatetime = function(dateString) {
         var regex = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/;
         var dateArray = regex.exec(dateString);
         var dateObject = new Date(
             (+dateArray[1]), (+dateArray[2]) - 1, // Careful, month starts at 0!
             (+dateArray[3]), (+dateArray[4]), (+dateArray[5]), // Careful, month starts at 0!
             (+dateArray[6])
         );
         return dateObject;
     }

     /*OBTENER DATOS DE ORDEN Y TRABAJOS*/

     $scope.obtenerOrden = function() {
         $http.get('sistema/ordenes/removibles/obtenerOrden.php', {
             params: {
                 id: $scope.idOrden,
                 clasi: $scope.clasi
                 /*id: $routeParams.orden,
                 clasi: $routeParams.tipo*/
             }
         }).success(function(datosDeLaRespuesta) {
             $scope.orden = datosDeLaRespuesta;
             $scope.orden.fin = $scope.returnDatetime($scope.orden.fin);
             $scope.orden.inicio = $scope.returnDatetime($scope.orden.inicio);
             $scope.origen = $scope.orden.origen.id;
             $scope.orden.clasi = 3;
             if (!$scope.orden.anulacion) {
                 $scope.orden.anular = false;
             } else {
                 $scope.orden.anular = true;
             }
             $scope.obtenerLabores();
         })
     }
     $scope.obtenerOrden();

     $scope.obtenerTrabajos = function() {
         $http.get('sistema/ordenes/listaTrabajos.php', {
             params: {
                 idOrden: $scope.idOrden,
                 clasi: $scope.clasi
             }
         }).success(function(datosDeLaRespuesta) {
             datosDeLaRespuesta;
             $scope.trabajos = {};
             for (var i = 0, len = datosDeLaRespuesta.length; i < len; i++) {
                 $scope.trabajos[datosDeLaRespuesta[i].id] = datosDeLaRespuesta[i];
             }
             $scope.mostrar = 0;
             angular.forEach($scope.trabajos, function(value, key) {
                 value.inicio = $scope.returnDatetime(value.inicio);
                 value.fin = $scope.returnDatetime(value.fin);
                 value.requerida = $scope.returnDatetime(value.requerida);
             })
         })
     }
     $scope.obtenerTrabajos();

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

     $scope.obtenerOrigenes = function() {
         $http.get('sistema/ordenes/listaOrigenesActivos.php')
             .success(function(origenes) {
                 $scope.listaOrigenes = origenes;
             })
     }
     $scope.obtenerOrigenes();

     $scope.obtenerOdontologos = function() {
         $http.get('sistema/ordenes/listaOdontologos.php')
             .success(function(odontologos) {
                 $scope.listaOdontologos = odontologos;
             })
     }
     $scope.obtenerOdontologos();

     $scope.obtenerEstadosOrden = function() {
         $http.get('sistema/ordenes/listaEstadosOrden.php')
             .success(function(estados) {
                 $scope.listaEstadosOrden = estados;
             })
     }
     $scope.obtenerEstadosOrden();
     
     
     

     /*MODIFICACIONES A BDD*/
     
     
     
     $scope.editarTrabajo = function(inputData) {
         inputData.idOrden = $scope.idOrden;
         inputData.clasi = $scope.clasi;
         inputData.precioOrden = $scope.orden.total;
         $http.post('sistema/ordenes/editarTrabajo.php', inputData)
             .success(function(outputData) {})
     }
     $scope.editarOrden = function(inputData) {
         inputData.idOrden = $scope.idOrden;
         console.log(inputData);
         if(inputData.estado == "Terminado"){
             //Revisar aca si el inputData.odontologo.id esta en la tabla perfiles y si esta, mandarle un correo notificando que la orden esta terminada.
             //en el mail tiene que ir el nombre del paciente, las fechas, y los nombres que estan en la lista de trabajos
             angular.forEach($scope.trabajos, function(value, key) {
             console.log(value.labor.nombre); // aca deberian salir los nombres de la lista de trabajos.
         });
         }
         $http.post('sistema/ordenes/removibles/editarRemovibles.php', inputData)
             .success(function(outputData) {
                 $route.reload();
             })
     }

     $scope.agregarTrabajo = function(inputData) {
         inputData.idOrden = $scope.idOrden;
         inputData.precioOrden = $scope.orden.total;
         $http.post('sistema/ordenes/agregarTrabajo.php', inputData)
             .success(function(outputData) {
                $route.reload();
         })
     }

     $scope.eliminarTrabajo = function(inputData) {
         inputData.idOrden = $scope.idOrden;
         $http.post('sistema/ordenes/eliminarTrabajo.php', inputData)
             .success(function(outputData) {
                $route.reload();
         })
     }
     
     $scope.confirmarEliminacion = function(inputData) {
         $scope.eliminar = inputData;
     }

     /*FUNCIONALIDAD AGREGAR TRABAJO */

     $scope.obtenerEjecutores = function() {
         $http.get('sistema/ordenes/listaEjecutoresActivos.php')
             .success(function(ejecutores) {
                 $scope.listaEjecutores = ejecutores;
             })
     }
     $scope.obtenerEjecutores();

     $scope.obtenerLabores = function() {
         $http.get('sistema/ordenes/listaLaboresActivas.php', {
             params: {

                 clasi: $scope.clasi;,
                 idOrigen: $scope.origen
             }
         })
             .success(function(labores) {
                 $scope.listaLabores = labores;
             })
     }

     $scope.obtenerEstadosTrabajo = function() {
         $http.get('sistema/ordenes/listaEstadosTrabajo.php')
             .success(function(estados) {
                 $scope.listaEstadosTrabajo = estados;
             })
     }
     $scope.obtenerEstadosTrabajo();

     $scope.irVista = function(data) {
         var old = $location.hash();
         $location.hash(data);
         $anchorScroll();
         $location.hash(old);
     }

     $scope.obtenerPrecio = function(inputData) {
         console.log(inputData);
         inputData.precio = parseInt(inputData.cantidad) * parseInt(inputData.labor.precio);
         $scope.orden.total = parseInt($scope.orden.totalOld) + parseInt(inputData.precio) - parseInt(inputData.precioOld);
     }
     
     /*$scope.trabajos = [{ labor: {
             nombre: 'lala'
         }, cantidad: 4}, { labor: {
             nombre: 'po'
         }},{ labor: {
             nombre: 'dipsy'
         }},{ labor: {
             nombre: 'dipsy3'
         }},{ labor: {
             nombre: 'dipsy4'
         }},{ labor: {
             nombre: 'dipsy5'
         }},{ labor: {
             nombre: 'dipsy2'
         }}
                            ];
     
     $scope.mostrar = ($scope.trabajos.length)-1;*/

     /*FUNCIONALIDAD VISTAS TRABAJOS A REALIZAR*/
     $scope.$watch('mostrar',
         function(newValue, oldValue) {
             $scope.irVista('trabajos');
         }
     );

     $scope.mostrarTrabajo = function(data) {
         $scope.mostrar = parseInt(data);
         $scope.orden.total = $scope.orden.totalOld;
         $scope.item = {};  
         $scope.item.labor = {};
         $scope.item.labor.precio = 0;
         $scope.item.precioOld = 0;
         $scope.item.precio = 0;
         $scope.item.cantidad = 0;
         if(data == 99){
            console.log(data);
            $scope.obtenerPrecio($scope.item);
         }
         else{
            $scope.obtenerPrecio($scope.trabajos[data]);
         }
      
     }
 })