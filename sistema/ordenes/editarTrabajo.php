<?
/// NO USAR DIRECTAMENTE SOLO DENTRO DE UN SERVIDOR PHP
//// EJEMPLO USANDO CORS!!
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
/// CONECTA A LA BASE DE DATOS	
// Create connection
// reemplazar con ("localhost", USUARIO, PASSWORD, NOMBRE_DE_BASE_DE_DATOS)
include('../../php/coneccion.php');
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$idOrden = $request->idOrden;
$clasi = $request->clasi;
$precioOrden = $request->precioOrden;
$idTrabajo = $request->id;
$idLabor = $request->labor->idLabor;
$idEtapa = $request->labor->idEtapa;
$idEjecutor = $request->ejecutor->id;
$fechaInicio = $request->inicio;
$fechaFin = $request->fin;
$fechaRequerida = $request->requerida;
$estado = $request->estado;
$precio = $request->precio;
$cantidad = $request->cantidad;



$result2 = mysqli_query($conexion,"UPDATE trabajo
                                   SET IDETAPA = '$idEtapa',
                                   IDLABOR = '$idLabor',
                                   IDEJECUTOR =  '$idEjecutor',
                                   INICIOLABOR =  '$fechaInicio',
                                   FINLABOR = '$fechaFin',
                                   FECHAREQUERIDA = '$fechaRequerida',
                                   ESTADO = '$estado',
                                   VALORTRABAJO = '$precio',
                                   CANTIDAD = '$cantidad'
                                   
                                   WHERE NUMORDEN = '$idOrden'
                                   AND CLASIFICACION = '$clasi'
                                   AND NUMTRABAJO = '$idTrabajo' ");
                                   

$result3 = mysqli_query($conexion, "UPDATE orden
                                    SET TOTALORDEN = '$precioOrden'
                                    WHERE NUMORDEN = '$idOrden'
                                    AND CLASIFICACION = '$clasi'"); 
                                 


   


	
	
?>