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

    foreach ($request as $objetoClasi){
        $clasi = $objetoClasi->id;
        foreach ($objetoClasi->etapas as $objetoEtapa){
            $idEtapa = $objetoEtapa->id;
            $obsEtapa = $objetoEtapa->obsoleto;
            $nombreEtapa = $objetoEtapa->nombre;
            if ($objetoEtapa->editar == true){
               // echo $nombreEtapa;
                $result = mysqli_query($conexion,"UPDATE etapas 
                                     SET NOMETAPA = '$nombreEtapa',
                                     OBSOLETO = '$obsEtapa'
                                     WHERE IDETAPA = '$idEtapa'");
            }
            foreach ($objetoEtapa->labores as $objetoLabor){
                $idLabor = $objetoLabor->id;
                $obsLabor = $objetoLabor->obsoleto;
                $nombreLabor = $objetoLabor->nombre;
                if ($objetoLabor->editar == true){
                  //  echo $nombreLabor;
                    $result = mysqli_query($conexion,"UPDATE labores 
                                     SET DESCRIPCION = '$nombreLabor',
                                     OBSOLETO = '$obsLabor'
                                     WHERE IDLABOR = '$idLabor'");
                    if ($obsLabor == '1'){
                    $result = mysqli_query($conexion,"UPDATE precios 
                                     SET ACTIVO = 0
                                     WHERE IDLABOR = '$idLabor'");
                    }
                    
                }
            }
            
        }
    }
      
    
    
/*
   $result = mysqli_query($conexion,"UPDATE etapas 
                                     SET NOMETAPA = '$nombre'
                                     WHERE IDETAPA = '$etapa'");

   */

    
   

    
 
    
	echo '{"response":"ok"}';	
	
?>