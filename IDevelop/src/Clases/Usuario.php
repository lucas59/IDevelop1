<?php 
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
}
 ?>