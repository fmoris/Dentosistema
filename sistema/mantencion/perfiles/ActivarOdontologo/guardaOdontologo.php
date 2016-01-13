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
$apellido = $request->apellido;
$rut = $request->rut;
$direccion = $request->direccion;
$fono = $request->fono;
$celular = $request->celular;
$password = $request->rut;
$correo = $request->correo;
$tipo = $request->tipo;
$id = $request->id;

    /// verifica que exista una variable tipo POST

   if(!$correo){
        echo "error";
        exit;
    }

 	///// invocar datos
 	//Obtener ultimo ID Valido de la tabla odontologo

 		

/* 	if($tipo == 1){

	 	$ultimoodontologo = mysqli_query($conexion,"SELECT max(IDODONTOLOGO+1) as IDODONTOLOGO from odontologo");

	 	$resultadoOrdenado = array();

		// el arreglo se popula en este bucle

		while($row = mysqli_fetch_array($ultimoodontologo)){

		    // crea un objeto donde se incluyen los datos del registro

		    $usuario = array();

		    $usuario["IDPERFIL"] = $row['IDODONTOLOGO'];

		}    

		$idperfil = $usuario["IDPERFIL"];

		/// invoca los datos de la base de datos 

       $result = mysqli_query($conexion,"INSERT INTO perfiles (

       									 IDPERFIL,

       									 PERMISOS_IDPERMISO,

	   									 CORREO,

										 PASSWORD,

										 NOMBRE,

										 APELLIDO,

										 DIRECCION,

										 CELULAR,

										 TELEFONO,

										 RUT)

										 VALUES (

										 '$idperfil',

										 '1',

										 '$correo',

										 '$password',

										 '$nombre',

										 '$apellido',

										 '$direccion',

										 '$celular',

										 '$fono',

										 '$rut')");
   
    /// una vez populado el arreglo general con datos, se convierte a Json
	echo '{"response":"ok"}';
	mysql_close($result);
	exit;
	}*/
	//if($tipo == 2){	 	
	        $result = mysqli_query($conexion,"INSERT INTO perfiles (
	       									 IDPERFIL,
	       									 PERMISOS_IDPERMISO,
		   									 CORREO,
											 PASSWORD,
											 NOMBRE,
											 APELLIDO,
											 DIRECCION,
											 CELULAR,
											 TELEFONO,
											 RUT)
											 VALUES (
											 '$id',
											 '1',
											 '$correo',
											 '$password',
											 '$nombre',
											 '$apellido',
											 '$direccion',
											 '$celular',
											 '$fono',
											 '$rut')");	    

	    /// una vez populado el arreglo general con datos, se convierte a Json
		echo '{"response":"ok"}';		
		exit;

 //	}		

?>