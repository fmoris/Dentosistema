dentosys.controller('imprimirImpagosOrigen', function($scope, $http, toaster, $window, $routeParams, $location) {

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

    if (!$routeParams.origen) {

    } else {
        $scope.informeDetalle = {};
        $scope.informeDetalle.id = $routeParams.origen;
    }

    /*$scope.informeDetalle = {};
    $scope.informeDetalle.id = $routeParams.origen;*/

    $scope.envioOrigen = function() {        
        //$location.path('/informeTrabajoOrigen').search({param: $scope.origen.id});
        $http.post('sistema/informes/impagosOrigen.php', $scope.informeDetalle)
            .success(function(data, status) {
                $scope.trabajos = data;
            })
    }

    $scope.vacio = function(data) {
        if (data.length < 1) {
            return true;
        } else {
            return false;
        }
    }

    $scope.envioOrigen();

    /*$scope.imprSelec = function(nombre) {
         var ficha = document.getElementById(nombre);
        var ventimp = window.open(' ', 'popimpr');
        ventimp.document.write(ficha.innerHTML);
        ventimp.document.close();
        ventimp.print();
        ventimp.close();
        printElement(document.getElementById("myModal1"));
        printElement(document.getElementById("printThisToo"), true, "<hr />");
        window.print();

    }*/

    $scope.imprimir = function() {
        window.print();
    }


    /*function printElement(elem, append, delimiter) {
        console.log(elem);
        var domClone = elem.cloneNode(true);

        var $printSection = document.getElementById("printSection");

        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }

        if (append !== true) {
            $printSection.innerHTML = "";
        } else if (append === true) {
            if (typeof(delimiter) === "string") {
                $printSection.innerHTML += delimiter;
            } else if (typeof(delimiter) === "object") {
                $printSection.appendChlid(delimiter);
            }
        }

        $printSection.appendChild(domClone);
    }*/


});