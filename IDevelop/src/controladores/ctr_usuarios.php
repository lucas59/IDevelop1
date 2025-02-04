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

	public function enviarDatosDesarrollador($email,$idPais,$idCiudad,$lenguajes,$file,$foto){
		$subCurriculo = curriculum::subirCurriculum($file,$email);
		$subida= Usuario::subirFotoPerfil($foto,$email);
		if($subCurriculo && $subida){
			$idCurriculum = curriculum::obtenerIDCurriculo($email);
			$idFoto = Usuario::obtenerIDFoto($email);
			$actualizar=Usuario::actalizarIDFoto($idFoto,$email);
			$actualizacion= Desarrollador::actualizarAltaUser($email,$idPais,$idCiudad,$lenguajes,$idCurriculum);	
			return $actualizacion;
		}else{
			return false;
		}
	}

	public function editarDatosDesarrollador($email, $nombre, $apellido,$lenguaje,$arrayCurriculo,$arrayFoto){
		if($arrayCurriculo){
			curriculum::actualizarCurriculo($arrayCurriculo,$email);	
		}
	
	if ($arrayFoto) {
			 Usuario::actualizarFotoPerfil($arrayFoto,$email);
		}	

		$actualizacion= Desarrollador::actualizarPerfil($email,$nombre,$apellido,$lenguaje);		
		
		return $actualizacion;
		
	}


	public function ponerSession($email,$tipoUsuario){
		
		if(!isset($_SESSION)) 
		{ 
			session_start(); 
		}
		if($tipoUsuario=='e'){
			$empresa = Empresa::obtenerEmpresa_login($email);
			$_SESSION['admin'] = $empresa;

		}else{
			$desarrollador = Desarrollador::obtenerDesarrollador_login($email);
			$_SESSION['admin'] = $desarrollador;

		}
		
	}

	public function enviarDatosEmpresa($pais,$ciudad,$email,$vision,$mision,$tel,$rubro,$reclutador,$direccion,$foto){
		
		$subida= Usuario::subirFotoPerfil($foto,$email);
		if($subida){
			$idFoto = Usuario::obtenerIDFoto($email);
			$actualizar=Usuario::actalizarIDFoto($idFoto,$email);
			return Empresa::actualizarAltaUser($pais,$ciudad,$email,$vision,$mision,$tel,$rubro,$reclutador,$direccion);	

		}
	}
public function	actualizarDatosEmpresa($email,$nombre,$vision,$mision,$tel,$rubro,$reclutador,$direccion,$foto){
	
	if ($foto) {
			 Usuario::actualizarFotoPerfil($foto,$email);
		}	

		$actualizacion= Empresa::actualizarPerfil($email,$nombre,$vision,$mision,$tel,$rubro,$reclutador,$direccion);		
		
		return $actualizacion;

}


	public function obtenerUsuarioPorToken($token){
		$validacion= Validaciones::obtenerValidacion($token);
		$email=$validacion->email;
		echo Console::log("er",$email);
		$usuarioDesarrollador = Desarrollador::obtenerDesarrollador($email);
		if($usuarioDesarrollador!=null){
			return $usuarioDesarrollador;
		}else{
			$usuarioEmpresa = Empresa::obtenerEmpresa($email);
			return $usuarioEmpresa;
		}
	}

	public function obtenerUsuario($id,$tipo){
		if ($tipo==0) {
			return Desarrollador::obtenerDesarrollador_login($id);
		}else{
			return Empresa::obtenerEmpresa_login($email);
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
		return Desarrollador::obtenerDesarrolladoresParaFiltrar();
	}

	public function obtenerDesarrolladoresParaFiltrar(){
		return Usuario::obtenerDesarrolladoresParaFiltrar();
	}
	
	public function obtenerEmpresasParaFiltrar(){
		return Usuario::obtenerEmpresasParaFiltrar();
	}

	public function Login($email,$pass){
		return Usuario::Login($email,$pass);
	}


	public function desactivarUsuario($correo){
		return Usuario::desactivarUsuario($correo);
	}

	public function obtenerPais($id){
		return Pais::obtenerPais($id);
	}

	public function obtenerCiudad($id){
		return Ciudad::obtenerCiudad($id);
	}

	public function PerfilDesarrollador($email){
		return Desarrollador::perfil($email);
	}
	public function DesarrolladorHerramientas($email){
		return Desarrollador::ObtenerHerramientas($email);
	}
	public function DesarrolladorProyectos($email){
		return Desarrollador::ObtenerProyectos($email);
	}
	public function DesarrolladorExperiencia($email){
		return Desarrollador::ObtenerExperiencia($email);
	}
	public function listarEmprezas(){
		return Usuario::obtenerEmpresasParaFiltrar();
	}
	public function PerfilEmpresa($email){
		return Empresa::perfilEmpresa($email);
	}
	public function proyectosEmpresa($email){
		return Empresa::proyectosEmpresa($email);
	}
	public function ElejirPostulante($email,$idProyecto){
		return Empresa::ElejirPostulante($email,$idProyecto);
	}
	public function obtenerCurriculo($email){
		return curriculum::obtenerCurriculo($email);
	}
}
?>
