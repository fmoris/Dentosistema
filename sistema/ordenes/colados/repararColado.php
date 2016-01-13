<?
/// NO USAR DIRECTAMENTE SOLO DENTRO DE UN SERVIDOR PHP
//// EJEMPLO USANDO CORS!!
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
/// CONECTA A LA BASE DE DATOS	
// Create connection
// reemplazar con ("localhost", USUARIO, PASSWORD, NOMBRE_DE_BASE_DE_DATOS)
include('../../../php/coneccion.php');
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$result= mysqli_query($conexion,"SELECT colados.PESOMETAL, metales.VALORGRAMO, colados.NUMORDEN
                                      FROM colados, metales
								      WHERE colados.IDMETAL = metales.IDMETAL");

while($row = mysqli_fetch_array($result)){
    $totalmetal = round(floatval($row['PESOMETAL'])*intval($row['VALORGRAMO']));
    $id = $row['NUMORDEN'];
    $result3= mysqli_query($conexion, "UPDATE colados SET TOTALMETAL = '$totalmetal' WHERE NUMORDEN = '$id'");

}

?>