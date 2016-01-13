<?
/// NO USAR DIRECTAMENTE SOLO DENTRO DE UN SERVIDOR PHP
//// EJEMPLO USANDO CORS!!
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
/// CONECTA A LA BASE DE DATOS	
// Create connection
// reemplazar con ("localhost", USUARIO, PASSWORD, NOMBRE_DE_BASE_DE_DATOS)
include('../../../php/coneccion.php');
// revisa si la conexion es correcta
if (mysqli_connect_errno($conexion)) {
    echo "error en la conexion a base de datos: " . mysqli_connect_error();
}

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$idEjecutor = $request->id;
$inicio = $request->inicio;
$fin = $request->fin;
$resultadoOrdenado = array();

//PROTESIS FIJA!

$result = mysqli_query($conexion,"SELECT DISTINCT ejecutores.NOMEJECUTOR as 'NOMBRE', 
                                         trabajo.INICIOLABOR as 'FECHA',
                                         trabajo.FINLABOR as 'FECHA2',
                                         trabajo.FECHAREQUERIDA as 'FECHA3',
                                         trabajo.ESTADO as 'ESTADO',
                                         trabajo.VALORTRABAJO as 'TOTAL',
                                         trabajo.CANTIDAD as 'CANTIDAD',
                                         orden.NUMORDEN as 'ORDEN',
                                         clasificacion.NOMCLASIF as 'CLASIFICACION',
                                         labores.DESCRIPCION as 'DESCRIPCION',
                                         etapas.NOMETAPA as 'ETAPA'
                                  FROM ejecutores,trabajo,orden,clasificacion,labores,etapas
                                  WHERE ejecutores.IDEJECUTOR = trabajo.IDEJECUTOR
                                  AND trabajo.ESTADO LIKE 'entregado'
                                  AND orden.CLASIFICACION = clasificacion.IDCLASIF
                                  AND trabajo.IDETAPA = etapas.IDETAPA
                                  AND ejecutores.IDEJECUTOR = '$idEjecutor'
                                  AND etapas.clasificacion = '1'
                                  AND trabajo.IDLABOR = labores.IDLABOR
                                  AND trabajo.NUMORDEN = orden.NUMORDEN
                                  AND orden.anulacion IS NULL
                                  AND (trabajo.INICIOLABOR BETWEEN '$inicio' AND '$fin')
                                  ORDER BY ejecutores.NOMEJECUTOR");

/*$result2 = mysqli_query($conexion,"SELECT SUM(orden.TOTALORDEN) as 'SUMA'
                                  FROM ejecutores,trabajo,orden
                                  WHERE ejecutores.IDEJECUTOR = trabajo.IDEJECUTOR
                                  AND orden.ESTADO NOT LIKE 'terminado'
                                  AND ejecutores.IDEJECUTOR = '$idEjecutor'
                                  AND (orden.FECHARECEPCION BETWEEN '$inicio' AND '$fin')");

$total = mysqli_fetch_array($result2);*/

$objetoClasi = array();
$objetoClasi["nombre"] = "Protesis Fija";
$objetoClasi["id"] = "1";
$objetoClasi["trabajos"] = array();




while($row = mysqli_fetch_array($result)){
    // crea un objeto donde se incluyen los datos del registro
    $objetoTrabajo = array();
    $objetoTrabajo["nombre"] = $row['NOMBRE'];
   $objetoTrabajo["fechaIngreso"] = $row['FECHA'];
    $objetoTrabajo["fechaFin"] = $row['FECHA2'];
    $objetoTrabajo["fechaRequerida"] = $row['FECHA3'];
    $objetoTrabajo["estado"] = $row['ESTADO'];
    $objetoTrabajo["total"] = $row['TOTAL'];
    $objetoTrabajo["cantidad"] = $row['CANTIDAD'];
    $objetoTrabajo["orden"] = $row['ORDEN'];
    $objetoTrabajo["clasificacion"] = $row['CLASIFICACION'];
    $objetoTrabajo["descripcion"] = $row['DESCRIPCION'];
    $objetoTrabajo["etapa"] = $row['ETAPA'];
   // $usuario["suma"] = $total['SUMA'];
    
/// inserta el objeto con los datos de registro, dentro del arreglo general
    array_push($objetoClasi["trabajos"], $objetoTrabajo);
}  

array_push($resultadoOrdenado, $objetoClasi);


// COLADOS

$result = mysqli_query($conexion,"SELECT DISTINCT ejecutores.NOMEJECUTOR as 'NOMBRE', 
                                         trabajo.INICIOLABOR as 'FECHA',
                                         trabajo.FINLABOR as 'FECHA2',
                                         trabajo.FECHAREQUERIDA as 'FECHA3',
                                         trabajo.ESTADO as 'ESTADO',
                                         trabajo.VALORTRABAJO as 'TOTAL',
                                         trabajo.CANTIDAD as 'CANTIDAD',
                                         orden.NUMORDEN as 'ORDEN',
                                         clasificacion.NOMCLASIF as 'CLASIFICACION',
                                         labores.DESCRIPCION as 'DESCRIPCION',
                                         etapas.NOMETAPA as 'ETAPA'
                                  FROM ejecutores,trabajo,orden,clasificacion,labores,etapas
                                  WHERE ejecutores.IDEJECUTOR = trabajo.IDEJECUTOR
                                  AND trabajo.ESTADO LIKE 'entregado'
                                  AND orden.CLASIFICACION = clasificacion.IDCLASIF
                                  AND trabajo.IDETAPA = etapas.IDETAPA
                                  AND ejecutores.IDEJECUTOR = '$idEjecutor'
                                  AND etapas.clasificacion = '2'
                                  AND trabajo.IDLABOR = labores.IDLABOR
                                  AND trabajo.NUMORDEN = orden.NUMORDEN
                                  AND orden.anulacion IS NULL
                                  AND (trabajo.INICIOLABOR BETWEEN '$inicio' AND '$fin')
                                  ORDER BY ejecutores.NOMEJECUTOR");

/*$result2 = mysqli_query($conexion,"SELECT SUM(orden.TOTALORDEN) as 'SUMA'
                                  FROM ejecutores,trabajo,orden
                                  WHERE ejecutores.IDEJECUTOR = trabajo.IDEJECUTOR
                                  AND orden.ESTADO NOT LIKE 'terminado'
                                  AND ejecutores.IDEJECUTOR = '$idEjecutor'
                                  AND (orden.FECHARECEPCION BETWEEN '$inicio' AND '$fin')");

$total = mysqli_fetch_array($result2);*/

$objetoClasi = array();
$objetoClasi["nombre"] = "Colados";
$objetoClasi["id"] = "2";
$objetoClasi["trabajos"] = array();




while($row = mysqli_fetch_array($result)){
    // crea un objeto donde se incluyen los datos del registro
    $objetoTrabajo = array();
    $objetoTrabajo["nombre"] = $row['NOMBRE'];
    $objetoTrabajo["fechaIngreso"] = $row['FECHA'];
    $objetoTrabajo["fechaFin"] = $row['FECHA2'];
    $objetoTrabajo["fechaRequerida"] = $row['FECHA3'];
    $objetoTrabajo["estado"] = $row['ESTADO'];
    $objetoTrabajo["total"] = $row['TOTAL'];
    $objetoTrabajo["cantidad"] = $row['CANTIDAD'];
    $objetoTrabajo["orden"] = $row['ORDEN'];
    $objetoTrabajo["clasificacion"] = $row['CLASIFICACION'];
    $objetoTrabajo["descripcion"] = $row['DESCRIPCION'];
    $objetoTrabajo["etapa"] = $row['ETAPA'];
   // $usuario["suma"] = $total['SUMA'];
    
/// inserta el objeto con los datos de registro, dentro del arreglo general
    array_push($objetoClasi["trabajos"], $objetoTrabajo);
}  

array_push($resultadoOrdenado, $objetoClasi);

// REMOVIBLES

$result = mysqli_query($conexion,"SELECT DISTINCT ejecutores.NOMEJECUTOR as 'NOMBRE', 
                                         trabajo.INICIOLABOR as 'FECHA',
                                         trabajo.FINLABOR as 'FECHA2',
                                         trabajo.FECHAREQUERIDA as 'FECHA3',
                                         trabajo.ESTADO as 'ESTADO',
                                         trabajo.VALORTRABAJO as 'TOTAL',
                                         trabajo.CANTIDAD as 'CANTIDAD',
                                         orden.NUMORDEN as 'ORDEN',
                                         clasificacion.NOMCLASIF as 'CLASIFICACION',
                                         labores.DESCRIPCION as 'DESCRIPCION',
                                         etapas.NOMETAPA as 'ETAPA'
                                  FROM ejecutores,trabajo,orden,clasificacion,labores,etapas
                                  WHERE ejecutores.IDEJECUTOR = trabajo.IDEJECUTOR
                                  AND trabajo.ESTADO LIKE 'entregado'
                                  AND orden.CLASIFICACION = clasificacion.IDCLASIF
                                  AND trabajo.IDETAPA = etapas.IDETAPA
                                  AND ejecutores.IDEJECUTOR = '$idEjecutor'
                                  AND etapas.clasificacion = '3'
                                  AND trabajo.IDLABOR = labores.IDLABOR
                                  AND trabajo.NUMORDEN = orden.NUMORDEN
                                  AND orden.anulacion IS NULL
                                  AND (trabajo.INICIOLABOR BETWEEN '$inicio' AND '$fin')
                                  ORDER BY ejecutores.NOMEJECUTOR");

/*$result2 = mysqli_query($conexion,"SELECT SUM(orden.TOTALORDEN) as 'SUMA'
                                  FROM ejecutores,trabajo,orden
                                  WHERE ejecutores.IDEJECUTOR = trabajo.IDEJECUTOR
                                  AND orden.ESTADO NOT LIKE 'terminado'
                                  AND ejecutores.IDEJECUTOR = '$idEjecutor'
                                  AND (orden.FECHARECEPCION BETWEEN '$inicio' AND '$fin')");

$total = mysqli_fetch_array($result2);*/

$objetoClasi = array();
$objetoClasi["nombre"] = "Removibles";
$objetoClasi["id"] = "3";
$objetoClasi["trabajos"] = array();




while($row = mysqli_fetch_array($result)){
    // crea un objeto donde se incluyen los datos del registro
    $objetoTrabajo = array();
    $objetoTrabajo["nombre"] = $row['NOMBRE'];
    $objetoTrabajo["fechaIngreso"] = $row['FECHA'];
    $objetoTrabajo["fechaFin"] = $row['FECHA2'];
    $objetoTrabajo["fechaRequerida"] = $row['FECHA3'];
    $objetoTrabajo["estado"] = $row['ESTADO'];
    $objetoTrabajo["total"] = $row['TOTAL'];
    $objetoTrabajo["cantidad"] = $row['CANTIDAD'];
    $objetoTrabajo["orden"] = $row['ORDEN'];
    $objetoTrabajo["clasificacion"] = $row['CLASIFICACION'];
    $objetoTrabajo["descripcion"] = $row['DESCRIPCION'];
    $objetoTrabajo["etapa"] = $row['ETAPA'];
   // $usuario["suma"] = $total['SUMA'];
    
/// inserta el objeto con los datos de registro, dentro del arreglo general
    array_push($objetoClasi["trabajos"], $objetoTrabajo);
}  

array_push($resultadoOrdenado, $objetoClasi);

echo json_encode($resultadoOrdenado);
 
/// una vez populado el arreglo general con datos, se convierte a Json
	
?>