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

$result = mysqli_query($conexion,"SELECT IDORIGEN,INSTITUCION from origen
								  WHERE IDORIGEN not IN (
								  SELECT IDPERFIL FROM perfiles WHERE PERMISOS_IDPERMISO = 2)");



/// crea un arreglo general vacio
$resultadoOrdenado = array();
// el arreglo se popula en este bucle
while($row = mysqli_fetch_array($result)){
    // crea un objeto donde se incluyen los datos del registro
    $usuario = array();
    $usuario["id"] = $row['IDORIGEN'];
    $usuario["nombre"] = $row['INSTITUCION'];	
    
/// inserta el objeto con los datos de registro, dentro del arreglo general
    array_push($resultadoOrdenado, $usuario);
}   

    echo json_encode($resultadoOrdenado);
 
/// una vez populado el arreglo general con datos, se convierte a Json

	
	
?>