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
	}
		public function cerrarsesion(){
					
          // Destruir todas las variables de sesión.
          $_SESSION = array();

          // Finalmente, destruir la sesión.
          session_destroy();
		}

		public function obtenerUsuarios(){
          //TRAIGO TODOS LOS USUARIOS
          $consulta = DB::conexion()->prepare('SELECT * FROM usuario');	
          $consulta->execute();
          $resultado = $consulta->get_result();
          if(!$resultado){
               header('Location: ../public/');
               die();
					 }
					 $usuarios = array();
					 for ($num_fila = $resultado->num_rows - 1; $num_fila >= 0; $num_fila--) {
						$resultado->data_seek($num_fila);
						$fila = $resultado->fetch_assoc();
						$consulta2 = DB::conexion()->prepare('SELECT * FROM desarrollador WHERE id= ?');
						$email1 =$fila['email'];
						$consulta2->bind_param('s',$email1);	
						$consulta2->execute();
						$resultado2 = $consulta2->get_result();
						if($resultado2){
        
							for ($num_fila2 = $resultado2->num_rows - 1; $num_fila2 >= 0; $num_fila2--) {
								$resultado2->data_seek($num_fila2);
								$fila2 = $resultado2->fetch_assoc();
							
							$email = $fila2['id'];
							$foto = $fila['foto'];
							$cedula = $fila2['cedula'];
							$apellido =  $fila2['apellido'];
							$fecha_Nacimiento =$fila2['fechaNacimiento'];
							$pais =$fila2['pais'];
							$ciudad_actual =$fila2['ciudad'];
							$desarrollo_preferido =$fila2['desarrolloPreferido'];
							$desarrollador = new Desarrollador($email,$foto,"",$cedula,$apellido,$fecha_Nacimiento,$pais,$ciudad_actual,$desarrollo_preferido,$experienca_laboral = array(), "", $herramientas = array(), $proyectos = array());
						array_push($usuarios,$desarrollador);
							}
						
				}
			}
           return $usuarios;
        
	}
	 public function Login($email,$pass){
		return Usuario::Login($email,$pass);
	}
}
	?>
