<?php 
/**
  * 
  */
include_once '../src/Clases/Usuario.php';
include_once '../src/conexion/abrir_conexion.php';
class ctr_usuarios{

	function __construct(){
	}

	public function validarEmail($email){
		$usuario=new Usuario();
		$retorno = $usuario->verificarExistencia($email);
		return $retorno;
	}
} ?>