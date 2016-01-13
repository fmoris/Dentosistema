<?
	include("class.phpmailer.php");
	include("class.smtp.php");

	//Traer Datos
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	$idOdontologo = $request->odontologo->id; //RECIBE IDODONTOLOGO
	$idOrden = $request->idOrden; //RECIBE NUMERO DE LA ORDEN

	/*echo "idOdontologo: ".$idOdontologo." idOrden: ".$idOrden;*/

	//BUSCAR DATOS ODONTOLOGO
	include('../../../php/coneccion.php');
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	$datosOdontologo = mysqli_query($conexion,"SELECT distinct  NOMBRE,CORREO,NUMORDEN 
										       FROM perfiles,orden 
										       WHERE estado = 'terminado'
										       AND NUMORDEN = '$idOrden'
										       AND IDPERFIL = '$idOdontologo'
										       AND PERMISOS_IDPERMISO = 1");	
	// el arreglo se popula en este bucle
	while($row = mysqli_fetch_array($datosOdontologo)){
	    // crea un objeto donde se incluyen los datos del registro
	    $objetoEstado = array();
	    $objetoEstado["nombre"] = $row['NOMBRE'];
	    $objetoEstado["correo"] = $row['CORREO'];
	    $objetoEstado["orden"] = $row['NUMORDEN'];	        
	}

	$nombre = $objetoEstado["nombre"];
	$correo = $objetoEstado["correo"];
	$orden =  $objetoEstado["orden"];

	/*echo "Nombre:".$nombre." Correo: ".$correo." Orden: ".$orden;*/	

    /// verifica que exista una variable tipo POST

    if(!$correo){
        echo "Correo no existe";
        exit;
    }

	//Creamos la instancia de la clase PHPMAiler
	$mail = new phpmailer();

	//El método que usaremos es por SMTP
	$mail->Mailer = "smtp";

	// Los datos necesarios para enviar mediante SMTP
	$mail->Host = "shae85186.hosting.cl";
	$mail->SMTPAuth = true;
	$mail->Username = "sistema@dentosistema.cl";
	$mail->Password = "dentosistema99";

	// Asignamos el From y el FromName para que el destinatario sepa quien
	// envía el correo
	$mail->From = "sistema@dentosistema.cl";
	$mail->FromName = "Sistema de Gestion Dentosistema";

	//Añadimos la dirección del destinatario
	$mail->AddAddress("$correo");	

	//Asignamos el subject, el cuerpo del mensaje y el correo alternativo
	$mail->Subject = "Orden Terminada";
	$mail->Body = "<h1>Dentosistema</h1><p>Estimad@ $nombre</p><p>La Orden: $orden fue Terminada</p>";
	$mail->AltBody = "Orden Terminada";

	//Si al enviar el correo devuelve true es que todo ha ido bien.
	if($mail->Send())
	{
		//Sacamos un mensaje de que todo ha ido correctamente.
   		echo "1";
	}
	else
	{
		//Sacamos un mensaje con el error.
		echo "Ocurrió un error al enviar el correo electrónico a $correo.";
		echo "<br/><strong>Información:</strong><br/>".$mail->ErrorInfo;
	}
?>