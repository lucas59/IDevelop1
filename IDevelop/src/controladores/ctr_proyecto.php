<?php 

require_once '../src/Clases/Usuario.php';
require_once '../src/Clases/Empresa.php';
require_once '../src/Clases/Desarrollador.php';
require_once '../src/conexion/abrir_conexion.php';
require_once '../src/Clases/console.php';
require_once '../src/Clases/Proyecto.php';
require_once '../src/Clases/Postulacion.php';
require_once '../src/Clases/proyecto_postulacion.php';


/**
 */class ctr_proyecto {




public function validarNombreProyecto($nombre){
	$resultado = Proyecto::nombreProyectoDisponible($nombre);
	return $resultado;
}

public function agregarProyecto($nombre, $descripcion, $fechaE, $fechaFP){
	if( isset($_SESSION['admin']) == true ){
			//chequear que sea empresa
		$proyecto = new Proyecto($nombre, $descripcion, $fechaEntrega,$fechaFinPostulacion,NULL, NULL, NULL, $proponente);

		$retorno = $proyecto->subirProyecto();

		if($retorno =="1"){
				//comportamiento correcto
		}else{
				//mal
		}
	}
}

public function Listar_Proyectos(){
	$resultado = Proyecto::Listar_proyectos();
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
}

?>