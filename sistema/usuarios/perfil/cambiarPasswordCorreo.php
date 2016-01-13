<?
	include("class.phpmailer.php");
	include("class.smtp.php");

	//Traer Datos
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	$password = $request->password;	
	$correo = $request->correo;	
	$nombre = $request->nombre;	

    /// verifica que exista una variable tipo POST

    if(!$correo || !$password || !$nombre){
        echo "error";
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
	$mail->Subject = "Contraseña Cambiada";
	$mail->Body = "<h1>Dentosistema</h1><p>Estimad@ $nombre</p><div><p>Sus nuevos datos de ingreso son:</p><p>Correo: $correo</p><p>Contraseña: $password</p></div><div><p>Para entrar al sistema debe ingresar a la siguiente direccion <a href='http://www.dentosistema.cl/trabajos/' target='_blank'>Sistema Gestion de Trabajos</a></p></div>";
	$mail->AltBody = "Contraseña Cambiada";

	//Si al enviar el correo devuelve true es que todo ha ido bien.
	if($mail->Send())
	{
		//Sacamos un mensaje de que todo ha ido correctamente.
   		echo "1";
	}
	else
	{
		//Sacamos un mensaje con el error.
		echo "Ocurrió un error al enviar el correo electrónico.";
		echo "<br/><strong>Información:</strong><br/>".$mail->ErrorInfo;
	}
?>