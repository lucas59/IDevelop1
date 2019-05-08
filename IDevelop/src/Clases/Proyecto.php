<?php 
class Proyecto 
{
	private $nombre;
	private $descripcion;
	private $fechaEntrega;
	private $fechaFinPostulacion;
	private $estado;
	private $valoracionPuntos; //total de puntos de todos los casos de usos
	private $avanceDesarrollo;
	private $postulacion;
	private $proponente;

	function __construct($nombre, $descripcion, $fechaEntrega,$fechaFinPostulacion, $estado,$avanceDesarrollo, $postulacion, $proponente)
	{
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->fechaEntrega = $fechaEntrega;
		$this->fechaFinPostulacion = $fechaFinPostulacion;
		$this->estado = $estado;
		$this->avanceDesarrollo = $avanceDesarrollo;
		$this->postulacion = $postulacion;
		$this->proponente = $proponente;
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

	public function getDesarrolladores(){
		return $this->desarrolladores;
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

	public function setDesarrolladores($desarrolladores){
		array_push($this->desarrolladores, $descripcion);
	}

	public function obtenerAvanceProyecto(){


	}
}
 ?>