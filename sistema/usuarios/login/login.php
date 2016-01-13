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

$correo = $_GET['correo'];
$password = $_GET['password'];

/// verifica que exista una variable tipo POST
    /*if(!$correo){
        print_r($_POST);
        exit;
    }*/
///// invocar datos 	
/// invoca los datos de la base de datos 
$result = mysqli_query($conexion,"SELECT IDPERFIL,NOMBRE,CORREO,PERMISOS_IDPERMISO FROM perfiles WHERE CORREO like '$correo' AND PASSWORD LIKE '$password'");

/// crea un arreglo general vacio
$resultadoOrdenado = array();
// el arreglo se popula en este bucle
while($row = mysqli_fetch_array($result)){
    // crea un objeto donde se incluyen los datos del registro
    $usuario = array();
    $usuario["id"] = $row['IDPERFIL'];
    $usuario["nombre"] = $row['NOMBRE'];
	$usuario["permiso"] = $row['PERMISOS_IDPERMISO'];  
    
/// inserta el objeto con los datos de registro, dentro del arreglo general
    array_push($resultadoOrdenado, $usuario);
}    

 if (sizeof($resultadoOrdenado) == 1){
    echo json_encode($resultadoOrdenado);
 }else{
    echo 0;
 }

/// una vez populado el arreglo general con datos, se convierte a Json

	
	
?>