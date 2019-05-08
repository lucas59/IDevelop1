<?php 
/**
  * 
  */
include_once '../src/Clases/Usuario.php';
include_once '../src/Clases/Empresa.php';
include_once '../src/Clases/Validaciones.php';
include_once '../src/conexion/abrir_conexion.php';
class ctr_usuarios{

	function __construct(){
	}

	public function validarEmail($email){
		$usuario=new Usuario();
		$retorno = $usuario->verificarExistencia($email);
		return $retorno;
	}


	public function ingresarUsuario($email,$nombre,$apellido,$contrasenia,$fecha,$sexo,$tipo){

		
		$usuario = new Usuario($email,null,sha1($contrasenia),null);
		$retorno =$usuario->registrarse(); 
		$validacion=new Validaciones($email,"",date("Y-m-d"));
		$validacion->registrarse();

		return $retorno;

			 /*
			$empresa= new Empresa($email,null,$contraseña, null,$nombre,$fecha,null,null,null,null,null,null,null);
			return $empresa->registrarse();
		}else{
			$desarrollador = new Desarrollador($email,null,$contraseña,null,$apellido,$fecha,null,null,null,null, null,null,null);
			return $desarrollador->registrarse();*/

		}
	} ?>