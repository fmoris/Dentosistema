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

$ejecutor = $request->nombre;
$direccion = $request->direccion;
$fono = $request->fono;

$existe = mysqli_query($conexion,"SELECT COUNT(NOMEJECUTOR) as CONTEO
								  FROM ejecutores
								  WHERE NOMEJECUTOR LIKE '$ejecutor' ");
while($row = mysqli_fetch_array($existe)){
    // crea un objeto donde se incluyen los datos del registro
    $conteo = array();
    $conteo["existe"] = $row['CONTEO'];
}
$cantidad = $conteo["existe"];

if($conteo["existe"] == 0){
	$ultimoEjecutor = mysqli_query($conexion,"SELECT MAX( IDEJECUTOR +1 ) as IDEJECUTOR
											FROM ejecutores");
	$resultadoOrdenado = array();
	// el arreglo se popula en este bucle
	while($row = mysqli_fetch_array($ultimoEjecutor)){
	    // crea un objeto donde se incluyen los datos del registro
	    $usuario = array();
	    $usuario["IDPERFIL"] = $row['IDEJECUTOR'];
	}    
	$idperfil = $usuario["IDPERFIL"];

	$result = mysqli_query($conexion,"INSERT INTO ejecutores (
											NOMEJECUTOR,
											IDEJECUTOR,
											DIRECCION,
											FONO)
									  VALUES ('$ejecutor',
									  		  '$idperfil',
									  		  '$direccion',
									  		  '$fono')");
	echo $result;
	exit;
}else {
	echo false;
}


?>