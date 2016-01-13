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

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $resultadoOrdenado = array();
    $objetoPF = array();
    $objetoPF["nombre"] = "Protesis Fija";
    $objetoPF["idClasi"] = 1;
    $objetoPF["etapas"] = array();
    $queryPF = mysqli_query($conexion,"SELECT IDETAPA, NOMETAPA, OBSOLETO from etapas WHERE CLASIFICACION = 1");
    while($row = mysqli_fetch_array($queryPF)){
        $objetoEtapa = array();
        $idEtapa = $objetoEtapa["id"] = $row["IDETAPA"];
        $objetoEtapa["nombre"] = $row["NOMETAPA"];
        $objetoEtapa["id"] = $row["IDETAPA"];
        $objetoEtapa["obsoleto"] = $row["OBSOLETO"];
        $objetoEtapa["editar"] = false;
        $objetoEtapa["detalles"] = false;
        $objetoEtapa["labores"] = array();
        $queryLabores = mysqli_query($conexion,"SELECT IDLABOR, DESCRIPCION, OBSOLETO from labores WHERE IDETAPA = '$idEtapa'");
        while($row2 = mysqli_fetch_array($queryLabores)){
            $objetoLabor= array();
            $objetoLabor["nombre"] = $row2["DESCRIPCION"];
            $objetoLabor["id"] = $row2["IDLABOR"];
            $objetoLabor["obsoleto"] = $row2["OBSOLETO"];
            $objetoLabor["editar"] = false;
            array_push($objetoEtapa["labores"], $objetoLabor);
        }
        array_push($objetoPF["etapas"], $objetoEtapa);
    }
    $objetoCO = array();
    $objetoCO["nombre"] = "Colados";
    $objetoCO["idClasi"] = 2;
    $objetoCO["etapas"] = array();
    $queryCO = mysqli_query($conexion,"SELECT IDETAPA, NOMETAPA,OBSOLETO from etapas WHERE CLASIFICACION = 2");
    while($row = mysqli_fetch_array($queryCO)){
        $objetoEtapa = array();
        $idEtapa = $objetoEtapa["id"] = $row["IDETAPA"];
        $objetoEtapa["nombre"] = $row["NOMETAPA"];
        $objetoEtapa["id"] = $row["IDETAPA"];
        $objetoEtapa["obsoleto"] = $row["OBSOLETO"];
        $objetoEtapa["editar"] = false;
        $objetoEtapa["detalles"] = false;
        $objetoEtapa["labores"] = array();
        $queryLabores = mysqli_query($conexion,"SELECT IDLABOR, DESCRIPCION, OBSOLETO from labores WHERE IDETAPA = '$idEtapa'");
        while($row2 = mysqli_fetch_array($queryLabores)){
            $objetoLabor= array();
            $objetoLabor["nombre"] = $row2["DESCRIPCION"];
            $objetoLabor["id"] = $row2["IDLABOR"];
            $objetoLabor["obsoleto"] = $row2["OBSOLETO"];
            array_push($objetoEtapa["labores"], $objetoLabor);
        }
        array_push($objetoCO["etapas"], $objetoEtapa);
    }
    $objetoRE = array();
    $objetoRE["nombre"] = "Removibles";
    $objetoRE["idClasi"] = 3;
    $objetoRE["etapas"] = array();
    $queryRE = mysqli_query($conexion,"SELECT IDETAPA, NOMETAPA, OBSOLETO from etapas WHERE CLASIFICACION = 3");
    while($row = mysqli_fetch_array($queryRE)){
        $objetoEtapa = array();
        $idEtapa = $objetoEtapa["id"] = $row["IDETAPA"];
        $objetoEtapa["nombre"] = $row["NOMETAPA"];
        $objetoEtapa["id"] = $row["IDETAPA"];
        $objetoEtapa["obsoleto"] = $row["OBSOLETO"];
        $objetoEtapa["editar"] = false;
        $objetoEtapa["detalles"] = false;
        $objetoEtapa["labores"] = array();
        $queryLabores = mysqli_query($conexion,"SELECT IDLABOR, DESCRIPCION, OBSOLETO from labores WHERE IDETAPA = '$idEtapa'");
        while($row2 = mysqli_fetch_array($queryLabores)){
            $objetoLabor= array();
            $objetoLabor["nombre"] = $row2["DESCRIPCION"];
            $objetoLabor["id"] = $row2["IDLABOR"];
            $objetoLabor["obsoleto"] = $row2["OBSOLETO"];
            array_push($objetoEtapa["labores"], $objetoLabor);
        }
        array_push($objetoRE["etapas"], $objetoEtapa);
    }
    array_push($resultadoOrdenado, $objetoPF);
    array_push($resultadoOrdenado, $objetoCO);
    array_push($resultadoOrdenado, $objetoRE);
    echo json_encode($resultadoOrdenado);
?>
            
        
        
    


   
