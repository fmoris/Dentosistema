 dentosys.controller('buscaOrdenesOrigen', function($scope, $http, toaster, $window, $filter, $q, ngTableParams, $location, $route) {

    /*function validausuario(){
        if(localStorage.getItem("id") == null){
            $route.reload();
        }
    }
    validausuario();*/

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
             $location.path('/');

     }

     $http.get('sistema/busquedadeOrden/listaOrdenes.php', {
         params: {
             id: localStorage.getItem("id"),
             permiso: localStorage.getItem("permiso")
         }
     }).success(function(data, status) {
         $scope.data = data;
         $scope.tableParams = new ngTableParams({
             page: 1, // show first page
             count: 4, // count per page
             sorting: {
                 Orden: 'asc' // initial sorting
             }
         }, {
             total: $scope.data.length, // length of data
             getData: function($defer, params) { // use build-in angular filter
                 var orderedData = params.sorting ?
                     $filter('orderBy')($scope.data, params.orderBy()) :
                     data;
                 orderedData = params.filter ?
                     $filter('filter')(orderedData, params.filter()) :
                     orderedData;

                 $scope.users = orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());

                 params.total(orderedData.length); // set total for recalc pagination
                 $defer.resolve($scope.users);
             }
         });
     });
     var inArray = Array.prototype.indexOf ?
         function(val, arr) {
             return arr.indexOf(val)
         } :
         function(val, arr) {
             var i = arr.length;
             while (i--) {
                 if (arr[i] === val) return i;
             }
             return -1
         };

         $scope.pacientes = function(column) {
         var def = $q.defer(),
             arr = [],
             names = [];
         $scope.data = $scope.data;
         $scope.$watch('data', function() {
             angular.forEach($scope.data, function(item) {
                 if (inArray(item.paciente, arr) === -1) {
                     arr.push(item.paciente);
                     names.push({
                         'id': item.paciente,
                         'title': item.paciente
                     });
                 }
             });
         });
         def.resolve(names);
         return def;
     };

     $scope.estados = function(column) {
         var def = $q.defer(),
             arr = [],
             names = [];
         $scope.data = $scope.data;
         $scope.$watch('data', function() {
             angular.forEach($scope.data, function(item) {
                 if (inArray(item.estado, arr) === -1) {
                     arr.push(item.estado);
                     names.push({
                         'id': item.estado,
                         'title': item.estado
                     });
                 }
             });
         });
         def.resolve(names);
         return def;
     };
     $scope.pagados = function(column) {
         var def = $q.defer(),
             arr = [],
             names = [];
         $scope.data = $scope.data;
         $scope.$watch('data', function() {
             angular.forEach($scope.data, function(item) {
                 if (inArray(item.pagado, arr) === -1) {
                     arr.push(item.pagado);
                     names.push({
                         'id': item.pagado,
                         'title': item.pagado
                     });
                 }
             });
         });
         def.resolve(names);
         return def;
     };

     $scope.clasificaciones = function(column) {
         var def = $q.defer(),
             arr = [],
             names = [];
         $scope.data = $scope.data;
         $scope.$watch('data', function() {
             angular.forEach($scope.data, function(item) {
                 if (inArray(item.clasificacion, arr) === -1) {
                     arr.push(item.clasificacion);
                     names.push({
                         'id': item.clasificacion,
                         'title': item.clasificacion
                     });
                 }
             });
         });
         def.resolve(names);
         return def;
     };

     $scope.edita = function(idorden, clasificacion) {
             $http.get('sistema/busquedadeOrden/listaTrabajos.php', {
                 params: {
                     idorden: idorden,
                     clasificacion: clasificacion
                 }
             }).success(function(trabajos) {
                    $scope.trabajos = trabajos;                    
                 })
             }
 });