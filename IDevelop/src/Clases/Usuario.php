<?php 
if(class_exists("Usuario"))
	return;

class Usuario 
{
	private $email;
	private $foto_perfil;
	private $contrasenia ;
	private $estado;
	function __construct($email,$foto_perfil,$contrasenia, $validaciones)
	{
		$this->email = $email;
		$this->foto_perfil = $foto_perfil;
		$this->contrasenia = $contrasenia;
		$this->validaciones = $validaciones;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getFoto_perfil(){
		return $this->foto_perfil;
	}

	public function getContrasenia(){
		return $this->contrasena;
	}

	
	public function getEstado(){
		return $this->estado;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function setFoto_perfil($foto_perfil){
		$this->foto_perfil = $foto_perfil;
	}

	public function setContrasenia($contrasena){
		$this->contrasena = $contrasena;
	}

	public function setEstado($estado){
		$this->estado = $estado;
	}


	public function verificarExistencia($email){
		$retorno=null;
		$consulta = DB::conexion()->prepare("SELECT * FROM usuario WHERE email= ?");
		$consulta->bind_param('s',$email);		
		$consulta->execute();
		$resultado = $consulta->get_result();
		if (mysqli_num_rows($resultado) == 1) {
			$retorno = "1";
		} else if($resultado->num_rows==0) {
			$retorno = "0";
		}
		return $retorno;
	}

	public function obtenerUsuario($email){
		$sql = DB::conexion()->prepare("SELECT * FROM usuario WHERE email = ?");
		$sql->bind_param('s',$email);
		$sql->execute();
		$resultado=$sql->get_result();
		return $resultado->fetch_object();
	}
	public function verEstadoDeUsuario($email){
		$consulta = DB::conexion()->prepare("SELECT * FROM usuario WHERE email= ?");
		$consulta->bind_param('s',$email);		
		$consulta->execute();
		$resultado = $consulta->get_result();
		$usuario=$resultado->fetch_object();
		if($usuario->estado==1){
			return "1";
		} else{
			return "0";
		}
	}

	public function activarUsuario($email,$estado){

		$sql=DB::conexion()->prepare("UPDATE `usuario` SET `estado` = ? WHERE `usuario`.`email` = ?");
		$sql->bind_param('is',$estado,$email);
		if ($sql->execute()) {
			return true;
		}else{
			return false;
		} 
	}


	public function registrarUsuario($email,$foto,$contrasenia,$estado,$tipo){
		$tipousu=0;
		if($tipo=="e"){
			$tipousu=1;
		}else{
			$tipousu=0;
		}
		$sql=DB::conexion()->prepare("INSERT INTO `usuario` (`email`, `contrasenia`, `estado`, `foto`, `tipo`) VALUES (?,?,?,?,?)");
		$sql->bind_param('ssisi',$email,$contrasenia,$estado,$foto,$tipousu);
		if ($sql->execute()) {
			return "1";
		}else{
			return "0";
		} 
	}

	public static function Login($email,$pass){

		$consulta = DB::conexion()->prepare('SELECT * FROM usuario WHERE email= ?');
		$consulta->bind_param('s',$email);		
		$consulta->execute();
		$resultado = $consulta->get_result();
		if(!$resultado){
			return "0";	
		}
		$controlador = new ctr_usuarios();
		for ($num_fila = $resultado->num_rows - 1; $num_fila >= 0; $num_fila--) {
			$resultado->data_seek($num_fila);
			$fila = $resultado->fetch_assoc();
		}
		$contaseñaencriptada = $fila['contrasenia'];
		$estado = $fila['estado'];
		if( sha1($pass) == $contaseñaencriptada && $estado == 1 ){

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
				$cedula ="";
				if(isset($fila2['cedula'])){
				$cedula = $fila2['cedula'];
				}
				$apellido =  $fila2['apellido'];
				$fecha_Nacimiento =$fila2['fechaNacimiento'];
				$pais="";
				if(isset($fila2['pais_id'])){
				$pais =$controlador->obtenerPais($fila2['pais_id']);
				}
				$ciudad_actual ="";
				if(isset($fila2['ciudad_id'])){
				$ciudad_actual =$controlador->obtenerCiudad($fila2['ciudad_id']);
				}
				$desarrollo_preferido ="";
				if(isset($fila2['desarrolloPreferido'])){
				$desarrollo_preferido =$fila2['desarrolloPreferido'];
				}
				$desarrollador = new Desarrollador($email,$foto,"",$cedula,$apellido,$fecha_Nacimiento,$pais,$ciudad_actual,$desarrollo_preferido,$experienca_laboral = array(), "", $herramientas = array(), $proyectos = array());

				/*if (!$_SESSION) {
					session_start();
					}	
					$_SESSION['admin'] = $desarrollador;*/
					ctr_usuarios::ponerSession($email,"d");
					return "1";

				}else{
					$consulta3 = DB::conexion()->prepare('SELECT * FROM empresa WHERE id= ?');
					$consulta3->bind_param('s',$email);		
					$consulta3->execute();
					$resultado3 = $consulta3->get_result();

					if($resultado3->num_rows){

						for ($num_fila3 = $resultado3->num_rows - 1; $num_fila3 >= 0; $num_fila3--) {
							$resultado3->data_seek($num_fila3);
							$fila3 = $resultado3->fetch_assoc();
						}

						$email = $fila3['id'];
						$foto_perfil = $fila['foto'];
						$cedula="";
						if(isset($fila3['cedula'])){
						$cedula = $fila3['cedula'];
						}
						$nombre =  $fila3['nombre'];
						$fecha_Creacion =$fila3['fechaCreacion'];
						$direccion="";
						if(isset($fila3['direccion'])){
						$direccion  =$fila3['direccion'];
						}
						$telefono="";
						if(isset($fila3['telefono'])){
						$telefono =$fila3['telefono'];
						}
						$reclutador="";
						if(isset($fila3['reclutador'])){
						$reclutador =$fila3['reclutador'];
						}
						$vision="";
						if(isset($fila3['vision'])){
						$vision =$fila3['vision'];
						}
						$mision="";
						if(isset($fila3['mision'])){
						$mision =$fila3['mision'];
						}
						$rubro="";
						if(isset($fila3['rubro'])){
						$rubro =$fila3['rubro'];
						}
						$empreza = new Empresa($email,$foto_perfil,"", $validaciones = array(),$nombre,$fecha_Creacion,$direccion,$telefono,$reclutador,$rubro,$mision,$vision,"");

						ctr_usuarios::ponerSession($email,"e");
					return "1";
				}else{
					return "0";
				}
			}
		}else{
			return "0";
		}
	}

	public function desactivarUsuario($correo){
		$sql = DB::conexion()->prepare("UPDATE usuario SET estado = 0 WHERE email = ? ");
		$sql->bind_param("s",$correo);
		return $sql->execute();
	}
}
?>