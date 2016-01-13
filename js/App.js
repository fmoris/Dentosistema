var dentosys = angular.module('dentosys', ['ngRoute', 'toaster', 'ngAnimate', 'ngTable','blockUI','ui.select']);
dentosys.config(['$routeProvider',
    function($routeProvider) {

        $routeProvider
            .when('/', {
                templateUrl: 'sistema/usuarios/login/login.html',
                controller: 'loginController'
            })
            .when('/buscaOrdenes', {
                templateUrl: 'sistema/busquedadeOrden/buscaOrdenes.html',
                controller: 'buscaOrdenes'
            })
            .when('/buscaOrdenesOdontologo', {
                templateUrl: 'sistema/busquedadeOrden/buscaOrdenesOdontologo.html',
                controller: 'buscaOrdenesOdontologo'
            })
            .when('/buscaOrdenesOrigen', {
                templateUrl: 'sistema/busquedadeOrden/buscaOrdenesOrigen.html',
                controller: 'buscaOrdenesOrigen'
            })
            .when('/buscaOrdenesAdmin', {
                templateUrl: 'sistema/busquedadeOrden/buscaOrdenesAdmin.html',
                controller: 'buscaOrdenesAdmin'
            })
            .when('/buscaOrdenesAdminMovil', {
                templateUrl: 'sistema/busquedadeOrden/buscaOrdenesAdminMovil.html',
                controller: 'buscaOrdenesAdmin'
            })            
            .when('/registro', {
                templateUrl: 'sistema/usuarios/creacion/nuevoUsuario.html',
                controller: 'nuevoUsuario'
            })
            .when('/Odontologo', {
                templateUrl: 'sistema/mantencion/odontologos/Odontologo.html',
                controller: 'Odontologo'
            })
            .when('/crearOdontologo', {
                templateUrl: 'sistema/mantencion/odontologos/crear/crearOdontologo.html',
                controller: 'crearOdontologo'
            })
            .when('/importarOdontologo', {
                templateUrl: 'sistema/mantencion/perfiles/ActivarOdontologo/importarOdontologo.html',
                controller: 'importarOdontologo'
            })
            .when('/Origen', {
                templateUrl: 'sistema/mantencion/origenes/Origen.html',
                controller: 'Origen'
            })
            .when('/crearOrigen', {
                templateUrl: 'sistema/mantencion/origenes/crear/crearOrigen.html',
                controller: 'crearOrigen'
            })
            .when('/importarOrigen', {
                templateUrl: 'sistema/mantencion/perfiles/ActivarOrigen/importarOrigen.html',
                controller: 'importarOrigen'
            })
            .when('/Ejecutor', {
                templateUrl: 'sistema/mantencion/ejecutores/ejecutor.html',
                controller: 'Ejecutor'           
            })
            .when('/nuevoEjecutor', {
                templateUrl: 'sistema/mantencion/ejecutores/crear/nuevoEjecutor.html',
                controller: 'nuevoEjecutor'
            })
            .when('/editarEjecutores', {
                templateUrl: 'sistema/mantencion/ejecutores/editar/editarEjecutores.html',
                controller: 'editarEjecutores'
            })
            .when('/estados', {
                templateUrl: 'sistema/mantencion/estados/estados.html',
                controller: 'estados'
            })
            .when('/nuevoEstadoOrden', {
                templateUrl: 'sistema/mantencion/estados/estadoOrden/nuevoEstado.html',
                controller: 'nuevoEstadoOrden'
            })
            .when('/editarEstadoOrden', {
                templateUrl: 'sistema/mantencion/estados/estadoOrden/editarEstado.html',
                controller: 'editarEstadoOrden'
            })
            .when('/nuevoEstadoTrabajo', {
                templateUrl: 'sistema/mantencion/estados/estadoTrabajo/nuevoEstado.html',
                controller: 'nuevoEstadoTrabajo'
            })
            .when('/editaEstadoTrabajo', {
                templateUrl: 'sistema/mantencion/estados/estadoTrabajo/editarEstado.html',
                controller: 'editaEstadoTrabajo'
            })
            .when('/cambiarPassword', {
                templateUrl: 'sistema/usuarios/perfil/cambiarPassword.html',
                controller: 'cambiarPassword'
            })
            .when('/actualizarPerfil', {
                templateUrl: 'sistema/usuarios/perfil/actualizarPerfil.html',
                controller: 'actualizarPerfil'
            })
            .when('/perfil', {
                templateUrl: 'sistema/usuarios/perfil/perfil.html',
                controller: 'perfil'
            })
            .when('/pagarTrabajoOdontologo', {
                templateUrl: 'sistema/pagos/pagarTrabajoOdontologo.html',
                controller: 'pagarTrabajoOdontologo'
            })
            .when('/pagarTrabajoOrigen', {
                templateUrl: 'sistema/pagos/pagarTrabajoOrigen.html',
                controller: 'pagarTrabajoOrigen'
            })
            .when('/pagos', {
                templateUrl: 'sistema/pagos/pagos.html',
                controller: 'pagos'
            })
            .when('/nuevoOrigen', {
                templateUrl: 'sistema/aranceles/origenes/nuevoOrigen.html',
                controller: 'nuevoOrigen'
            })
            .when('/editarOrigen', {
                templateUrl: 'sistema/aranceles/origenes/editarOrigen.html',
                controller: 'editarOrigen'
            })
            .when('/nuevaLabor', {
                templateUrl: 'sistema/aranceles/labores/nuevaLabor.html',
                controller: 'nuevaLabor'
            })
            .when('/editarLabor', {
                templateUrl: 'sistema/aranceles/labores/editarLabor.html',
                controller: 'editarLabor'
            })
            .when('/reordenarLabores', {
                templateUrl: 'sistema/aranceles/reordenarLabores/reordenarLabores.html',
                controller: 'reordenarLabores'
            })
            .when('/nuevaEtapa', {
                templateUrl: 'sistema/aranceles/etapas/nuevaEtapa.html',
                controller: 'nuevaEtapa'
            })
            .when('/editarEtapa', {
                templateUrl: 'sistema/aranceles/etapas/editarEtapa.html',
                controller: 'editarEtapa'
            })
            .when('/aranceles', {
                templateUrl: 'sistema/aranceles/aranceles.html',
                controller: 'aranceles'
            })
            .when('/informes', {
                templateUrl: 'sistema/informes/informes.html',
                controller: 'informes'
            })
            .when('/impagosOrigen', {
                templateUrl: 'sistema/informes/impagosOrigen/impagosOrigen.html',                
                controller: 'impagosOrigen'
            })
            .when('/impagosOdontologo', {
                templateUrl: 'sistema/informes/impagosOdontologo/impagosOdontologo.html',
                controller: 'impagosOdontologo'
            })
            .when('/imprimirTrabajosEjecutor', {
                templateUrl: 'sistema/informes/trabajosEjecutor/trabajosEjecutor.html',
                controller: 'imprimirTrabajosEjecutor'
            })
            .when('/imprimirPagosPorFecha', {
                templateUrl: 'sistema/informes/pagosPorFecha/pagosPorFecha.html',
                controller: 'imprimirPagosPorFecha'
            })
            .when('/protesisFija', {
                templateUrl: 'sistema/ordenes/protesisFija/protesisFija.html',
                controller: 'protesisFija'
            })
            .when('/editarProtesisFija', {
                templateUrl: 'sistema/ordenes/protesisFija/editarProtesisFija.html',
                controller: 'editarProtesisFija'
            })
            .when('/colados', {
                templateUrl: 'sistema/ordenes/colados/colados.html',
                controller: 'colados'
            })
            .when('/editarColados', {
                templateUrl: 'sistema/ordenes/colados/editarColados.html',
                controller: 'editarColados'
            })
            .when('/removibles', {
                templateUrl: 'sistema/ordenes/removibles/removibles.html',
                controller: 'removibles'
            }) 
            .when('/editarRemovibles', {
                templateUrl: 'sistema/ordenes/removibles/editarRemovibles.html',
                controller: 'editarRemovibles'
            })
            .when('/nuevoConvenio', {
                templateUrl: 'sistema/aranceles/convenios/nuevoConvenio.html',
                controller: 'nuevoConvenio'
            })
            .when('/editarConvenio', {
                templateUrl: 'sistema/aranceles/convenios/editarConvenio.html',
                controller: 'editarConvenio'
            })
            .when('/mantencion', {
                templateUrl: 'sistema/mantencion//mantencion.html',
                controller: 'mantencion'
            })
            .when('/nuevoMetal', {
                templateUrl: 'sistema/aranceles/metales/nuevoMetal.html',
                controller: 'nuevoMetal'
            })
            .when('/editarMetales', {
                templateUrl: 'sistema/aranceles/metales/editarMetales.html',
                controller: 'editarMetales'
            })
            /*TESTING, REMOVER EVENTUALMENTE
            .when('/editarOrden', {
                templateUrl: 'sistema/ordenes/protesisFija/editarOrden.html',
                controller: 'editarOrden'
            })   */     
            .otherwise({
                redirectTo: '/'
            })
    }
]);

/*dentosys.factory('usuarioConectado', function(){
    
    return {
        id: 'null',
        nombre: 'null',
        permiso: 'null'
    };
})*/

dentosys.config(function(uiSelectConfig) {
  uiSelectConfig.theme = 'bootstrap';
  uiSelectConfig.resetSearchInput = true;
  uiSelectConfig.appendToBody = true;
});

dentosys.filter('dateToISO', function() {
  return function(input) {
        if(input){
            input = new Date(input).toISOString();
            return input;
        }
  };
});
