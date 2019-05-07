<?php 
class Casodeuso 
{
	private $nombre;
	private $descripcion;
	private $puntosTot; // traduccion de tiempo en puntos de realizar el caso de uso
	
	function __construct($nombre, $descripcion, $puntosTot)
	{
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->puntosTot = $puntosTot;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function getDescripcion(){
		return $this->descripcion;
	}

	public function getPuntosTot(){
		return $this->puntosTot;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}

	public function setPuntosTot($puntos){
		$this->puntosTot = $puntos;
	}
}
 ?>