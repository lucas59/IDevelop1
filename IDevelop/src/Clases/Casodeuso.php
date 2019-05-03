<?php 
/**
 * 
 */
class Casodeuso {
	private $nombre = '';
	private $descripcion = '';
	private $puntos = '';
	
	function __construct($nombre = '', $descripcion = '', $puntos = '')
	{
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->puntos = $puntos;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function getDescripcion(){
		return $this->descripcion;
	}

	public function getPuntos(){
		return $this->puntos;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}

	public function setPuntos($puntos){
		$this->puntos = $puntos;
	}
}
 ?>