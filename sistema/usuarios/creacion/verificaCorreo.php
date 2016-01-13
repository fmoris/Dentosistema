<?
//// EJEMPLO USANDO CORS!!
//header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Methods: GET, POST');
//header("Access-Control-Allow-Headers: X-Requested-With");
/// CONECTA A LA BASE DE DATOS	
	// Create connection
	// reemplazar con ("localhost", USUARIO, PASSWORD, NOMBRE_DE_BASE_DE_DATOS)
	//$conexion=mysqli_connect("localhost","root","","dentosys");
    include('../../../php/coneccion.php');
  
  
    /// verifica que exista una variable tipo GET
    /*if(!$_GET['platoID']){
        echo("debes incluir una variable GET : http://carlossolis.mobi/cursos/itmaster/ws/detalles.php?platoID=99");
        exit;
    }*/

 $correo = $_GET['correo'];
 	///// invocar datos
 	
 	/// invoca los datos de la base de datos 
 	$result = mysqli_query($conexion,"SELECT COUNT(CORREO) as CORREO
									  FROM perfiles
									  WHERE CORREO = '$correo'");

 	/// crea un arreglo general vacio
 	$resultadoOrdenado = array();  

    // el arreglo se popula en este bucle
	while($row = mysqli_fetch_array($result)){
        
        // crea un objeto donde se incluyen los datos del registro
	   	$objetoOrigen = array();
	   	$objetoOrigen["correo"] = $row['CORREO'];
	   

	   	/// inserta el objeto con los datos de registro, dentro del arreglo general
	   	array_push($resultadoOrdenado, $objetoOrigen);

	}    
	if($objetoOrigen["correo"] == 1){
		echo "1";
	}else{    
		echo "0";
	//echo json_encode($resultadoOrdenado);
	}
	
	
?>