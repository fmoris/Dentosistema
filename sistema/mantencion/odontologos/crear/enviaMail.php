<?
	include("../../PHPMailer/PHPMailerAutoload.php");

	//BDD
	include('../../../../php/coneccion.php');

	$correo = $_GET['correo'];
	$nombre = $_GET['nombre'];
	$password = $_GET['password'];
	
	
	//Create a new PHPMailer instance
	$mail = new PHPMailer;

	//Tell PHPMailer to use SMTP
	$mail->isSMTP();

	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	$mail->SMTPDebug = 2;

	//Ask for HTML-friendly debug output
	$mail->Debugoutput = 'html';

	//Set the hostname of the mail server
	$mail->Host = 'smtp.live.com';

	//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
	$mail->Port = 25;

	//Set the encryption system to use - ssl (deprecated) or tls
	$mail->SMTPSecure = 'tls';

	//Whether to use SMTP authentication
	$mail->SMTPAuth = true;

	//Username to use for SMTP authentication - use full email address for gmail
	$mail->Username = "tx_black@hotmail.com";

	//Password to use for SMTP authentication
	$mail->Password = "undertaker1982";

	//Set who the message is to be sent from
	$mail->setFrom('from@example.com', 'First Last');

	//Set an alternative reply-to address
	$mail->addReplyTo('replyto@example.com', 'First Last');

	//Set who the message is to be sent to
	$mail->addAddress('fmoris@gmail.com', 'John Doe');

	//Set the subject line
	$mail->Subject = 'PHPMailer GMail SMTP test';	

	//Puedo definir un cuerpo alternativo del mensaje, que contenga solo texto
	$mail->AltBody = "Cuerpo alternativo del mensaje";

	//inserto el texto del mensaje en formato HTML
	$body = "HOLA";
	$mail->IsHTML(true);
	$mail->MsgHTML($body);

	//Attach an image file
	//$mail->addAttachment('images/phpmailer_mini.png');

	//send the message, check for errors
	if (!$mail->send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!";
	}

?>