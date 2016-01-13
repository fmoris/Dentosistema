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
$clasi = $_GET['clasi']; 
$origen = $_GET['idOrigen'];
$result = mysqli_query($conexion,"SELECT labores.IDLABOR, precios.NOMBRE, precios.VALORLABOR, labores.IDETAPA, NOMETAPA 
                                  FROM labores, etapas, precios 
                                  WHERE labores.IDETAPA = etapas.IDETAPA
                                  AND labores.IDLABOR = precios.IDLABOR
                                  AND labores.OBSOLETO = 0
                                  AND precios.IDORIGEN = '$origen'
                                  AND precios.ACTIVO = 1                                  
                                  AND etapas.CLASIFICACION = '$clasi'");




/// crea un arreglo general vacio
$resultadoOrdenado = array();
// el arreglo se popula en este bucle
while($row = mysqli_fetch_array($result)){
    // crea un objeto donde se incluyen los datos del registro
    $objetoLabor = array();
    $objetoLabor["idLabor"] = $row['IDLABOR'];
    $objetoLabor["idEtapa"] = $row['IDETAPA'];
    $objetoLabor["nombreLabor"] = $row['NOMBRE'];	
    $objetoLabor["nombreEtapa"] = $row['NOMETAPA'];	
    $objetoLabor["precio"] = $row['VALORLABOR'];
    
/// inserta el objeto con los datos de registro, dentro del arreglo general
    array_push($resultadoOrdenado, $objetoLabor);
}   

    echo json_encode($resultadoOrdenado);
 
/// una vez populado el arreglo general con datos, se convierte a Json

	
	
?>