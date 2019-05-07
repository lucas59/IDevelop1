<?php 
/**
  * 
  */
require_once '../Clases/Usuario.php';
class ctr_usuarios{

	function __construct(){
	}

	public function validarEmail($email){
		$usuario=new Usuario();
		$usuario->setEmail($email);
		return $usuario->verificarExistencia;
	}
} ?>