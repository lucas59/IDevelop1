<?php 
use PHPMailer\PHPMailer\PHPMailer;

if(class_exists("Validaciones"))
	return;
class Validaciones
{
	private $id;
	private $email;
	private $token;
	private $fecha;
	function __construct($email, $token, $fecha)
	{
		$this->email = $email;
		$this->token = $token;
		$this->fecha = $fecha;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getToken(){
		return $this->token;
	}
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getFecha(){
		return $this->fecha;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function setToken($token){
		$this->token = $token;
	}

	public function setFecha($fecha){
		$this->fecha = $fecha;
	}

	

	public function registrar($email,$nombre,$apellido,$token){	
		$id=null;
		$fecha = date("y-m-d H:i:s");
		$sql=DB::conexion()->prepare("INSERT INTO `validaciones` (`id`, `email`, `fecha`, `token`) VALUES (?,?,?,?)");
		$sql->bind_param('isss',$id,$email,$fecha,$token);
		if ($sql->execute()){
			return "1";	
		}else{
			return "0";
		}
	}

	public function obtenerValidacion($token){
		$sql = DB::conexion()->prepare("SELECT * FROM `validaciones` WHERE token = ?");
		$sql->bind_param("s",$token);
		$sql->execute();
		$resultado = $sql->get_result();
		$validacion=$resultado->fetch_object();
		return $validacion;
	}
	
	function enviarMail($email,$nombre,$apellido,$token){

		$hash = "http://localhost/IDevelop1/IDevelop/public/Usuario/validar/";
		$hash .= $token;

//Create a new PHPMailer instance
		$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
		$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
		$mail->SMTPDebug = 2;
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
		$mail->addAddress($email, 'Nuevo Usuario');
//Set the subject line
		$mail->Subject = 'Validacion de nueva cuenta';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
	//	$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
//Replace the plain text body with one created manually
		$mail->Body ="Bienvenido a IDevelop, por favor verifique su correo: " . $hash;
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