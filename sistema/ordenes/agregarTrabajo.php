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

$result = mysqli_query($conexion,"SELECT max(NUMTRABAJO) as NUMTRABAJO from trabajo
                                   WHERE NUMORDEN = '$idOrden'
                                   AND CLASIFICACION = '$clasi'");
$idTrabajo = 1 + intval (mysqli_fetch_array($result)['NUMTRABAJO']);

$idLabor = $request->labor->idLabor;

$idEtapa = $request->labor->idEtapa;
$idEjecutor = $request->ejecutor->id;
$fechaInicio = $request->inicio;
$fechaFin = $request->fin;
$fechaRequerida = $request->requerida;
$estado = $request->estado;
$precio = $request->precio;
$cantidad = $request->cantidad;

echo "req " . $fechaRequerida  . " ini " . $fechaInicio . " fin " . $fechaFin . " precio " . $precio . " cantidad " . $cantidad . " idEjec" . $idEjecutor ;
echo $idLabor . $idTrabajo . $estado . $idEtapa . $idOrden;



$result2 = mysqli_query($conexion,"INSERT INTO trabajo 
(NUMORDEN, NUMTRABAJO, IDETAPA, IDLABOR, IDEJECUTOR, INICIOLABOR, FINLABOR, FECHAREQUERIDA, ESTADO, VALORTRABAJO, CANTIDAD, CLASIFICACION) 
                                  VALUES ('$idOrden','$idTrabajo','$idEtapa','$idLabor','$idEjecutor','$fechaInicio','$fechaFin','$fechaRequerida','$estado','$precio','$cantidad', '$clasi' )");

$result3 = mysqli_query($conexion, "UPDATE orden
                                    SET TOTALORDEN = '$precioOrden'
                                    WHERE NUMORDEN = '$idOrden'
                                    AND CLASIFICACION = '$clasi'"); 
                                 


   


	
	
?>