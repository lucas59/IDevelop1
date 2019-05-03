<?php 
class Postulacion 
{
	private $fecha_postulacion = '';
	private $desarrollador = '';
	private $proyecto = '';

	function __construct($fecha_postulacion = '', $desarrollador = '', $proyecto = '')
	{
		$this->fecha_postulacion = $fecha_postulacion;
		$this->desarrollador = $desarrollador;
		$this->proyecto = $proyecto;
	}

	public function getFechapostulacion(){
		return $this->fecha_postulacion;
	}

	public function getDesarrollador(){
		return $this->desarrollador;
	}

	public function getProyecto(){
		return $this->proyecto;
	}

	public function setFechapostulacion($fecha_postulacion){
		$this->fecha_postulacion = $fecha_postulacion;
	}

	public function setDesarrollador($desarrollador){
		$this->desarrollador = $desarrollador;
	}

	public function setProyecto($proyecto){
		$this->proyecto = $proyecto;
	}
}

 ?>