dentosys.controller('nuevoUsuario', function($scope, $http, toaster, $window){  
    $scope.envio = function(){
        $http.post('http://www.rusticofusion.cl/php/agregarUsuario.php', $scope.user)
            .success(function(data){
                $scope.nuevoUsuario = false;    
                $scope.funciono = data;     
                console.log(data);
            })
    }
    $scope.pop = function(estado){
        $scope.estado = estado;
        console.log(estado);
        toaster.pop('success', "title", 'Its address is https://google.com.', 15000, 'trustedHtml', 'goToLink');
        toaster.pop('success', "title", '<ul><li>Render html</li></ul>', 5000, 'trustedHtml');
        toaster.pop('error', "title", '<ul><li>Render html</li></ul>', null, 'trustedHtml');
        toaster.pop('wait', "title", null, null, 'template');
        toaster.pop('warning', "title", "myTemplate.html", null, 'template');
        toaster.pop('note', "title", "text");
    };
})