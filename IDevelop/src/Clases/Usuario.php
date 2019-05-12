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
}
?>