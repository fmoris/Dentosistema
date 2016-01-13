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

$numCoronas = $request->numCoronas;
$piezasCorona =$request->piezasCorona;
$numApoyos = $request->numApoyos;
$piezasApoyo =$request->piezasApoyo;
$singulares =$request->singulares;
$plurales = $request->plurales;
$color = $request->color;                 


/*echo "IDORIGEN: ".$idOrigen;
echo " idOdontologo: ".$idOdontologo;
echo " Paciente: ".$paciente;
echo " Comentario: ".$comentario;
echo " Fecha Inicio: ".$fechaInicio;
echo " Fecha Fin: ".$fechaFin;
echo " Estado: ".$estado;    
echo " Descuento: ".$descuento; 
echo " Convenio: ".$convenio; */ 

$clasi = 1;

$ultimaOrden= mysqli_query($conexion,"SELECT MAX( NUMORDEN ) as idOrden
								  FROM orden
								  WHERE CLASIFICACION = '$clasi'");
	 	$resultadoOrdenado = array();
		// el arreglo se popula en este bucle
		while($row = mysqli_fetch_array($ultimaOrden)){
		    // crea un objeto donde se incluyen los datos del registro
		    $usuario = array();
		    $usuario["idOrden"] = $row['idOrden'];
		}    
		$idOrden = intval($usuario["idOrden"])+1 ;

		if($ultimaOrden){

			$guardaOrden = mysqli_query($conexion,"INSERT INTO orden (NUMORDEN, CLASIFICACION, IDORIGEN, IDODONTOLOGO, PACIENTE, ADHERENTE, FECHARECEPCION, FECHAENTREGA, DESCUENTO, ESTADO, PAGADO) 
				                                              VALUES ('$idOrden', '$clasi', '$idOrigen', '$idOdontologo', '$paciente', '$comentario', '$fechaInicio', '$fechaFin', '$descuento', '$estado', 'Pago Pendiente'");

			if($guardaOrden){			        

				$guardaEspecificos = mysqli_query($conexion,"INSERT INTO coronas (NUMORDEN, CLASIFICACION, NUMCORONAS, PIEZASCORONA, NUMAPOYOS, PIEZASAPOYO, SINGULARES, PLURALES, COLOR)
				                                             VALUES ('$idOrden', '$clasi', '$numCoronas', '$piezasCorona', '$numApoyos', '$piezasApoyo', '$singulares', '$plurales', '$color');");
					if(!$guardaEspecificos){
						echo 3; //Error al guardar especificos
					}else{

					}

			}else{
				echo 2; //Error al Guardar Orden			
			}
			
		}else{
			echo 1; //Error Al obtener ultima Orden
		}
		echo $idOrden;
		exit;      
               
?>