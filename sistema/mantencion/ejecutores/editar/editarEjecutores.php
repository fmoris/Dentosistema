<?
/// NO USAR DIRECTAMENTE SOLO DENTRO DE UN SERVIDOR PHP
//// EJEMPLO USANDO CORS!!
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
/// CONECTA A LA BASE DE DATOS  
// Create connection
// reemplazar con ("localhost", USUARIO, PASSWORD, NOMBRE_DE_BASE_DE_DATOS)
include('../../../../php/coneccion.php');
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$id = $request->id;
$ejecutor = $request->nombre;
$direccion = $request->direccion;
$fono = $request->fono;
$obsoleto = $request->obsoleto;

	$result = mysqli_query($conexion,"UPDATE ejecutores
									  SET NOMEJECUTOR = '$ejecutor',
									  DIRECCION = '$direccion',
									  FONO = '$fono',
									  OBSOLETO = '$obsoleto'
									  WHERE IDEJECUTOR = '$id'");
	echo $result;
	exit;							

?>