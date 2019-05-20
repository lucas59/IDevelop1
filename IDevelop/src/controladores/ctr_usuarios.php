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
		 
			$consulta = DB::conexion()->prepare('SELECT * FROM usuario WHERE email= ?');
			$consulta->bind_param('s',$email);		
			$consulta->execute();
			$resultado = $consulta->get_result();
			if(!$resultado->num_rows > 0){
				return "0";	
			}
			
			for ($num_fila = $resultado->num_rows - 1; $num_fila >= 0; $num_fila--) {
				$resultado->data_seek($num_fila);
				$fila = $resultado->fetch_assoc();
			}
			$contaseñaencriptada = $fila['contrasenia'];
			
			if( sha1($pass) == $contaseñaencriptada){
				
				//las contraseñas son iguales
				$consulta2 = DB::conexion()->prepare('SELECT * FROM desarrollador WHERE id= ?');
				$consulta2->bind_param('s',$email);		
				$consulta2->execute();
				$resultado2 = $consulta2->get_result();
				if($resultado2->num_rows > 0){
				for ($num_fila2 = $resultado2->num_rows - 1; $num_fila2 >= 0; $num_fila2--) {
					$resultado2->data_seek($num_fila2);
					$fila2 = $resultado2->fetch_assoc();
				}
				
				$email = $fila2['id'];
				$foto = $fila['foto'];
				$cedula = $fila2['cedula'];
				$apellido =  $fila2['apellido'];
				$fecha_Nacimiento =$fila2['fechaNacimiento'];
				$pais =$fila2['pais'];
				$ciudad_actual =$fila2['ciudad'];
				$desarrollo_preferido =$fila2['desarrolloPreferido'];
				$desarrollador = new Desarrollador($email,$foto,"",$cedula,$apellido,$fecha_Nacimiento,$pais,$ciudad_actual,$desarrollo_preferido,$experienca_laboral = array(), "", $herramientas = array(), $proyectos = array());	
				$_SESSION['admin'] = $desarrollador;
				return "1";
			
			}else{
				$consulta3 = DB::conexion()->prepare('SELECT * FROM empreza WHERE id= ?');
				$consulta3->bind_param('s',$email);		
				$consulta3->execute();
				$resultado3 = $consulta3->get_result();
			   
				if($resultado3->num_rows > 0){
			
				for ($num_fila3 = $resultado3->num_rows - 1; $num_fila3 >= 0; $num_fila3--) {
					$resultado3->data_seek($num_fila3);
					$fila3 = $resultado3->fetch_assoc();
				}
				
				$email = $fila3['id'];
				$foto_perfil = $fila['foto'];
				$cedula = $fila3['cedula'];
				$nombre =  $fila3['nombre'];
				$fecha_Creacion =$fila3['fechaCreacion'];
				$direccion  =$fila3['direccion'];
				$telefono =$fila3['telefono'];
				$reclutador =$fila3['reclutador'];
				$vision =$fila3['vision'];
				$mision =$fila3['mision'];
				$rubro =$fila3['rubro'];
				$empreza = new Empreza($email,$foto_perfil,"", $validaciones = array(),$nombre,$fecha_Creacion,$direccion,$telefono,$reclutador,$rubro,$mision,$vision,"");
				$_SESSION['admin'] = $empreza;
				return "1";
			}else{
				return "0";
			}
			}
		 }else{
			 return "0";
		 }
		}

	public function perfil($email){
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

	public function obtenerPais($id){
		$consulta4 = DB::conexion()->prepare('SELECT * FROM pais WHERE id= ?');
		$consulta4->bind_param('i',$id);	
		$consulta4->execute();
		$resultado4 = $consulta4->get_result();
		if($resultado4->num_rows >0 ){
			for ($num_fila4 = $resultado4->num_rows - 1; $num_fila4 >= 0; $num_fila4--) {
				$resultado4->data_seek($num_fila4);
				$fila4 = $resultado4->fetch_assoc();
			}
			$pais=$fila4['nombre'];
			return $pais;
		}
	}

	public function obtenerCiudad($id){
				$consulta3 = DB::conexion()->prepare('SELECT * FROM ciudad WHERE id= ?');
				$consulta3->bind_param('i',$id);	
				$consulta3->execute();
				$resultado3 = $consulta3->get_result();
				if($resultado3->num_rows >0 ){
					for ($num_fila3 = $resultado3->num_rows - 1; $num_fila3 >= 0; $num_fila3--) {
						$resultado3->data_seek($num_fila3);
						$fila3 = $resultado3->fetch_assoc();
					}
					$ciudad_actual=$fila3['nombre'];
					return $ciudad_actual;
				}
	}

	public function listarEmprezas(){
		return Empresa::listarEmpresas();
	}
	public function perfilEmpresa($email){
		return Empresa::perfilEmpresa($email);
	}
	
	public function proyectosEmpresa($email){
		return Empresa::proyectosEmpresa($email);
	}
}
?>
