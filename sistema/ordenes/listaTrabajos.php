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
$id = $_GET['idOrden']; 
$clasi = $_GET['clasi']; 
$result = mysqli_query($conexion,"SELECT trabajo.INICIOLABOR, trabajo.FINLABOR, trabajo.VALORTRABAJO, trabajo.CANTIDAD, trabajo.IDLABOR,                                             trabajo.IDEJECUTOR, trabajo.ESTADO, trabajo.NUMTRABAJO, labores.DESCRIPCION, trabajo.FECHAREQUERIDA
                                 FROM trabajo, labores
                                WHERE trabajo.NUMORDEN = '$id'
                                AND trabajo.CLASIFICACION = '$clasi'
                                AND trabajo.IDLABOR = labores.IDLABOR
                                ORDER BY NUMTRABAJO");




/// crea un arreglo general vacio
$resultadoOrdenado = array();
// el arreglo se popula en este bucle
while($row = mysqli_fetch_array($result)){
    // crea un objeto donde se incluyen los datos del registro
    $objetoTrabajo = array();
    $objetoTrabajo["inicio"] = $row['INICIOLABOR'];
    $objetoTrabajo["fin"] = $row['FINLABOR'];
    $objetoTrabajo["requerida"] = $row['FECHAREQUERIDA'];
    $objetoTrabajo["cantidad"] = intval($row['CANTIDAD']);
    $objetoTrabajo["labor"] = array();
    $objetoTrabajo["labor"]["idLabor"] =  $row['IDLABOR'];
    $objetoTrabajo["labor"]["nombre"] =  $row['DESCRIPCION'];
    $objetoTrabajo["ejecutor"] = array();
    $objetoTrabajo["ejecutor"]["id"] = $row['IDEJECUTOR'];
    $objetoTrabajo["precio"] = intval($row['VALORTRABAJO']);
    $objetoTrabajo["precioOld"] = intval($row['VALORTRABAJO']);
    $objetoTrabajo["estado"] = $row['ESTADO'];
    $objetoTrabajo["id"] = $row['NUMTRABAJO'];
    if ($objetoTrabajo["cantidad"] != 0 ){
    $objetoTrabajo["labor"]["precio"] =  $objetoTrabajo["precio"] /$objetoTrabajo["cantidad"];    
    }
    
/// inserta el objeto con los datos de registro, dentro del arreglo general
    array_push($resultadoOrdenado, $objetoTrabajo);
}   

    echo json_encode($resultadoOrdenado);
 
/// una vez populado el arreglo general con datos, se convierte a Json

	
	
?>