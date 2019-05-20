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

	public function Altaproyecto_postulacion(){
		$sql=DB::conexion()->prepare("INSERT INTO `proyecto_postulacion` (`Proyecto_id`, `postulaciones_id`) VALUES (?,?)");
		$sql->bind_param('si',$this->getProyecto(),$this->getPostulacion());
		if ($sql->execute()) {
			return "1";
		}else{
			return "0";
		}  
	}

}

?>