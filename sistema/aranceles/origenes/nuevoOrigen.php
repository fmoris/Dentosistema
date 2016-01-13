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
    
    echo $nombre;


    if(!$nombre){
        echo "error";
        exit;
    }
    
   $result2 = mysqli_query($conexion,"SELECT max(IDORIGEN) as IDORIGEN  FROM origen");
   $origen = mysqli_fetch_array($result2)['IDORIGEN'];
   $origen = $origen+1;
   $result = mysqli_query($conexion,"INSERT INTO origen (INSTITUCION, IDORIGEN) VALUES ('$nombre',$origen)");

   
  
   foreach ($request->datos as $item){
       //echo $item->clasificacion;
       foreach($item->etapas as $item2){
           //echo $item2->nombreEtapa;
           foreach($item2->labores as $item3){
               //echo $item3->nombreLabor;
               //echo $item3->precio;
                $result3 = mysqli_query($conexion,"INSERT INTO precios (IDORIGEN,IDLABOR,VALORLABOR, ACTIVO) 
                                                  VALUES('$origen', '$item3->idLabor','$item3->precio', '$item3->activo')");
           }
       }
   }
    
   

    
 
    
	echo '{"response":"ok"}';	
	
?>