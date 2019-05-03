<?php 
class Herramienta 
{
	private $nombre = '';
	
	function __construct($nombre = '')
	{
		$this->nombre = $nombre;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
}

 ?>