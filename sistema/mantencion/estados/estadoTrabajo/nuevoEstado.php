<?
//// EJEMPLO USANDO CORS!!
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
/// CONECTA A LA BASE DE DATOS	
	// Create connection
	// reemplazar con ("localhost", USUARIO, PASSWORD, NOMBRE_DE_BASE_DE_DATOS)
	include('../../../../php/coneccion.php');
//PROCESA EL FORMATO DE ANGULAR

$nombre = $_GET['nombre'];

    /// verifica que exista una variable tipo POST

   if(!$nombre){
        echo "error";
        exit;
    }
 	///// invocar datos

 	$duplicado = mysqli_query($conexion,"SELECT count(NOMESTADO) as 'conteo'
 										 FROM estadotrabajo
 										 WHERE NOMESTADO LIKE '$nombre'");

	$resultadoOrdenado = array();  

    // el arreglo se popula en este bucle
	while($row = mysqli_fetch_array($duplicado)){
        
        // crea un objeto donde se incluyen los datos del registro
	   	$objetoOrigen = array();
	   	$objetoOrigen["conteo"] = $row['conteo'];	   

	   	/// inserta el objeto con los datos de registro, dentro del arreglo general
	   	array_push($resultadoOrdenado, $objetoOrigen);	   	
	}    
	if($objetoOrigen["conteo"] == 1){
		echo "0";
	}else{    
		$result = mysqli_query($conexion,"INSERT INTO estadotrabajo (NOMESTADO) VALUES ('$nombre')");
		echo $result;
	/*echo json_encode($resultadoOrdenado);*/
	}
?>