<?php 
if(class_exists("Usuario"))
	return;

class Usuario 
{
	private $email;
	private $foto_perfil;
	private $contrasenia ;
	private $validaciones = array();
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

	public function getValidaciones(){
		return $this->validaciones;
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

	public function setValidaciones($validaciones){
		array_push($this->validaciones, $validaciones);
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


	public function registrarUsuario($email,$foto,$contrasenia){	
		$sql=DB::conexion()->prepare("INSERT INTO `usuario` (`email`, `contrasenia`, `foto`) VALUES (?,?,?)");
		$sql->bind_param('sss',$email,$contrasenia,$foto);
		if ($sql->execute()) {
			return "1";
		}else{
			return "0";
		} 
	}
}
?>