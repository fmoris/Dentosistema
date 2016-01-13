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
    $etapa = $request->etapa;
    

    if(!$nombre){
        echo "error";
        exit;
    }
    
   $result2 = mysqli_query($conexion,"SELECT max(IDLABOR) as IDLABOR  FROM labores");
   $labor = mysqli_fetch_array($result2)['IDLABOR'];
   $labor = $labor+1;
   $result = mysqli_query($conexion,"INSERT INTO labores (DESCRIPCION, IDLABOR, IDETAPA) VALUES ('$nombre',$labor, $etapa)");

   
  
   foreach ($request->origenes as $item){
    $result3 = mysqli_query($conexion,"INSERT INTO precios (IDORIGEN,IDLABOR,VALORLABOR, NOMBRE) 
                                                  VALUES('$item->idOrigen','$labor','$item->precio', '$nombre')");
         
   }
    
   

    
 
    
	echo '{"response":"ok"}';	
	
?>