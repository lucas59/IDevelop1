<?php
use PHPMailer\PHPMailer\PHPMailer;
class Correos
{
	private $id;
	private $email;
	private $mensaje;
	private $titulo;
	function __construct($email,$id,$mensaje,$titulo)
	{
		$this->email = $email;
		$this->id = $id;
		$this->mensaje = $mensaje;
		$this->titulo = $titulo;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	function enviarMail($id_proyecto,$email,$titulo,$mensaje){
		$direccion = "http://localhost/IDevelop1/IDevelop/public/Proyecto/";
		$direccion .= $id_proyecto;

//Create a new PHPMailer instance
		$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
		$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
		$mail->SMTPDebug = 0;
//Set the hostname of the mail server
		$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port = 587;
//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = 'tls';
//Whether to use SMTP authentication
		$mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
		$mail->Username = "idevelopcomunidad@gmail.com";
//Password to use for SMTP authentication
		$mail->Password = "idevelop2019";
//Set who the message is to be sent from
		$mail->setFrom("idevelopcomunidad@gmail.com", 'IDevelop');
//Set an alternative reply-to address
//		$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
		$mail->addAddress($email, 'IDevelop');
//Set the subject line
		$mail->Subject = $titulo;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
	//	$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
//Replace the plain text body with one created manually
		$mail->Body = $mensaje . " " . $direccion;
//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors
		if ($mail->send()) {
			return "1";
		}else{
			return "0";
		}
	}

}


?>