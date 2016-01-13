<?

//// EJEMPLO USANDO CORS!!
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
/// CONECTA A LA BASE DE DATOS
	
	// Create connection
	// reemplazar con ("localhost", USUARIO, PASSWORD, NOMBRE_DE_BASE_DE_DATOS)
	//$conexion=mysqli_connect("localhost","root","","dentosys");
  include('../../../php/coneccion.php');


	// revisa si la conexion es correcta
	if (mysqli_connect_errno($conexion)) {
		echo "error en la conexion a base de datos: " . mysqli_connect_error();
	}
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    $nombre = $request->nombre;
    $clasi = $request->clasi;
    

    if(!$nombre){
        echo "error";
        exit;
    }
    
   $result2 = mysqli_query($conexion,"SELECT max(IDETAPA) as IDETAPA  FROM etapas");
   $etapa = mysqli_fetch_array($result2)['IDETAPA'];
   $etapa = $etapa+1;
   $result = mysqli_query($conexion,"INSERT INTO etapas (NOMETAPA, IDETAPA, CLASIFICACION) VALUES ('$nombre','$etapa','$clasi')");

   

    
   

    
 
    
	echo '{"response":"ok"}';	
	
?>