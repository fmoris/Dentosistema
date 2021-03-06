<?
/// NO USAR DIRECTAMENTE SOLO DENTRO DE UN SERVIDOR PHP
//// EJEMPLO USANDO CORS!!
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
/// CONECTA A LA BASE DE DATOS	
// Create connection
// reemplazar con ("localhost", USUARIO, PASSWORD, NOMBRE_DE_BASE_DE_DATOS)
$conexion=mysqli_connect("localhost","dentosis_admin","admin2dent4bdd","dentosis_dentobd");
// revisa si la conexion es correcta
if (mysqli_connect_errno($conexion)) {
    echo "error en la conexion a base de datos: " . mysqli_connect_error();
}

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$idOrigen = $request->id;
//$result = mysqli_query($conexion, "SELECT institucion FROM origen WHERE IDORIGEN = '$idOrigen' ");
//$row = mysqli_fetch_array($result)
/// crea un arreglo general vacio
$resultadoOrdenado = array();
$resultadoOrdenado["odontologos"] = array();
$resultadoOrdenado["total"] = 0;

$result = mysqli_query($conexion, "SELECT DISTINCT orden.IDODONTOLOGO, odontologo.NOMBREOD FROM orden, odontologo WHERE orden.IDORIGEN= '$idOrigen' AND orden.IDODONTOLOGO = odontologo.IDODONTOLOGO AND orden.ESTADO = 'terminado' AND orden.PAGADO = 'no pagado' AND orden.anulacion IS NULL ORDER BY orden.IDODONTOLOGO");
    // el arreglo se popula en este bucle
	while($row = mysqli_fetch_array($result)){
    // crea un objeto donde se incluyen los datos del registro
   	$objetoOdontologo = array();
    $objetoOdontologo["nombre"] = $row['NOMBREOD'];
    $objetoOdontologo["protesisFija"] = array();
    $objetoOdontologo["colados"] = array();
    $objetoOdontologo["removibles"] = array();
    $objetoOdontologo["total"] = 0;
    $idOdontologo= $row['IDODONTOLOGO'];
    
    $query_pf = mysqli_query($conexion, "SELECT orden.NUMORDEN, orden.PACIENTE, orden.FECHARECEPCION, orden.FECHAENTREGA, orden.TOTALORDEN FROM orden WHERE orden.CLASIFICACION=1 AND orden.IDORIGEN='$idOrigen' AND orden.IDODONTOLOGO='$idOdontologo' AND orden.ESTADO = 'terminado' AND orden.PAGADO = 'no pagado' AND orden.anulacion IS NULL");
    while($row2 = mysqli_fetch_array($query_pf)){
        $objetoPF = array();
        $objetoPF["orden"] = $row2['NUMORDEN'];
        $orden = $row2['NUMORDEN'];
	    $objetoPF["paciente"] = $row2['PACIENTE'];
	    $objetoPF["recepcion"] = $row2['FECHARECEPCION'];
	    $objetoPF["entrega"] = $row2['FECHAENTREGA'];
	    $objetoPF["totalorden"] = $row2['TOTALORDEN'];
        $objetoOdontologo["total"] += intval($objetoPF["totalorden"]);
        $result2 = mysqli_query($conexion, "SELECT DISTINCT NUMFOLIO FROM folios WHERE NUMORDEN = '$orden'");
        $objetoPF["folio"] = "";
        while($row3 = mysqli_fetch_array($result2)){
            $objetoPF["folio"].= $row3['NUMFOLIO'];	
            $objetoPF["folio"].= ", ";
        }
        $objetoPF["folio"] = rtrim($objetoPF["folio"], ",");
        array_push($objetoOdontologo["protesisFija"], $objetoPF);
    }
    $query_co =  mysqli_query($conexion, "SELECT orden.NUMORDEN, orden.PACIENTE, orden.FECHARECEPCION, orden.FECHAENTREGA, orden.TOTALORDEN FROM orden WHERE orden.CLASIFICACION=2 AND orden.IDORIGEN='$idOrigen' AND orden.IDODONTOLOGO='$idOdontologo' AND orden.ESTADO = 'terminado' AND orden.PAGADO = 'no pagado' AND orden.anulacion IS NULL");
    while($row2 = mysqli_fetch_array($query_co)){
        $objetoCO = array();
        $objetoCO["orden"] = $row2['NUMORDEN'];	 
        $orden = $row2['NUMORDEN'];
	    $objetoCO["paciente"] = $row2['PACIENTE'];
	    $objetoCO["recepcion"] = $row2['FECHARECEPCION'];
	    $objetoCO["entrega"] = $row2['FECHAENTREGA'];
	    $objetoCO["totalorden"] = $row2['TOTALORDEN'];
        $objetoOdontologo["total"] += intval($objetoCO["totalorden"]);
        $result2 = mysqli_query($conexion, "SELECT DISTINCT NUMFOLIO FROM folios WHERE NUMORDEN = '$orden'");
        $objetoCO["folio"] = "";
        while($row3 = mysqli_fetch_array($result2)){
            $objetoCO["folio"].= $row3['NUMFOLIO'];	
            $objetoCO["folio"].= ", ";
        }
        $objetoCO["folio"] = rtrim($objetoCO["folio"], ",");
        array_push($objetoOdontologo["colados"], $objetoCO);
    }
    $query_re = mysqli_query($conexion,"SELECT orden.NUMORDEN, orden.PACIENTE, orden.FECHARECEPCION, orden.FECHAENTREGA, orden.TOTALORDEN FROM orden WHERE orden.CLASIFICACION=3 AND orden.IDORIGEN='$idOrigen' AND orden.IDODONTOLOGO='$idOdontologo' AND orden.ESTADO = 'terminado' AND orden.PAGADO = 'no pagado' AND orden.anulacion IS NULL");
    while($row2 = mysqli_fetch_array($query_re)){
        $objetoRE = array();
        $objetoRE["orden"] = $row2['NUMORDEN'];
        $orden = $row2['NUMORDEN'];
	    $objetoRE["paciente"] = $row2['PACIENTE'];
	    $objetoRE["recepcion"] = $row2['FECHARECEPCION'];
	    $objetoRE["entrega"] = $row2['FECHAENTREGA'];
	    $objetoRE["totalorden"] = $row2['TOTALORDEN'];
        $objetoOdontologo["total"] += intval($objetoRE["totalorden"]);
        $result2 = mysqli_query($conexion, "SELECT DISTINCT NUMFOLIO FROM folios WHERE NUMORDEN = '$orden'");
        $objetoRE["folio"] = "";
        while($row3 = mysqli_fetch_array($result2)){
            $objetoRE["folio"].= $row3['NUMFOLIO'];	
            $objetoRE["folio"].= ", ";	
        }
        $objetoRE["folio"] = rtrim($objetoRE["folio"], ",");
        array_push($objetoOdontologo["removibles"], $objetoRE);
    }
                
                 
                    
                    
                
                
                
			   

			   	/// inserta el objeto con los datos de registro, dentro del arreglo general
                $resultadoOrdenado["total"] += $objetoOdontologo["total"];
			   	array_push($resultadoOrdenado["odontologos"], $objetoOdontologo);

			}    
		    /// una vez populado el arreglo general con datos, se convierte a Json
			echo json_encode($resultadoOrdenado);
	
?>