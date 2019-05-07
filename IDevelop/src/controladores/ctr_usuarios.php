<?php 
/**
  * 
  */
require_once '../src/Clases/Usuario.php';
class ctr_usuarios{

	function __construct(){
	}

	public function validarEmail($email){
		$usuario=new Usuario();
		$usuario->setEmail($email);
		return $usuario->verificarExistencia;
	}
} ?>