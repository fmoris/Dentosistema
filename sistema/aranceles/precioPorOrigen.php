<?

//// EJEMPLO USANDO CORS!!
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
/// CONECTA A LA BASE DE DATOS
	
	// Create connection
	// reemplazar con ("localhost", USUARIO, PASSWORD, NOMBRE_DE_BASE_DE_DATOS)
	//$conexion=mysqli_connect("localhost","root","","dentosys");
    include('../../php/coneccion.php');

    $idLabor = $_GET['labor']; 
    $result = mysqli_query($conexion,"SELECT IDORIGEN,INSTITUCION, OBSOLETO from origen");



    /// crea un arreglo general vacio
    $resultadoOrdenado = array();
    // el arreglo se popula en este bucle
    while($row = mysqli_fetch_array($result)){
        // crea un objeto donde se incluyen los datos del registro
        $objetoOrigen = array();
        $objetoOrigen['idOrigen'] = $row['IDORIGEN'];
        $origen = $objetoOrigen['idOrigen'];
        $objetoOrigen['nombreOrigen'] = $row['INSTITUCION'];
        $objetoOrigen['obsoleto'] = $row['OBSOLETO'];
        if ($idLabor == 0){
            $objetoOrigen['precio'] = 0;
           
        }
        else{
            $result2 = mysqli_query($conexion, "SELECT VALORLABOR, NOMBRE, ACTIVO
                                               FROM precios
                                               WHERE IDLABOR = '$idLabor'
                                               AND IDORIGEN = '$origen'");
            $row2 = mysqli_fetch_array($result2);
            $objetoOrigen['precio'] = $row2['VALORLABOR'];
            $objetoOrigen['nombre'] = $row2['NOMBRE'];
            $objetoOrigen['activo'] = $row2['ACTIVO'];
            
            
        }

    
            

    /// inserta el objeto con los datos de registro, dentro del arreglo general
    array_push($resultadoOrdenado, $objetoOrigen);
    }
    
	echo json_encode($resultadoOrdenado);
	
	
?>