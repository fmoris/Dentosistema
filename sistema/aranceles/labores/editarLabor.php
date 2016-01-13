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

    $idLabor = $request->info->idLabor;
    $nombre = $request->info->nombre;
    $precio = $request->info->base;
    
    

    if(!$nombre){
        echo "error";
        exit;
    }
    
  
    $result2 = mysqli_query($conexion,"UPDATE labores
                                                   SET VALORLABOR = '$precio',
                                                   DESCRIPCION = '$nombre'
                                                   WHERE IDLABOR = '$idLabor'");
   
  
   foreach ($request->origenes as $item){
    $result3 = mysqli_query($conexion,"UPDATE precios 
                                                   SET VALORLABOR = '$item->precio',
                                                   NOMBRE = '$item->nombre'
                                                   WHERE IDORIGEN = '$item->idOrigen'
                                                   AND IDLABOR = '$idLabor'
                                      ");
    
   
   }
    
   

    
 
    
	echo '{"response":"ok"}';	
	
?>