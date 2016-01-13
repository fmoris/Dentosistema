<?
/// NO USAR DIRECTAMENTE SOLO DENTRO DE UN SERVIDOR PHP
//// EJEMPLO USANDO CORS!!
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
/// CONECTA A LA BASE DE DATOS  
// Create connection
// reemplazar con ("localhost", USUARIO, PASSWORD, NOMBRE_DE_BASE_DE_DATOS)
include('../../../php/coneccion.php');

//Traer Datos
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$permiso = $request->permiso;   
$idperfil = $request->idperfil;
$password  = $request->password;

/// verifica que exista una variable tipo POST
    if(!$password || !$idperfil || !$password){
        //print_r($_POST);
        echo "error";
        exit;
    }

///// invocar datos     
/// invoca los datos de la base de datos 
$result = mysqli_query($conexion,"UPDATE perfiles 
                                  SET PASSWORD =  '$password'
                                  WHERE  IDPERFIL =  '$idperfil' 
                                  AND PERMISOS_IDPERMISO = '$permiso'");
if(!$result) {
	echo "error";
    die('Contraseña no coinciden' . mysql_error());
} 
 
    
?>