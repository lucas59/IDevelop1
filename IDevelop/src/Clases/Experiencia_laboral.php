<?php 
class Experiencia_laboral
{
	public $empresa = '';
	public $descripcion = '';
	public $fechaini = '';
	public $fechafin = '';
	public $contacto = '';
	function __construct($empresa = '', $descripcion = '', $fechaini = '', $fechafin = '', $contacto = '')
	{
		$this->empresa = $empresa;
		$this->descripcion = $descripcion;
		$this->fechaini = $fechaini;
		$this->fechafin = $fechafin;
		$this->contacto = $contacto;
	}

	public function getEmpresa(){
		return $this->empresa;
	}

	public function getDescripcion(){
		return $this->descripcion;
	}

	public function getFechaini(){
		return $this->fechaini;
	}

	public function getFechafin(){
		return $this->fechafin;
	}

	public function getContacto(){
		return $this->contacto;
	}

	public function setEmpresa($empresa){
		$this->empresa = $empresa;
	}

	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}

	public function setFechaini($fechaini){
		$this->Fechaini = $fechaini;
	}

	public function setFechafin($fechafin){
		$this->fechafin = $fechafin;
	}

	public function setContacto($contacto){
		$this->contacto = $contacto;
	}
}

 ?>