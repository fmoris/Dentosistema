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

$nombrecompleto = $request->nombre;
$rut = $request->rut;
$direccion = $request->direccion;
$fono = $request->fono;
$celular = $request->celular;
$password = $request->password;
$correo = $request->correo;

echo $rut;

    /// verifica que exista una variable tipo POST
    if(!$rut){
        echo "error";
		
        exit;
    }
  
 	///// invocar datos
 	
 	/// invoca los datos de la base de datos 
       $result = mysqli_query($conexion,"INSERT INTO usuario (
	   									 rut,
										 password,
										 nombrecompleto,
										 correo,
										 fono,
										 celular,
										 es_ejecutor)
										 VALUES (
										 '$rut',
										 '$password',
										 '$nombrecompleto',
										 '$correo',
										 '$fono',
										 '$celular'
										 ,'1'
										 )");
    
    /// una vez populado el arreglo general con datos, se convierte a Json
	echo '{"response":"ok"}';	
	
?>