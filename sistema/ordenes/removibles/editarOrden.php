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
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$idOrigen = $request->origen->id;
$idOdontologo = $request->odontologo->id;
$paciente = $request->paciente;
$comentario = $request->comentario;
$fechaInicio = $request->inicio;
$fechaFin = $request->fin;
$estado = $request->estado;    
$descuento = $request->descuento; 
$convenio = $request->convenio->id;
    
$idOrden = $request->idOrden;
$clasi = $request->clasi;

    
$result2 = mysqli_query($conexion,"UPDATE orden
                                   SET IDORIGEN = '$idOrigen',
                                   IDODONTOLOGO = '$idOdontologo',
                                   PACIENTE =  '$paciente',
                                   ADHERENTE =  '$comentario',
                                   FECHARECEPCION = '$fechaInicio',
                                   FECHAENTREGA = '$fechaFin',
                                   ESTADO = '$estado',
                                   DESCUENTO = '$descuento'
                                   
                                   WHERE NUMORDEN = '$idOrden'
                                   AND CLASIFICACION = '$clasi'
                                   ");

$numCromos = $request->numCromos;
$superior =$request->superior;
$inferior = $request->inferior;

$result2 = mysqli_query($conexion,"UPDATE coronas
                                   SET NUMCROMOS = '$numCromos',
                                   SUPERIOR = '$superior',
                                   INFERIOR =  '$inferior'
                                   
                                   WHERE NUMORDEN = '$idOrden'
                                   AND CLASIFICACION = '$clasi'
                                   ");

$anular = $request->anular;
$anulacion = $request->anulacion;

if ($anular){
    
    $result2 = mysqli_query($conexion,"UPDATE orden
                                   SET ANULACION = '$anulacion'                                   
                                   WHERE NUMORDEN = '$idOrden'
                                   AND CLASIFICACION = '$clasi'
                                   ");
    
}
else{
    $result2 = mysqli_query($conexion,"UPDATE orden
                                   SET ANULACION = NULL                                   
                                   WHERE NUMORDEN = '$idOrden'
                                   AND CLASIFICACION = '$clasi'
                                   ");    
}

?>

