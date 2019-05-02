<?php 
class Usuario {
	private $email = '';
	private $foto_perfil = '';
	private $contrasena = '';

	public function __construct($email='',$foto_perfil='',$contrasena=''){
		$this->email = $email;
		$this->foto_perfil = $foto_perfil;
		$this->contrasena = $contrasena;
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

	public function setEmail($email){
		$this->email = $email;
	}

	public function setFoto_perfil($foto_perfil){
		$this->foto_perfil = $foto_perfil;
	}

	public function setContrasena($contrasena){
		$this->contrasena = $contrasena;
	}
}
 ?>