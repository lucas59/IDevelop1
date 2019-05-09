<?php 
use PHPMailer\PHPMailer\PHPMailer;
require_once('../Vendor/phpmailer/phpmailer/src/PHPMailer.php');

class Validaciones
{
	public $email = '';
	public $token = '';
	public $fecha = '';
	function __construct($email, $token, $fecha)
	{
		$this->email = $email;
		$this->token = $token;
		$this->fecha = $token;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getToken(){
		return $this->token;
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

	public function generarToken($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	} 

	public function registrarse(){	
		$this->token=generarToken(10);

		$sql=DB::conexion()->prepare("INSERT INTO `validaciones` (`id`, `email`, `fecha`, `token`) VALUES (?,?,?,?)");
		$sql->bind_param('isss',null,$this->email,$this->fecha,$this->token);
		if ($sql->execute()) {
			enviarMail();
		}else{
			return "0";
		} 
	}

	public function enviarMail(){
		//incluimos la clase PHPMailer

//instancio un objeto de la clase PHPMailer
$mail = new PHPMailer(); 

//defino el cuerpo del mensaje en una variable $body
//se trae el contenido de un archivo de texto
//también podríamos hacer $body="contenido...";
$body = file_get_contents('contenido.html');
//Esta línea la he tenido que comentar
//porque si la pongo me deja el $body vacío
// $body = preg_replace('/[]/i','',$body);

//defino el email y nombre del remitente del mensaje
$mail­>SetFrom('email@remitente.com', 'Nombre completo');

//defino la dirección de email de "reply", a la que responder los mensajes
//Obs: es bueno dejar la misma dirección que el From, para no caer en spam
$mail­>AddReplyTo("email@remitente.com","Nombre Completo");
//Defino la dirección de correo a la que se envía el mensaje
$address = "email@destinatario.com";
//la añado a la clase, indicando el nombre de la persona destinatario
$mail­>AddAddress($address, "Nombre completo");

//Añado un asunto al mensaje
$mail­>Subject("Envío de email con PHPMailer en PHP");

//Puedo definir un cuerpo alternativo del mensaje, que contenga solo texto
$mail­>AltBody("Cuerpo alternativo del mensaje");

//inserto el texto del mensaje en formato HTML
$mail­>MsgHTML($body);

//asigno un archivo adjunto al mensaje
$mail­>AddAttachment("ruta/archivo_adjunto.gif");

//envío el mensaje, comprobando si se envió correctamente
if(!$mail­>Send()) {
	echo "Error al enviar el mensaje: " . $mail­>ErrorInfo;
} else {
	echo "Mensaje enviado!!";
} 
}
}

?>