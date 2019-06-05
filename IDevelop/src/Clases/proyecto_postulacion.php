<?php
/**
 * 
 */
class proyecto_postulacion
{
	private $proyecto_id;
	private $postulaciones_id;
	
	function __construct($proyecto_id , $postulaciones_id)
	{
		$this->postulaciones_id = $postulaciones_id;
		$this->proyecto_id = $proyecto_id;
	}

	public function getProyecto(){
		return $this->proyecto_id;
	}

	public function getPostulacion(){
		return $this->postulaciones_id;
	}

	public function setProyecto($proyecto){
		$this->proyecto_id = $proyecto;
	}

	public function setPostulaciones($postulacion){
		$this->postulaciones_id = $postulacion;
	}

	

}

?>