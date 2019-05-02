<?php 
class Desarrollador extend Usuario{
	private $cedula = '';
	private $apellido = '';
	private $fecha_Nacimiento = '';
	private $pais = '';
	private $ciudad_actual = '';
	private $desarrollo_preferido = '';

	public function __construct($cedula='',$apellido='',$fecha_Nacimiento='',$pais ='',$ciudad_actual='',$desarrollo_preferido=''){
		$this->cedula = $cedula;
		$this->apellido = $apellido;
		$this->fecha_Nacimiento = $fecha_Nacimiento;
		$this->pais = $pais;
		$this->ciudad_actual = $ciudad_actual;
		$this->desarrollo_preferido = $desarrollo_preferido;
	}

	public function getCedula(){
		return $this->cedula;
	}

	public function getApellido(){
		return $this->apellido;
	}

	public function getFecha_Nacimiento(){
		return $this->fecha_Nacimiento;
	}

	public function getPais(){
		return $this->pais;
	}

	public function getCiudad_actual(){
		return $this->ciudad_actual;
	}

	public function getDesarrollo_preferido(){
		return $this->desarrollo_preferido;
	}


}
 ?>