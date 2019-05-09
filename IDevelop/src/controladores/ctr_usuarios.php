 <?php 
/**
  * 
  */
require_once '../src/Clases/Usuario.php';
require_once '../src/Clases/Empresa.php';
require_once '../src/Clases/Desarrollador.php';
require_once '../src/Clases/Validaciones.php';
require_once '../src/conexion/abrir_conexion.php';
class ctr_usuarios{

	function __construct(){
	}

	public function validarEmail($email){
		$retorno = Usuario::verificarExistencia($email);
		return $retorno;
	}
	public function generarToken($length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	} 

	public function ingresarUsuario($email,$nombre,$apellido,$contrasenia,$fecha,$sexo,$tipo,$token){
		$insertUsu=Usuario::registrarUsuario($email,null,sha1($contrasenia));
		if ($insertUsu=="1") {
			return Validaciones::registrar($email,$nombre,$apellido,$token);
		}else{
			return "0";
		}
	}
	public function ingresarUsuHijo($email,$nombre,$apellido,$fecha,$tipo){
		if($tipo=="e"){
			$retorno = Empresa::registrarEmpresa($nombre,$fecha,$email);
			return $retorno;
		}else if($tipo=="d"){
			$retorno = Desarrollador::registrarDesarrollador($nombre,$apellido,$email,$fecha);
			return $retorno;
		}
	}

	public function enviarValidacion($email,$nombre,$apellido,$token){
		return Validaciones::enviarMail($email,$nombre,$apellido,$token);
	}

	public function validarCuenta($token){
		$validacion= Validaciones::obtenerValidacion($token);
		$fecha = $validacion->fecha;
		$comprobarfecha=$this->comprobarfecha($fecha);
		if($comprobarfecha){
			return false;
		}else{
			return true;
		}



	}
	public function comprobarfecha($fecha){
		$retorno = false;
		$fechaActual = date("y-m-d H:i:s");
		$nuevafecha = strtotime ( '-30 day' , strtotime ( $fechaActual ) );
		if($nuevafecha<=$fecha){
			$retorno = true;
		}
		return $retorno;
	}



		public function iniciarsesion(){
			require_once './conexion/abrir_conexion.php';
		session_start();
		
		$usuario_login = $_POST['Correo'];
		$contrasena_login = $_POST['Contrasena'];
		
		//VERIFICAR SI USUARIO EXISTE
		
		$consulta = DB::conexion()->prepare('SELECT * FROM usuario WHERE email= ?');
		$consulta->bind_param('s',$usuario_login);		
		$consulta->execute();
		$resultado = $consulta->get_result();
		if(!$resultado){
			header('Location: ../public/Usuario/login');
			die();
			
		}
		for ($num_fila = $resultado->num_rows - 1; $num_fila >= 0; $num_fila--) {
			$resultado->data_seek($num_fila);
			$fila = $resultado->fetch_assoc();
		}
		$contaseñadesencriptada = $fila['contrasenia'];
		//$contaseñadesencriptada = sha1($fila['contrasenia'] );
		if( $contrasena_login == $contaseñadesencriptada){
			//las contraseñas son iguales
			$_SESSION['admin'] = $usuario_login;
			header('Location: ../public/');
		
		}else{
			die();
		}
		}
		public function cerrarsesion(){
			session_start();
          // Destruir todas las variables de sesión.
          $_SESSION = array();

          // Finalmente, destruir la sesión.
          session_destroy();
		}
	} ?>

