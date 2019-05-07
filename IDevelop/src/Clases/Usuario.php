<?php 
if(class_exists("Usuario"))
	return;

class Usuario 
{
	private $email = '';
	private $foto_perfil = '';
	private $contrasena = '';
	private $validaciones = array();
	function __construct($email='',$foto_perfil='',$contrasena='', $validaciones = array())
	{
		$this->email = $email;
		$this->foto_perfil = $foto_perfil;
		$this->contrasena = $contrasena;
		$this->validaciones = $validaciones;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getFoto_perfil(){
		return $this->foto_perfil;
	}

	public function getContrasena(){
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

	public function setContrasena($contrasena){
		$this->contrasena = $contrasena;
	}

	public function setValidaciones($validaciones){
		array_push($this->validaciones, $validaciones);
	}

	public function verificarExistencia($email){
		$consulta = DB::conexion()->prepare('SELECT * FROM usuario WHERE email= ?');
		$consulta->bind_param('s',$email);		
		$consulta->execute();
		$resultado = $consulta->get_result();
		if ($resultado->num_rows == 1) {
			echo true;
		} else if($resultado->num_rows==0) {
			echo false;
		}
	}
}
?>