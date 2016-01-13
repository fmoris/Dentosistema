<?
/// NO USAR DIRECTAMENTE SOLO DENTRO DE UN SERVIDOR PHP
//// EJEMPLO USANDO CORS!!
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
/// CONECTA A LA BASE DE DATOS	
// Create connection
// reemplazar con ("localhost", USUARIO, PASSWORD, NOMBRE_DE_BASE_DE_DATOS)
include('../../php/coneccion.php');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$id = $request->id;

$origenQuery = mysqli_query($conexion,"SELECT INSTITUCION
 										  FROM origen 
 										  WHERE origen.IDORIGEN = $id");



$result = mysqli_query($conexion,"SELECT NUMORDEN,NOMCLASIF,NOMBREOD,PACIENTE,FECHARECEPCION,FECHAENTREGA,CLASIFICACION,TOTALORDEN
 										  FROM orden,clasificacion,origen,odontologo 
 										  WHERE origen.IDORIGEN = $id
 										  AND orden.IDORIGEN = origen.IDORIGEN
 										  AND orden.CLASIFICACION = clasificacion.IDCLASIF
										  AND odontologo.IDODONTOLOGO = orden.IDODONTOLOGO
                                          AND ESTADO = 'terminado'
                                          AND PAGADO = 'no pagado'
 										  ORDER BY FECHARECEPCION DESC");
 			/// crea un arreglo general vacio
            $resultadoOrdenado = array(); 
            $resultadoOrdenado["nombre"] = mysqli_fetch_array($origenQuery)['INSTITUCION'];
            $resultadoOrdenado["ordenes"] = array();

		    // el arreglo se popula en este bucle
			while($row = mysqli_fetch_array($result)){
		        
		        // crea un objeto donde se incluyen los datos del registro
			   	$objetoOrigen = array();
			   	$objetoOrigen["orden"] = $row['NUMORDEN'];	 
		        $objetoOrigen["clasificacion"] = $row['NOMCLASIF'];
				$objetoOrigen["paciente"] = $row['PACIENTE'];
				$objetoOrigen["recepcion"] = $row['FECHARECEPCION'];
				$objetoOrigen["entrega"] = $row['FECHAENTREGA'];
				$objetoOrigen["estado"] = $row['ESTADO'];
				$objetoOrigen["pagado"] = $row['PAGADO'];
				$objetoOrigen["odontologo"] = $row['NOMBREOD'];
				$objetoOrigen["idclasificacion"] = $row['CLASIFICACION'];
				$objetoOrigen["totalorden"] = $row['TOTALORDEN'];
                $objetoOrigen["check"] = "false";

			   	/// inserta el objeto con los datos de registro, dentro del arreglo general
			   	array_push($resultadoOrdenado["ordenes"], $objetoOrigen);

			}    
		    /// una vez populado el arreglo general con datos, se convierte a Json
			echo json_encode($resultadoOrdenado);
	
?>