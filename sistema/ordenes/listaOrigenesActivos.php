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

$result = mysqli_query($conexion,"SELECT IDORIGEN,INSTITUCION from origen
								  WHERE origen.OBSOLETO = 0");



/// crea un arreglo general vacio
$resultadoOrdenado = array();
// el arreglo se popula en este bucle
while($row = mysqli_fetch_array($result)){
    // crea un objeto donde se incluyen los datos del registro
    $objetoOrigen = array();
    $objetoOrigen["id"] = $row['IDORIGEN'];
    $objetoOrigen["nombre"] = $row['INSTITUCION'];	
    
/// inserta el objeto con los datos de registro, dentro del arreglo general
    array_push($resultadoOrdenado, $objetoOrigen);
}   

    echo json_encode($resultadoOrdenado);
 
/// una vez populado el arreglo general con datos, se convierte a Json

	
	
?>