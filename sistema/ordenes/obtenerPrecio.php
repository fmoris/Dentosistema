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

$idLabor = $request->idLabor;
$idOrigen = $request->idOrigen;
$result = mysqli_query($conexion,"SELECT VALORLABOR 
                                  FROM precios
                                  WHERE IDLABOR = '$idLabor'
                                  AND IDORIGEN = '$idOrigen'");
$row = mysqli_fetch_array($result);
$valor = intval($row['VALORLABOR']);
echo json_encode($valor);
?>