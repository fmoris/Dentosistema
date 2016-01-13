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
$inicio= $request->inicio;
$fin= $request->fin;
//$result = mysqli_query($conexion, "SELECT institucion FROM origen WHERE IDORIGEN = '$idOrigen' ");
//$row = mysqli_fetch_array($result)
/// crea un arreglo general vacio
$resultadoOrdenado = array();
$resultadoOrdenado["origenes"] = array();
$resultadoOrdenado["total"] = 0;

$query_origenes = mysqli_query($conexion, "SELECT DISTINCT orden.IDORIGEN, origen.INSTITUCION FROM orden, origen, pagos
                                           WHERE orden.IDORIGEN = origen.IDORIGEN 
                                           AND orden.NUMORDEN = pagos.NUMORDEN
                                           AND (pagos.FECHAPAGO BETWEEN '$inicio' AND '$fin')
                                           AND orden.anulacion IS NULL
                                           ORDER BY orden.IDORIGEN");

   // el arreglo se popula en este bucle
			while($row = mysqli_fetch_array($query_origenes)){
		        
		        // crea un objeto donde se incluyen los datos del registro
			   	$objetoOrigen = array();
                $objetoOrigen["nombre"] = $row['INSTITUCION'];
                $objetoOrigen["odontologos"] = array();
                $objetoOrigen["total"] = 0;
                $idOrigen= $row['IDORIGEN'];
                
                $query_odontologos = mysqli_query($conexion, "SELECT DISTINCT orden.IDODONTOLOGO, odontologo.NOMBREOD FROM orden, pagos, odontologo
                                                              WHERE  orden.IDORIGEN='$idOrigen' 
                                                              AND orden.IDODONTOLOGO = odontologo.IDODONTOLOGO 
                                                              AND orden.NUMORDEN = pagos.NUMORDEN 
                                                              AND (pagos.FECHAPAGO BETWEEN '$inicio' AND '$fin')
                                                              AND orden.anulacion IS NULL
                                                              ORDER BY orden.IDODONTOLOGO");
                while($row = mysqli_fetch_array($query_odontologos)){
                    $objetoOdontologo = array();
                    $objetoOdontologo["nombre"] = $row['NOMBREOD'];
                    $objetoOdontologo["protesisFija"] = array();
                    $objetoOdontologo["colados"] = array();
                    $objetoOdontologo["removibles"] = array();
                    $objetoOdontologo["total"] = 0;
                    $idOdontologo= $row['IDODONTOLOGO'];
                    $query_pf = mysqli_query($conexion, "SELECT orden.NUMORDEN, orden.PACIENTE, orden.FECHARECEPCION, orden.FECHAENTREGA, orden.TOTALORDEN, pagos.FECHAPAGO, pagos.MONTO, pagos.FORMAPAGO, pagos.DESCTO, orden.TOTALADEUDADO FROM orden, pagos WHERE orden.CLASIFICACION=1 AND orden.IDORIGEN='$idOrigen' AND orden.IDODONTOLOGO='$idOdontologo' AND orden.NUMORDEN = pagos.NUMORDEN AND (pagos.FECHAPAGO BETWEEN '$inicio' AND '$fin') AND orden.anulacion IS NULL ORDER BY pagos.FECHAPAGO");
                    while($row2 = mysqli_fetch_array($query_pf)){
                        $objetoPF = array();
                        $objetoPF["orden"] = $row2['NUMORDEN'];	 
                        $objetoPF["paciente"] = $row2['PACIENTE'];
                        $objetoPF["recepcion"] = $row2['FECHARECEPCION'];
                        $objetoPF["entrega"] = $row2['FECHAENTREGA'];
                        $objetoPF["fechaPago"] = $row2['FECHAPAGO'];
                        $objetoPF["total"] = $row2['TOTALORDEN'];
                        $objetoOdontologo["total"] += intval($objetoPF["total"]);
                        array_push($objetoOdontologo["protesisFija"], $objetoPF);
                    }
                    $query_co =  mysqli_query($conexion, "SELECT orden.NUMORDEN, orden.PACIENTE, orden.FECHARECEPCION, orden.FECHAENTREGA, orden.TOTALORDEN, pagos.FECHAPAGO, pagos.MONTO, pagos.FORMAPAGO, pagos.DESCTO, orden.TOTALADEUDADO FROM orden, pagos WHERE orden.CLASIFICACION=2 AND orden.IDORIGEN='$idOrigen' AND orden.IDODONTOLOGO='$idOdontologo' AND orden.NUMORDEN = pagos.NUMORDEN AND (pagos.FECHAPAGO BETWEEN '$inicio' AND '$fin') AND orden.anulacion IS NULL ORDER BY pagos.FECHAPAGO");
                    while($row2 = mysqli_fetch_array($query_co)){
                        $objetoCO = array();
                        $objetoCO["orden"] = $row2['NUMORDEN'];	 
                        $objetoCO["paciente"] = $row2['PACIENTE'];
                        $objetoCO["recepcion"] = $row2['FECHARECEPCION'];
                        $objetoCO["entrega"] = $row2['FECHAENTREGA'];
                        $objetoCO["fechaPago"] = $row2['FECHAPAGO'];
                        $objetoCO["total"] = $row2['TOTALORDEN'];
                        $objetoOdontologo["total"] += intval($objetoCO["total"]);
                        array_push($objetoOdontologo["colados"], $objetoCO);
                    }
                    $query_re = mysqli_query($conexion,"SELECT orden.NUMORDEN, orden.PACIENTE, orden.FECHARECEPCION, orden.FECHAENTREGA, orden.TOTALORDEN, pagos.FECHAPAGO, pagos.MONTO, pagos.FORMAPAGO, pagos.DESCTO, orden.TOTALADEUDADO 
                                                        FROM orden, pagos 
                                                        WHERE orden.CLASIFICACION=3 
                                                        AND orden.IDORIGEN='$idOrigen'
                                                        AND orden.IDODONTOLOGO='$idOdontologo'
                                                        AND orden.NUMORDEN = pagos.NUMORDEN
                                                        AND (pagos.FECHAPAGO BETWEEN '$inicio' AND '$fin')
                                                        AND orden.anulacion IS NULL 
                                                        ORDER BY pagos.FECHAPAGO");
                    while($row2 = mysqli_fetch_array($query_re)){
                        $objetoRE = array();
                        $objetoRE["orden"] = $row2['NUMORDEN'];	 
                        $objetoRE["paciente"] = $row2['PACIENTE'];
                        $objetoRE["recepcion"] = $row2['FECHARECEPCION'];
                        $objetoRE["entrega"] = $row2['FECHAENTREGA'];
                        $objetoRE["fechaPago"] = $row2['FECHAPAGO'];
                        $objetoRE["total"] = $row2['TOTALORDEN'];
                        $objetoOdontologo["total"] += intval($objetoRE["total"]);
                        array_push($objetoOdontologo["removibles"], $objetoRE);
                    }
                
                 
                    
                    
                
                
                
			   

			   	/// inserta el objeto con los datos de registro, dentro del arreglo general
                $objetoOrigen["total"] += $objetoOdontologo["total"];
			   	array_push($objetoOrigen["odontologos"], $objetoOdontologo);
                }
                $resultadoOrdenado["total"] += $objetoOrigen["total"];
                array_push($resultadoOrdenado["origenes"], $objetoOrigen);
            }
                
		    /// una vez populado el arreglo general con datos, se convierte a Json
			echo json_encode($resultadoOrdenado);
	


    
?>