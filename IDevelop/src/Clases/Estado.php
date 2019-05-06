<?php 
class Estado
{
	private $nombre = '';
	private $fechaini = '';
	private $fechafin = '';

	function __construct($nombre = '',$fechaini = '',$fechafin = '')
	{
		$this->nombre = $nombre;
		$this->fechaini = $fechaini;
		$this->fechafin = $fechafin;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function getFechaini(){
		return $this->fechaini;
	}

	public function getFechafin(){
		return $this->fechafin;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function setFechaini($fechaini){
		$this->fechaini = $fechaini;
	}

	public function setFechafin($fechafin){
		$this->fechafin = $fechafin;
	}
}

 ?>