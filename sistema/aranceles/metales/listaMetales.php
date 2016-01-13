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

$result = mysqli_query($conexion,"SELECT * FROM metales");




/// crea un arreglo general vacio
$resultadoOrdenado = array();
// el arreglo se popula en este bucle
while($row = mysqli_fetch_array($result)){
    // crea un objeto donde se incluyen los datos del registro
    $objetoEstado = array();
    $objetoEstado["nombre"] = $row['NOMMETAL'];
    $objetoEstado["id"] = $row['IDMETAL'];
    $objetoEstado["precio"] = $row['VALORGRAMO'];
    $objetoEstado["obsoleto"] = $row['OBSOLETO'];

   
    
/// inserta el objeto con los datos de registro, dentro del arreglo general
    array_push($resultadoOrdenado, $objetoEstado);
}   

    echo json_encode($resultadoOrdenado);

?>