<?php 

require_once '../src/Clases/Usuario.php';
require_once '../src/Clases/Empresa.php';
require_once '../src/Clases/Desarrollador.php';
require_once '../src/conexion/abrir_conexion.php';
require_once '../src/Clases/console.php';
require_once '../src/Clases/Proyecto.php';
require_once '../src/Clases/Postulacion.php';
require_once '../src/Clases/Casodeuso.php';
require_once '../src/Clases/proyecto_postulacion.php';
require_once '../src/Clases/console.php';
/**
 */class ctr_proyecto {


function __construct(){
}



public function validarNombreProyecto($nombre){
	$resultado = Proyecto::validarNombreP($nombre);
	return $resultado;
}

public function validarNombreCasoDeUso($nombre){
	$resultado = Casodeuso::validarNombreCU($nombre);
	return $resultado;
}

public function agregarCasoDeUso($nombre, $descripcion, $impacto){
	$insetado = Casodeuso::subirCasoDeUso($nombre,$descripcion,$impacto);
	return $insertado;
}

public function agregarProyecto($nombre, $descripcion, $fechaE, $fechaFP){
	$usuario = $_SESSION['admin']->id;
	$insertado = Proyecto::subirProyecto($nombre, $descripcion, $fechaE, $fechaFP,$usuario);
	return $insertado;
}

public function Listar_Proyectos($id){
	$resultado = Proyecto::Listar_proyectos_postularse($id);
	return $resultado;
}

public function Listar_Proyectos_usuario($id){
	$resultado = Proyecto::Listar_proyectos_despostularse($id);
	return $resultado;
}

public function PostularseProyecto($id,$usuario){
	$retorno_1 = Postulacion::AltaPostulacion($usuario,$id);
	$id_postulacion = Postulacion::Buscar_postulacion($id,$usuario);
	$retorno_2 = proyecto_postulacion::Altaproyecto_postulacion($id,$id_postulacion);	
	if($retorno_1 == "1" && $retorno_2 == "1"){
		return "1";
	}else{
		return "0";
	}
}

public function DespostularseProyecto($id,$usuario){
	$id_postulacion = Postulacion::Despostularse_postulacion($id,$usuario);	
	if($id_postulacion == "1"){
		return "1";
	}else{
		return "0";
	}
}
public function PostulantesDeProyecto($idProyecto){
	return Postulacion::PostulantesDeProyecto($idProyecto);
}

public function ListarProyectosDeDesarrolladores($email){
	return Proyecto::ListarProyectosDeDesarrolladores($email);
}
public function ListarProyectosDeEmpresa($email){
	return Proyecto::ListarProyectosDeEmpresa($email);
}

public function verificarReferencia($session, $idProyecto,$tipo){
	if ($tipo==1) {
		return Empresa::verificarReferencia($session,$idProyecto);
	}else{
		return Desarrollador::verificarReferencia($session,$idProyecto); 
	}
}

public function obtenerProyecto($idProyecto){
	return Proyecto::obtenerProyecto($idProyecto);
}
}

?>