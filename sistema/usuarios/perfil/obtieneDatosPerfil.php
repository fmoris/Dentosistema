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
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	$permiso = $request->permiso;	
	$idperfil = $request->idperfil;

/// verifica que exista una variable tipo POST
    if(!$permiso || !$idperfil){
        print_r($_POST);
        exit;
    }

///// invocar datos     
/// invoca los datos de la base de datos 
$result = mysqli_query($conexion,"SELECT RUT,NOMBRE,APELLIDO,CORREO,DIRECCION,CELULAR,TELEFONO 
                                  FROM perfiles
                                  WHERE  IDPERFIL =  '$idperfil' 
                                  AND PERMISOS_IDPERMISO = '$permiso'");

 
$resultadoOrdenado = array();
$row = mysqli_fetch_array($result);
    // crea un objeto donde se incluyen los datos del registro
$resultadoOrdenado["correo"] = $row['CORREO'];
$resultadoOrdenado["direccion"] = $row['DIRECCION'];
$resultadoOrdenado["celular"] = $row['CELULAR'];
$resultadoOrdenado["fono"] = $row['TELEFONO'];
$resultadoOrdenado["rut"] = $row['RUT'];
$resultadoOrdenado["nombre"] = $row['NOMBRE'];
$resultadoOrdenado["apellido"] = $row['APELLIDO'];
    
/// inserta el objeto con los datos de registro, dentro del arreglo general
echo json_encode($resultadoOrdenado);
    
?> 