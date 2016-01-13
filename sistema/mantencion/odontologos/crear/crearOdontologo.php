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

$nombre = $request->nombre;
$rut = $request->rut;
$celular = $request->celular;
$correo = $request->correo;

    /// verifica que exista una variable tipo POST

   if(!$correo){
        echo "error";
        exit;
    }
 	///// invocar datos
 	//Obtener ultimo ID Valido de la tabla odontologo    	
		
		$ultimoodontologo = mysqli_query($conexion,"SELECT MAX( IDODONTOLOGO +1 ) as IDODONTOLOGO
													FROM odontologo");

	 	/*$ultimoodontologo = mysqli_query($conexion,"SELECT MAX( IDPERFIL +1 ) AS IDODONTOLOGO
													FROM perfiles
													WHERE PERMISOS_IDPERMISO =1");*/
	 	$resultadoOrdenado = array();
		// el arreglo se popula en este bucle
		while($row = mysqli_fetch_array($ultimoodontologo)){
		    // crea un objeto donde se incluyen los datos del registro
		    $usuario = array();
		    $usuario["IDPERFIL"] = $row['IDODONTOLOGO'];
		}    
		$idperfil = $usuario["IDPERFIL"];

		/// invoca los datos de la base de datos 
       $result = mysqli_query($conexion,"INSERT INTO odontologo (
       									 IDODONTOLOGO,
       									 ESALUMNO,
										 RUT,
										 NOMBREOD,
										 DIRECCION,
	   									 FONO,										 
										 CODIGOOD,
										 ACTIVO)										 
										 VALUES (
										 '$idperfil',
										 NULL,										 
										 '$rut',
										 '$nombre',										 
										 '$correo',										 
										 '$celular',
										 NULL,
										 NULL)");
   
    /// una vez populado el arreglo general con datos, se convierte a Json
	echo $result;	
	exit;
?>