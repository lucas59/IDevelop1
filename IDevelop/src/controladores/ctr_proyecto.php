<?php 

require_once '../src/Clases/Usuario.php';
require_once '../src/Clases/Empresa.php';
require_once '../src/Clases/Desarrollador.php';
require_once '../src/conexion/abrir_conexion.php';
require_once '../src/Clases/console.php';
require_once '../src/Clases/Proyecto.php';


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

	public function PostularseProyecto($id){
		if( isset($_SESSION['admin']).tipo == 0 ){
			//chequear que sea desarrollador
			$proyecto = Proyecto::Buscar_proyecto($id);
			$postulacion = new Postulacion(getdate(), isset($_SESSION['admin']), $proyecto);
			$proyecto_postulacion = new proyecto_postulacion($proyecto,$postulacion);
			$retorno_1 = $postulacion->AltaPosulacion();
			$retorno_2 = $proyecto_postulacion->Altaproyecto_postulacion();
			if($retorno_1 == "1" && $retorno_2 == "2"){
				return true;
			}else{
				return false;
			}
		}
	}
	}

 ?>