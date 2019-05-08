<?php 
class Validaciones
{
	public $email = '';
	public $token = '';
	public $fecha = '';
	function __construct($email, $token, $fecha)
	{
		$this->email = $email;
		$this->token = $token;
		$this->fecha = $token;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getToken(){
		return $this->token;
	}

	public function getFecha(){
		return $this->fecha;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function setToken($token){
		$this->token = $token;
	}

	public function setFecha($fecha){
		$this->fecha = $fecha;
	}
}

 ?>