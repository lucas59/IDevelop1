<?php 
class Empresa extend Usuario {
	private $nombre = '';
	private $fecha_Creacion = '';
	private $direccion = '';
	private $telefono = '';
	private $reclutador = '';
	private $rubro = '';
	private $mision = '';
	private $vision = '';
	private $proyectos = array();

	function __construct($nombre='',$fecha_Creacion='',$direccion='',$telefono='',$reclutador='',$rubro='',$mision='',$vision='', $proyectos = ''){
		$this->nombre = $nombre;
		$this->fecha_Creacion = $fecha_Creacion;
		$this->direccion = $direccion;
		$this->telefono = $telefono;
		$this->reclutador = $reclutador;
		$this->rubro = $rubro;
		$this->mision = $mision;
		$this->vision = $vision;
		$this->proyectos = $proyectos;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function getFecha_Creacion(){
		return $this->fecha_Creacion;
	}

	public function getDireccion(){
		return $this->direccion;
	}

	public function getTelefono(){
		return $this->telefono;
	}

	public function getReclutador(){
		return $this->reclutador;
	}

	public function getRubro(){
		return $this->rubro;
	}

	public function getMision(){
		return $this->mision;
	}

	public function getVision(){
		return $this->vision;
	}

	public function getProyecto(){
		return $this->proyecto;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function setFecha_creacion($fecha_Creacion){
		$this->fecha_Creacion = $fecha_Creacion;
	}

	public function setDireccion($direccion){
		$this->direccion = $direccion;
	}

	public function setTelefono($telefono){
		$this->telefono = $telefono;
	}

	public function setReclutador($reclutador){
		$this->
	}

	public function setProyecto($proyecto){
		array_push($this->proyecto, $proyecto);
	}

}
?>