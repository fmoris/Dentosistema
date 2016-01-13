<?

//// EJEMPLO USANDO CORS!!
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
/// CONECTA A LA BASE DE DATOS
	
	// Create connection
	// reemplazar con ("localhost", USUARIO, PASSWORD, NOMBRE_DE_BASE_DE_DATOS)
	//$conexion=mysqli_connect("localhost","root","","dentosys");
    /*$conexion=mysqli_connect("localhost","dentosis_admin","admin2dent4bdd","dentosis_dentobd");*/
    include('../../../php/coneccion.php');
    	
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    foreach ($request as $metal){
         if ($metal->editar == true){
             $nombre = $metal->nombre;
             $idMetal = $metal->id;
             $precio = $metal->precio;
             $obsoleto = $metal->obsoleto;
               // echo $nombreEtapa;
                $result = mysqli_query($conexion,"UPDATE metales 
                                     SET NOMMETAL = '$nombre',
                                     OBSOLETO = '$obsoleto',
                                     VALORGRAMO = '$precio'
                                     WHERE IDMETAL = '$idMetal'");
            }
        
            
    }
   
      
    
    
/*
   $result = mysqli_query($conexion,"UPDATE etapas 
                                     SET NOMETAPA = '$nombre'
                                     WHERE IDETAPA = '$etapa'");

   */

    
   

    
 
    
	echo '{"response":"ok"}';	
	
?>