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
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    $nombre = $request->nombre;
    $precio = $request->precio;
    $origen = $request->origen;
    //$labores = $request->labores;
    

    if(!$nombre){
        echo "error";
        exit;
    }
     
    $result = mysqli_query($conexion,"INSERT INTO convenios (NOMCONVENIO, IDORIGEN, PRECIO) VALUES ('$nombre','$origen','$precio')");
    $result2 = mysqli_query($conexion,"SELECT max(IDCONVENIO) as IDCONVENIO  FROM convenios");
    $idConvenio = mysqli_fetch_array($result2)['IDCONVENIO'];

   /* foreach ($labores as $labor){
        $idLabor = $labor->id;
        $result = mysqli_query($conexion,"INSERT INTO infoconvenio (IDCONVENIO, IDLABOR) VALUES ('$idConvenio','$idLabor')");
    }*/

   

    
   

    
 
    
	echo '{"response":"ok"}';	
	
?>