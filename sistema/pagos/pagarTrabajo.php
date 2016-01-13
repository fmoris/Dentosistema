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


	// revisa si la conexion es correcta
	if (mysqli_connect_errno($conexion)) {
		echo "error en la conexion a base de datos: " . mysqli_connect_error();
	}
  
  
    /// verifica que exista una variable tipo GET
    /*if(!$_GET['platoID']){
        echo("debes incluir una variable GET : http://carlossolis.mobi/cursos/itmaster/ws/detalles.php?platoID=99");
        exit;
    }*/

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);


$idOrden = $request->idOrden;
$clasi = $request->clasi;
$fechaPago = $request->fechaPago;
$totalPago = $request->totalPago;
$observacion = $request->observacion;
$medioPago = $request->medioPago;
$descuento = $request->descuento;

    
 $result = mysqli_query($conexion,"UPDATE orden 
                                  SET PAGADO =  'pagado',
                                  DESCUENTO = '$descuento'
                                  WHERE  NUMORDEN =  '$idOrden' 
                                  AND CLASIFICACION = '$clasi'");
  


 $result2 = mysqli_query($conexion, "INSERT INTO pagos (NUMORDEN, CLASIFICACION, FECHAPAGO, MONTO, OBSERVACION, FORMAPAGO, DESCTO)
                                     VALUES ($idOrden, $clasi, $fechaPago, $totalPago, $observacion, $medioPago, $descuento)");

    
?>