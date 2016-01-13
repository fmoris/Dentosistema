 dentosys.controller('actualizarPerfil', function($scope, $http, toaster, $window, $location) { 

    switch (localStorage.getItem("permiso")) {
        case '1':
            //$('#loginModal').modal('show');
            break;
        case '2':
            //$('#loginModal').modal('show');
            break;
        case '99':
            break;
        default:
            $('#loginModal').modal('show');
            /*$location.path('/');*/
    }

 	$scope.idperfil = localStorage.getItem("id");
        $scope.nombreperfil = localStorage.getItem("nombre");
        $scope.permiso = localStorage.getItem("permiso");
        

        switch($scope.permiso*1){
            case 1:
                $scope.cargoperfil = "Odontologo"
            break;
            case 2:
                $scope.cargoperfil = "Origen"
            break;
            case 99:
                $scope.cargoperfil = "Administrador"
            break;
           
        } 

 	$scope.datosPerfil = function(){
 		$scope.datos = {};
 		$scope.datos.permiso = localStorage.getItem("permiso");
 		$scope.datos.idperfil = localStorage.getItem("id");
         $http.post('sistema/usuarios/perfil/obtieneDatosPerfil.php', $scope.datos)
         	.success(function(datos) {         	
         	$scope.perfil = datos;
         })
    } 
 $scope.datosPerfil();

 $scope.validaPassword = function(){
 		$scope.datos = {};
        $scope.datos.password = $scope.perfil.password;
        $scope.datos.idperfil = localStorage.getItem("id");
        $scope.datos.permiso = localStorage.getItem("permiso");
        $http.post('sistema/usuarios/perfil/validaPassword.php', $scope.datos
         ).success(function(existe) {
             $scope.existe = existe;
             if ($scope.existe == 1) {
                 toaster.pop('success', "Contraseña Valida", 'Contraseña Valida', null, 'trustedHtml');                 
                 $("#direccion").prop('readonly', false);
                 $("#correo").prop('readonly', false);
                 $("#fono").prop('readonly', false);
                 $("#celular").prop('readonly', false);
                 $("#password").prop('readonly', true); 
                 document.getElementById("btn_guardar").disabled = false;
             } else {
                 toaster.pop('error', "Error", 'Contraseña invalida', null, 'trustedHtml');
                 document.getElementById("pass1").value = "";
                 document.getElementById("pass2").value = "";
                 $("#pass1").prop('readonly', true);
                 $("#pass2").prop('readonly', true);

             }
         }).error(function(existe) {
             toaster.pop('error', "Error", 'No se a podido validar, intentelo más tarde', null, 'trustedHtml');
         })
     }

    $scope.envio = function() {
         $http.get('sistema/usuarios/creacion/verificaCorreo.php', {
             params: {
                 rut: $scope.perfil.correo
             }
         }).success(function(existe) {
             $scope.existe = existe[0];
             if ($scope.existe == 0) {
                 toaster.pop('success', "Email valido", 'Email valido', null, 'trustedHtml');                   
                 $scope.perfil.idperfil = localStorage.getItem("id");
                 $scope.perfil.permiso =  localStorage.getItem("permiso"); 
                 $http.post('sistema/usuarios/perfil/actualizarPerfil.php', $scope.perfil)
                     .success(function(data) {
                        $http.post('sistema/usuarios/perfil/actualizarPerfilMail.php', $scope.perfil)
                            .success(function(data){                                
                                if(data == 1){
                                    toaster.pop('success', "Correo Enviado", 'El correo a sido enviado correctamente', 5000, 'trustedHtml');
                                }else{
                                    toaster.pop('error', "Error al Enviar Correo", 'El correo no a sido enviado', null, 'trustedHtml');
                                } 
                            })                           
                        $location.path('/actualizarPerfil');
                        toaster.pop('success', "Actualizar Perfil", 'Formulario guardado con exito', 5000, 'trustedHtml');
                     }).error(function(data) {
                         toaster.pop('error', "Error", 'Error al Guardar', null, 'trustedHtml');
                     })
             } else {

                 toaster.pop('error', "Error", 'Email ya Existe', null, 'trustedHtml');

             }

         }).error(function(existe) {

             toaster.pop('error', "Error", 'Error al buscar', null, 'trustedHtml');

         })

     }
       
    
 })