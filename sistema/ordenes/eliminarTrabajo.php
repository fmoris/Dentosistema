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
$idTrabajo = $request->id;




$result2 = mysqli_query($conexion,"DELETE FROM trabajo
                                   WHERE NUMORDEN = '$idOrden'
                                   AND CLASIFICACION = '$clasi'
                                   AND NUMTRABAJO = '$idTrabajo' ");
                                   


?>