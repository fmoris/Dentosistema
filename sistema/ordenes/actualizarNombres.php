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

$result = mysqli_query($conexion,"SELECT IDLABOR,DESCRIPCION 
                                            FROM labores");

while($row = mysqli_fetch_array($result)){
    $idLabor = $row['IDLABOR'];
    $nombre =$row['DESCRIPCION']; 
    $result2 = mysqli_query($conexion,"UPDATE precios
                                       SET NOMBRE = '$nombre'
                                       WHERE IDLABOR = '$idLabor'");
}
    ?>