<?php 
class Proyecto {
	private $nombre = '';
	private $descripcion = '';
	private $fechaEntrega = '';
	private $estado = array();
	private $avanceDesarrollo = '';
	private $postulacion = '';
	private $herramientas = array();

	function __construct($nombre = '', $descripcion = '', $fechaEntrega = '', $estado = '',$avanceDesarrollo = '', $postulacion = '', $herramientas = array()){
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->fechaEntrega = $fechaEntrega;
		$this->estado = $estado;
		$this->avanceDesarrollo = $avanceDesarrollo;
		$this->postulacion = $postulacion;
		private $herramientas = array();
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function getDescripcion(){
		return $this->descripcion;
	}

	public function getFechaentrega(){
		return $this->fechaEntrega;
	}

	public function getEstado(){
		return $this->estado;
	}

	public function getAvanceDesarrollo(){
		return $this->avanceDesarrollo;
	}

	public function getPostulacion(){
		return $this->postulacion;
	}

	public function getHerramientas(){
		return $this->herramientas;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}

	public function setFechaentrega($fechaEntrega){
		$this->fechaEntrega = $fechaEntrega;
	}

	public function setEstado($estado){
		array_push($this->estado = $estado);
	}

	public function setAvanceDesarrollo($avanceDesarrollo){
		$this->avanceDesarrollo = $avanceDesarrollo;
	}

	public function setPostulacion($postulacion){
		$this->postulacion = $postulacion;
	}

	public function setHerramientas($herramientas){
		array_push($this->herramientas,$herramientas);
	}


}
 ?>