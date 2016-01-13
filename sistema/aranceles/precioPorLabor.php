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

    $origen = $_GET['origen'];  
    //echo $origen;
    
//exit;
  
  
    /// verifica que exista una variable tipo GET
    /*if(!$_GET['platoID']){
        echo("debes incluir una variable GET : http://carlossolis.mobi/cursos/itmaster/ws/detalles.php?platoID=99");
        exit;
    }*/

  
 	///// invocar datos
 	
 	/// invoca los datos de la base de datos 
 	//$result = mysqli_query($conexion,"SELECT nombre_labor, idLabor FROM Labor WHERE Etapa_idEtapa Like '$etapa'"); 
    $result = mysqli_query($conexion,"SELECT DISTINCT CLASIFICACION from etapas");

    //$result = mysqli_query($conexion,"SELECT DISTINCT Etapa_idEtapa from Labor");
    $clasi = array();
    while($row = mysqli_fetch_array($result)){
        array_push($clasi, $row['CLASIFICACION']);
    }
    
        

 	// crea un arreglo general vacio
 	$resultadoOrdenado = array();

    foreach($clasi as $val){
        $objetoOrigen = array();
        $objetoOrigen["idOrigen"] = $origen;        
        $objetoOrigen["etapas"]= array();        
        //echo $val;
        switch ($val) {
            case 1:
                $objetoOrigen["clasificacion"] = "Protesis Fija";
                break;
            case 2:
                $objetoOrigen["clasificacion"] = "Colados";
                break;
            case 3:
                $objetoOrigen["clasificacion"] = "Removibles";
                break;
        }         
        $result = mysqli_query($conexion,"SELECT NOMETAPA,IDETAPA,OBSOLETO from etapas WHERE CLASIFICACION LIKE '$val'");
            while($row = mysqli_fetch_array($result)){

                // crea un objeto donde se incluyen los datos del registro
                $objetoOrigen2 = array();
                $objetoOrigen2["nombreEtapa"] = $row['NOMETAPA'];
                $objetoOrigen2["idEtapa"] = $row['IDETAPA'];
                $objetoOrigen2["obsoleto"] = $row['OBSOLETO'];
                $objetoOrigen2["labores"] = array();
                $idEtapa = $row['IDETAPA'];
                //echo $idEtapa;
                if ($origen == 0){
                    $result2 = mysqli_query($conexion,"SELECT labores.DESCRIPCION,labores.IDLABOR, labores.OBSOLETO 
                                                       FROM labores
                                                       WHERE labores.IDETAPA LIKE '$idEtapa'
                                                       ");

                    while($row = mysqli_fetch_array($result2)){

                        // crea un objeto donde se incluyen los datos del registro
                        $objetoOrigen3 = array();
                        $objetoOrigen3["nombre"] = $row['DESCRIPCION'];	
                        $objetoOrigen3["idLabor"] = $row['IDLABOR'];
                        $objetoOrigen3["precio"] = 0;
                        $objetoOrigen3["obsoleto"] = $row['OBSOLETO'];

                        array_push($objetoOrigen2["labores"], $objetoOrigen3);

                    }
                }
                else{
                    $result2 = mysqli_query($conexion,"SELECT DESCRIPCION,labores.IDLABOR,precios.VALORLABOR, precios.NOMBRE, precios.ACTIVO, labores.OBSOLETO
                                                       FROM (labores LEFT JOIN precios
                                                       ON  labores.IDLABOR = precios.IDLABOR
                                                       AND precios.IDORIGEN = '$origen')
                                                       WHERE labores.IDETAPA = '$idEtapa' 
                                                       
                                                       ");

                    while($row = mysqli_fetch_array($result2)){

                        // crea un objeto donde se incluyen los datos del registro
                        $objetoOrigen3 = array();
                        $objetoOrigen3["nombre"] = $row['DESCRIPCION'];
                        $objetoOrigen3["obsoleto"] = $row['OBSOLETO'];
                        $objetoOrigen3["nombreEspecial"] = $row['NOMBRE'];
                        $objetoOrigen3["idLabor"] = $row['IDLABOR'];
                        $objetoOrigen3["precio"] = $row['VALORLABOR'];
                        $objetoOrigen3["activo"] = $row['ACTIVO'];

                        array_push($objetoOrigen2["labores"], $objetoOrigen3);

                    }
                }
                array_push($objetoOrigen["etapas"], $objetoOrigen2);
                
        }
        array_push($resultadoOrdenado, $objetoOrigen);
	}    
    /// una vez populado el arreglo general con datos, se convierte a Json
	echo json_encode($resultadoOrdenado);
	
	
?>