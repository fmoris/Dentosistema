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
    $id = $_GET['id'];
	$permiso = $_GET['permiso'];
  
 	///// invocar datos
 	
 	/// invoca los datos de la base de datos 
 	switch ($permiso){
 		case '1':
 			$result = mysqli_query($conexion,"SELECT distinct NUMORDEN,NOMCLASIF,PACIENTE,FECHARECEPCION,FECHAENTREGA,ESTADO,PAGADO,INSTITUCION,CLASIFICACION,TOTALORDEN
 										  FROM orden,clasificacion, origen 
 										  WHERE IDODONTOLOGO = $id 
 										  AND orden.IDORIGEN = origen.IDORIGEN
 										  AND orden.CLASIFICACION = clasificacion.IDCLASIF
 										  AND orden.ANULACION IS NULL
 										  ORDER BY FECHARECEPCION DESC");
 			/// crea un arreglo general vacio
		 	$resultadoOrdenado = array();  

		    // el arreglo se popula en este bucle
			while($row = mysqli_fetch_array($result)){
		        
		        // crea un objeto donde se incluyen los datos del registro
			   	$objetoOrigen = array();
			   	$objetoOrigen["orden"] = $row['NUMORDEN'];	 
		        $objetoOrigen["clasificacion"] = $row['NOMCLASIF'];
				$objetoOrigen["paciente"] = $row['PACIENTE'];
				$objetoOrigen["recepcion"] = $row['FECHARECEPCION'];
				$objetoOrigen["entrega"] = $row['FECHAENTREGA'];
				$objetoOrigen["estado"] = $row['ESTADO'];
				$objetoOrigen["pagado"] = $row['PAGADO'];
				$objetoOrigen["institucion"] = $row['INSTITUCION'];
				$objetoOrigen["idclasificacion"] = $row['CLASIFICACION'];
				$objetoOrigen["totalorden"] = $row['TOTALORDEN'];			

			   	/// inserta el objeto con los datos de registro, dentro del arreglo general
			   	array_push($resultadoOrdenado, $objetoOrigen);

			}    
		    /// una vez populado el arreglo general con datos, se convierte a Json
			echo json_encode($resultadoOrdenado);
 		break;
 		case '2':
 			$result = mysqli_query($conexion,"SELECT distinct NUMORDEN,NOMBREOD,NOMCLASIF,PACIENTE,FECHARECEPCION,FECHAENTREGA,ESTADO,PAGADO,CLASIFICACION,TOTALORDEN
											  FROM orden,clasificacion,odontologo,origen
											  WHERE odontologo.IDODONTOLOGO = orden.IDODONTOLOGO
											  AND orden.clasificacion = clasificacion.IDCLASIF
											  AND orden.ANULACION IS NULL
											  AND orden.IDORIGEN = $id");
 			/// crea un arreglo general vacio
		 	$resultadoOrdenado = array();  

		    // el arreglo se popula en este bucle
			while($row = mysqli_fetch_array($result)){
		        
		        // crea un objeto donde se incluyen los datos del registro
			   	$objetoOrigen = array();
			   	$objetoOrigen["orden"] = $row['NUMORDEN'];
			   	$objetoOrigen["odontologo"] = $row['NOMBREOD'];	 
		        $objetoOrigen["clasificacion"] = $row['NOMCLASIF'];
				$objetoOrigen["paciente"] = $row['PACIENTE'];
				$objetoOrigen["recepcion"] = $row['FECHARECEPCION'];
				$objetoOrigen["entrega"] = $row['FECHAENTREGA'];
				$objetoOrigen["estado"] = $row['ESTADO'];
				$objetoOrigen["pagado"] = $row['PAGADO'];
				$objetoOrigen["idclasificacion"] = $row['CLASIFICACION'];
				$objetoOrigen["totalorden"] = $row['TOTALORDEN'];


			   	/// inserta el objeto con los datos de registro, dentro del arreglo general
			   	array_push($resultadoOrdenado, $objetoOrigen);

			}    
		    /// una vez populado el arreglo general con datos, se convierte a Json
			echo json_encode($resultadoOrdenado);
 		break;
 		case '99':
 			$result = mysqli_query($conexion,"SELECT distinct NUMORDEN,NOMBREOD,NOMCLASIF,PACIENTE,FECHARECEPCION,FECHAENTREGA,ESTADO,PAGADO,INSTITUCION 
											  FROM orden,clasificacion,odontologo,origen
											  WHERE odontologo.IDODONTOLOGO = orden.IDODONTOLOGO
											  AND orden.clasificacion = clasificacion.IDCLASIF
											  AND orden.IDORIGEN = origen.IDORIGEN");
 			/// crea un arreglo general vacio
		 	$resultadoOrdenado = array();  

		    // el arreglo se popula en este bucle
			while($row = mysqli_fetch_array($result)){
		        
		        // crea un objeto donde se incluyen los datos del registro
			   	$objetoOrigen = array();
			   	$objetoOrigen["orden"] = $row['NUMORDEN'];
			   	$objetoOrigen["odontologo"] = $row['NOMBREOD'];	 
		        $objetoOrigen["clasificacion"] = $row['NOMCLASIF'];
				$objetoOrigen["paciente"] = $row['PACIENTE'];
				$objetoOrigen["recepcion"] = $row['FECHARECEPCION'];
				$objetoOrigen["entrega"] = $row['FECHAENTREGA'];
				$objetoOrigen["estado"] = $row['ESTADO'];
				$objetoOrigen["pagado"] = $row['PAGADO'];
				$objetoOrigen["institucion"] = $row['INSTITUCION'];

			   	/// inserta el objeto con los datos de registro, dentro del arreglo general
			   	array_push($resultadoOrdenado, $objetoOrigen);

			}    
		    /// una vez populado el arreglo general con datos, se convierte a Json
			echo json_encode($resultadoOrdenado);
 		break;
 		default:
 		 echo 0;

	}
 	
	
	
?>