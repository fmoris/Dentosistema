<?
/// NO USAR DIRECTAMENTE SOLO DENTRO DE UN SERVIDOR PHP
//// EJEMPLO USANDO CORS!!
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
/// CONECTA A LA BASE DE DATOS	
// Create connection
// reemplazar con ("localhost", USUARIO, PASSWORD, NOMBRE_DE_BASE_DE_DATOS)
$conexion=mysqli_connect("localhost","dentosis_admin","admin2dent4bdd","dentosis_dentobd");
// revisa si la conexion es correcta
if (mysqli_connect_errno($conexion)) {
    echo "error en la conexion a base de datos: " . mysqli_connect_error();
}

/// verifica que exista una variable tipo POST
    /*if(!$correo){
        print_r($_POST);
        exit;
    }*/
///// invocar datos 	
/// invoca los datos de la base de datos 
$result = mysqli_query($conexion,"SELECT IDODONTOLOGO,NOMBREOD,RUT,DIRECCION,FONO,EMAIL
                                  FROM odontologo
                                  ORDER BY NOMBREOD");

/// crea un arreglo general vacio
$resultadoOrdenado = array();
// el arreglo se popula en este bucle
while($row = mysqli_fetch_array($result)){
    // crea un objeto donde se incluyen los datos del registro
    $usuario = array();
    $usuario["id"] = $row['IDODONTOLOGO'];
    $usuario["nombre"] = $row['NOMBREOD'];
	$usuario["rut"] = $row['RUT'];
    $usuario["direccion"] = $row['DIRECCION']; 
    $usuario["fono"] = $row['FONO']; 
    $usuario["email"] = $row['EMAIL']; 
    
/// inserta el objeto con los datos de registro, dentro del arreglo general
    array_push($resultadoOrdenado, $usuario);
}   
/// una vez populado el arreglo general con datos, se convierte a Json
    echo json_encode($resultadoOrdenado);

	
	
?>