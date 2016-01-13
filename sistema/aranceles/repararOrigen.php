<?

//// EJEMPLO USANDO CORS!!
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
/// CONECTA A LA BASE DE DATOS
	
	// Create connection
	// reemplazar con ("localhost", USUARIO, PASSWORD, NOMBRE_DE_BASE_DE_DATOS)
	//$conexion=mysqli_connect("localhost","root","","dentosys");
    include('../../php/coneccion.php');
$result =  mysqli_query($conexion,"SELECT DISTINCT IDLABOR, DESCRIPCION, VALORLABOR, OBSOLETO FROM labores");
while($row = mysqli_fetch_array($result)){
    $idLabor = $row['IDLABOR'];
    $precio = $row['VALORLABOR'];
    $nombre = $row['DESCRIPCION'];
    $obsoleto = $row['OBSOLETO'];
    if ($obsoleto == 1 ){
        $updateQuery = mysqli_query($conexion,"UPDATE precios SET ACTIVO = 0 WHERE IDLABOR = '$idLabor'");
    }
    $queryOrigen = mysqli_query($conexion,"SELECT IDORIGEN from origen");
        while($rowOrigen = mysqli_fetch_array($queryOrigen)){
            $origen = $rowOrigen['IDORIGEN'];       
            $result2 =  mysqli_query($conexion,"INSERT INTO precios(IDLABOR, IDORIGEN, NOMBRE, VALORLABOR) VALUES ('$idLabor','$origen', '$nombre', '$precio')");




        }
}
    


?>