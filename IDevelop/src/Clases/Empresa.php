<?php 
class Empresa extend Usuario{
	private $nombre = '';
	private $fecha_Creacion = '';
	private $direccion = '';
	private $telefono = '';
	private $reclutador = '';
	private $rubro = '';
	private $mision = '';
	private $vision = '';

	public function __construct($nombre='',$fecha_Creacion='',$direccion='',$telefono='',$reclutador='',$rubro='',$mision='',$vision=''){
		$this->nombre = $nombre;
		$this->fecha_Creacion = $fecha_Creacion;
		$this->direccion = $direccion;
		$this->telefono = $telefono;
		$this->reclutador = $reclutador;
		$this->rubro = $rubro;
		$this->mision = $mision;
		$this->vision = $vision;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function getFecha_Creacion(){
		return $this->fecha_Creacion;
	}
}
?>