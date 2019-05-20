<?php 
class Postulacion 
{
	private $fecha_postulacion = '';
	private $desarrollador = '';
	private $proyecto = '';

	function __construct($fecha_postulacion, $desarrollador, $proyecto)
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

	public function AltaPostulacion(){
		$sql=DB::conexion()->prepare("INSERT INTO `postulacion` (`fechaPostulacion`, `proyecto_id`) VALUES (?,?)");
		$sql->bind_param('si',$this->getFechapostulacion(),$this->getProyecto());
		if ($sql->execute()) {
			return "1";
		}else{
			return "0";
		}  
	}
}

 ?>