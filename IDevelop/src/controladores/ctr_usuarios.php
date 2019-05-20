  <?php 
/**
  * 
  */
require_once '../src/Clases/Usuario.php';
require_once '../src/Clases/Empresa.php';
require_once '../src/Clases/Pais.php';
require_once '../src/Clases/Ciudad.php';
require_once '../src/Clases/Desarrollador.php';
require_once '../src/Clases/Validaciones.php';
require_once '../src/conexion/abrir_conexion.php';
require_once '../src/Clases/curriculum.php';
require_once '../src/Clases/console.php';
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
		$insertUsu=Usuario::registrarUsuario($email,null,sha1($contrasenia),0,$tipo);
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
		$validacion= Validaciones::obtenerValidacion($token); //obtengo la validacion
		//echo Console::log("asd",$validacion);
		if($validacion!=null){
			$fecha = $validacion->fecha;
			$estado =Usuario::verEstadoDeUsuario($validacion->email); 
			if($estado == "1"){
				return false;
			}else{
				$fechavalida= $this->comprobarfecha($validacion->fecha);
				echo Console::log("asd",$fechavalida);

				if($fechavalida=="1"){
					$activacion=Usuario::activarUsuario($validacion->email,1);		

					if($activacion){
						return true;
					}
				}else{
					return false;
				}	
			}
		}else{
			return false;
		}
	}

	public function listarPaises(){
		return Pais::listarPaises();
	}
	public function listarCiudades($pais){
		return Ciudad::listarCiudad($pais);
	}

	public function enviarDatosDesarrollador($email,$idPais,$idCiudad,$lenguajes,$file){
		$subCurriculo = curriculum::subirCurriculum($file,$email);
		if($subCurriculo){
			$idCurriculum = curriculum::obtenerIDCurriculo($email);
			//echo Console::log("asd", $idCurriculum);
			$actualizacion= Desarrollador::actualizarAltaUser($email,$idPais,$idCiudad,$lenguajes,$idCurriculum);	
			return $actualizacion;
		}else{
			return false;
		}
	}

	public function ponerSession($email,$tipoUsuario){
		if(!isset($_SESSION)) 
		{ 
			session_start(); 
		}
		if($tipoUsuario=='e'){
			$empresa = Empresa::obtenerEmpresa($email);
			$_SESSION['admin'] = $empresa;

		}else{
			$desarrollador = Desarrollador::obtenerDesarrollador($email);
			$_SESSION['admin'] = $desarrollador;

		}
		
	}

	public function enviarDatosEmpresa($pais,$ciudad,$email,$vision,$mision,$tel,$rubro,$reclutador,$direccion){
		return Empresa::actualizarAltaUser($pais,$ciudad,$email,$vision,$mision,$tel,$rubro,$reclutador,$direccion);	

	}


	public function obtenerUsuarioPorToken($token){
		$validacion= Validaciones::obtenerValidacion($token);
		$email=$validacion->email;
		$usuarioDesarrollador = Desarrollador::obtenerDesarrollador($email);
		if($usuarioDesarrollador!=null){
			return $usuarioDesarrollador;
		}else{
			$usuarioEmpresa = Empresa::obtenerEmpresa($email);
			return $usuarioEmpresa;
		}
	}
	
	public function comprobarfecha($fecha){
		$retorno=false;
		$fechaActual = date("y-m-d");
		$nuevafecha = strtotime ( '-60 day' , strtotime ( $fechaActual ) );
		$fechaIni = strtotime ( '-30 day' , strtotime ( $fecha ) );
		if($nuevafecha<$fechaIni){
			$retorno = "1";
		}
		return $retorno;
	}
	public function cerrarsesion(){
		$_SESSION['admin'] = null;

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
			//TRAIGO TODOS LOS DESARROLLADORES
			$email1 =$fila['email'];
			$consulta2 = DB::conexion()->prepare('SELECT * FROM desarrollador WHERE id= ?');
			$consulta2->bind_param('s',$email1);	
			$consulta2->execute();
			$resultado2 = $consulta2->get_result();
			if($resultado2->num_rows >0 ){

				for ($num_fila2 = $resultado2->num_rows - 1; $num_fila2 >= 0; $num_fila2--) {
					$resultado2->data_seek($num_fila2);
					$fila2 = $resultado2->fetch_assoc();

					$pais = $this->obtenerPais($fila2['pais_id']);
					$ciudad_actual= $this->obtenerCiudad($fila2['ciudad_id']);
					$email = $fila2['id'];
					$foto = $fila['foto'];
					$cedula = $fila2['cedula'];
					$apellido =  $fila2['apellido'];
					$fecha_Nacimiento =$fila2['fechaNacimiento'];				
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


	public function desactivarUsuario($correo){
		return Usuario::desactivarUsuario($correo);
	}
}
?>
