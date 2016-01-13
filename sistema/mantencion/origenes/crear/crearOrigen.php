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

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$institucion = $request->institucion;
$direccion = $request->direccion;
$telefono = $request->telefono;
$contacto = $request->contacto;										 

    /// verifica que exista una variable tipo POST

   if(!$institucion){
        echo "error";
        exit;
    }
 	///// invocar datos
 	//Obtener ultimo ID Valido de la tabla odontologo    	
		
		$ultimoorigen = mysqli_query($conexion,"SELECT MAX( IDORIGEN +1 ) as IDORIGEN
												FROM origen");

	 	/*$ultimoodontologo = mysqli_query($conexion,"SELECT MAX( IDPERFIL +1 ) AS IDODONTOLOGO
													FROM perfiles
													WHERE PERMISOS_IDPERMISO =1");*/
	 	$resultadoOrdenado = array();
		// el arreglo se popula en este bucle
		while($row = mysqli_fetch_array($ultimoorigen)){
		    // crea un objeto donde se incluyen los datos del registro
		    $usuario = array();
		    $usuario["IDPERFIL"] = $row['IDORIGEN'];
		}    
		$idperfil = $usuario["IDPERFIL"];

		/// invoca los datos de la base de datos 
       $result = mysqli_query($conexion,"INSERT INTO origen (
       									 IDORIGEN,
       									 INSTITUCION,
										 DIRECCION,
										 TELEFONO,
										 CONTACTO)										 
										 VALUES (
										 '$idperfil',
										 '$institucion',										 
										 '$direccion',
										 '$telefono',										 
										 '$contacto')");
   
    /// una vez populado el arreglo general con datos, se convierte a Json
	echo $result;	
	exit;
?>