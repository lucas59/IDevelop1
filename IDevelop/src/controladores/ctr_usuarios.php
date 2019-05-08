<?php 
/**
  * 
  */
include_once '../src/Clases/Usuario.php';
include_once '../src/Clases/Empresa.php';
include_once '../src/Clases/Validaciones.php';
include_once '../src/conexion/abrir_conexion.php';
class ctr_usuarios{

	function __construct(){
	}

	public function validarEmail($email){
		$usuario=new Usuario();
		$retorno = $usuario->verificarExistencia($email);
		return $retorno;
	}


	public function ingresarUsuario($email,$nombre,$apellido,$contrasenia,$fecha,$sexo,$tipo){

		
		$usuario = new Usuario($email,null,sha1($contrasenia),null);
		$retorno =$usuario->registrarse(); 
		$validacion=new Validaciones($email,"",date("Y-m-d"));
		$validacion->registrarse();

		return $retorno;

			 /*
			$empresa= new Empresa($email,null,$contraseña, null,$nombre,$fecha,null,null,null,null,null,null,null);
			return $empresa->registrarse();
		}else{
			$desarrollador = new Desarrollador($email,null,$contraseña,null,$apellido,$fecha,null,null,null,null, null,null,null);
			return $desarrollador->registrarse();*/

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