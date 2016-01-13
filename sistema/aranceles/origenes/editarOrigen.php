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

    $nombre = $request->origen->nombre;
    $origen = $request->origen->idOrigen;
    $telefono = $request->origen->telefono;
    $correo = $request->origen->correo;
    $obsoleto = $request->origen->obsoleto;

    if(!$nombre){
        echo "error";
        exit;
    }

   $result = mysqli_query($conexion,"UPDATE origen
                                     SET INSTITUCION='$nombre',
                                     TELEFONO = '$telefono',
                                     CONTACTO = '$correo',
                                     OBSOLETO = '$obsoleto'
                                     WHERE IDORIGEN='$origen'");

   
  
   foreach ($request->datos as $item){
       //echo $item->clasificacion;
       foreach($item->etapas as $item2){
           //echo $item2->nombreEtapa;
           foreach($item2->labores as $item3){
               //echo $item3->nombreLabor;
               //echo $item3->precio;
                $result3 = mysqli_query($conexion,"UPDATE precios 
                                                   SET VALORLABOR = '$item3->precio',
                                                   NOMBRE = '$item3->nombreEspecial',
                                                   ACTIVO = '$item3->activo'
                                                   WHERE IDORIGEN = '$origen'
                                                   AND IDLABOR = '$item3->idLabor'");
           }
       }
   }
    
   

    
 
    
	//echo '{"response":"ok"}';	
	
?>