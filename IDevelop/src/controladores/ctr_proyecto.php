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
require_once '../src/Clases/Correos.php';
require_once '../src/Clases/console.php';
/**
 */class ctr_proyecto {


function __construct(){
}



public function validarNombreProyecto($nombre){
	$resultado = Proyecto::validarNombreP($nombre);
	return $resultado;
}

public function validarNombreCasoDeUso($nombre, $proyecto){
	$resultado = Casodeuso::validarNombreCU($nombre, $proyecto);
	return $resultado;
}

public function agregarCasoDeUso($nombre, $descripcion, $impacto, $proy){
	$insertado = Casodeuso::subirCasoDeUso($nombre,$descripcion,$impacto, $proy);
	return $insertado;
}

public function actualizarCU($id, $progreso, $nombre){
	$actualizado = Casodeuso::actualizarCasoDeUso($id, $progreso, $nombre);
	return $actualizado;
}

public function eliminarCU($id, $nombre){
	$actualizado = Casodeuso::eliminarCU($id, $nombre);
	return $actualizado;
}

public function agregarProyecto($nombre, $descripcion, $fechaE, $fechaFP){
	$usuario = $_SESSION['admin']->id;
	$insertado = Proyecto::subirProyecto($nombre, $descripcion, $fechaE, $fechaFP,$usuario);
	return $insertado;
}

public function hayPlanificacion($id){
	$retorno = Casodeuso::ExistePlanificacion($id);

	if($retorno == "1"){
		return "1";
	}else{
		return "0";
	}
}

public function PostularseProyecto($id,$usuario){
	$retorno_1 = Postulacion::AltaPostulacion($usuario,$id);	
	if($retorno_1 == "1"){
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

public function Listarcasosdeuso($idProyecto){
	return Casodeuso::listacasodeuso($idProyecto);
}

public function ListarProyectosDeDesarrolladores($email){
	return Proyecto::ListarProyectosDeDesarrolladores($email);
}

public function ListarProyectosEnDesarrollo($email){
	return Proyecto::ListarProyectosEnDesarrollo($email);
}
public function ListarProyectosDeEmpresa($email){
	return Proyecto::ListarProyectosDeEmpresa($email);
}


public function ListarProyectosPostulados($email){
	return Proyecto::ListarProyectosPostulados($email);
}

public function ListarProyectosFinalizados($email){
	return Proyecto::ListarProyectosFinalizados($email);
}

public function listarProyectos(){
	return Proyecto::ListarProyectos();
}

public function verificarReferencia($session, $idProyecto,$tipo){
	if ($tipo==1) {
		return Empresa::verificarReferencia($session,$idProyecto);
	}else{
		return Desarrollador::verificarReferencia($session,$idProyecto); 
	}
}

public function verificarPostulacion($session, $idProyecto){
	if(Proyecto::usuario_postualarse_validacion($idProyecto,$session) == "1"){
		return "1";
	}
}

public function verificarTrabajo_proyecto($session, $idProyecto){
	if(Proyecto::verificar_Trabajo_proyecto_validacion($idProyecto,$session) == "1"){
		return "1";
	}
}

public function Activar_desactivar_proyecto($proyecto,$estado,$finPos,$finPro){
	return Proyecto::Activar_desactivar_proyecto($proyecto,$estado,$finPos,$finPro);
}

public function Activar_desactivar_proyecto_des($proyecto,$estado){
	return Proyecto::Activar_desactivar_proyecto_des($proyecto,$estado);
}

public function obtenerProyecto($idProyecto){
	return Proyecto::obtenerProyecto($idProyecto);
}

public function enviarCorreo($id_proyecto,$email,$titulo,$mensaje){
	return Correos::enviarMail($id_proyecto, $email, $titulo, $mensaje);
}

public function verificarContratacion($idProyecto){
	return Proyecto::verificarContratacion($idProyecto);
}

public function obtenerProyectoCU($idproy){
	return Proyecto::ObtenerProyectoCU($idproy);
}

public function obtenerProgresoTotalProy($idProyecto){
	return Casodeuso::calcularProgresoTotalProyecto($idProyecto);
}

public function obtenerPuntosTotalProy($idProyecto){
	return Casodeuso::calcularPuntosTotalesProyecto($idProyecto);


}
}

?>