 dentosys.controller('nuevoPaciente' , function($scope, $http,toaster, $window){          

/// Guardar Formulario
     $scope.envio = function(){		 
        $http.post('http://www.rusticofusion.cl/php/nuevoUsuario/Paciente/guardapaciente.php', $scope.paciente)
            .success(function(data,response){
			console.log(response);
             toaster.pop('success', "Guardar Ejecutor", 'Formulario guardado con exito', 5000, 'trustedHtml');
            }).error( function(data){
            toaster.pop('error', "Error", 'Error al Guardar', null, 'trustedHtml');
        })
    }
     
})