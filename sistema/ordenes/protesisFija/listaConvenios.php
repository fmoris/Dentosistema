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

$id = $_GET['id'];

$result = mysqli_query($conexion,"SELECT convenios.OBSOLETO, PRECIO, IDCONVENIO, INSTITUCION, NOMCONVENIO from convenios, origen
                                  WHERE convenios.IDORIGEN= '$id'
                                  AND convenios.IDORIGEN = origen.IDORIGEN
                                  and convenios.CLASIFICACION = 1");



/// crea un arreglo general vacio
$resultadoOrdenado = array();

// el arreglo se popula en este bucle

while ($row = mysqli_fetch_array($result)){
    $objetoConvenio = array();
    $objetoConvenio["labores"] = array();

    $objetoConvenio["id"] = $row['IDCONVENIO'];
    $objetoConvenio["nombre"] = $row['NOMCONVENIO'];	
    $objetoConvenio["precio"] = $row['PRECIO'];
    $objetoConvenio["origen"] = $row['INSTITUCION'];	
    $objetoConvenio["obsoleto"] = $row['OBSOLETO'];	
    
    
/// inserta el objeto con los datos de registro, dentro del arreglo general
    
    
    $result2 = mysqli_query($conexion,"SELECT IDLABOR from infoconvenio
                                  WHERE IDCONVENIO = '$id'
                                  ");



    while ($row2 = mysqli_fetch_array($result2)){
           $objetoLabor = array();
        // crea un objeto donde se incluyen los datos del registro
           $objetoLabor["id"] = $row2['IDLABOR'];

           array_push($objetoConvenio["labores"], $objetoLabor); 

        }  
    array_push($resultadoOrdenado["labores"], $objetoConvenio); 
}

echo json_encode($resultadoOrdenado);
 
/// una vez populado el arreglo general con datos, se convierte a Json

	
	
?>