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
  
  
    /// verifica que exista una variable tipo GET
    /*if(!$_GET['platoID']){
        echo("debes incluir una variable GET : http://carlossolis.mobi/cursos/itmaster/ws/detalles.php?platoID=99");
        exit;
    }*/

 $idorden = $_GET['idorden'];
 $clasificacion = $_GET['clasificacion'];
 	///// invocar datos
 	
 	/// invoca los datos de la base de datos 
 	$result = mysqli_query($conexion,"SELECT trabajo.numorden as numorden,
 											labores.descripcion as descripcion,
 											trabajo.estado as estado,
 											trabajo.iniciolabor as iniciolabor,
 											trabajo.finlabor as finlabor,
 											trabajo.valortrabajo as valortrabajo
											FROM trabajo, labores
											WHERE trabajo.numorden like '$idorden'
											AND trabajo.clasificacion like '$clasificacion'
											AND trabajo.IDLABOR = labores.IDLABOR");

 	/// crea un arreglo general vacio
 	$resultadoOrdenado = array();  

    // el arreglo se popula en este bucle
	while($row = mysqli_fetch_array($result)){
        
        // crea un objeto donde se incluyen los datos del registro
	   	$objetoOrigen = array();
	   	$objetoOrigen["numorden"] = $row['numorden'];
	   	$objetoOrigen["descripcion"] = $row['descripcion'];
	   	$objetoOrigen["estado"] = $row['estado'];
	   	$objetoOrigen["iniciolabor"] = $row['iniciolabor'];
	   	$objetoOrigen["finlabor"] = $row['finlabor'];
	   	$objetoOrigen["valortrabajo"] = $row['valortrabajo'];
	   

	   	/// inserta el objeto con los datos de registro, dentro del arreglo general
	   	array_push($resultadoOrdenado, $objetoOrigen);

	}	
	echo json_encode($resultadoOrdenado);	
	
?>