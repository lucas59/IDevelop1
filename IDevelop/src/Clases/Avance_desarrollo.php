<?php 
class Avance_desarrollo 
{
	private $puntosActuales; // progreso del caso de uso con respecto a los puntos que tiene C.U.
	private $casodeuso;

	function __construct($puntosActuales,$casodeuso)
	{
		$this->puntosTot = $puntosActuales;
		$this->casodeuso = $casodeuso;
	}

	public function getPuntosTot(){
		return $this->puntosTot;
	}

	public function getAvance(){
		return $this->avance;
	}

	public function getCasodeuso(){
		return $this->casodeuso;
	}

	public function setPuntosActuales($puntosActuales){
		$this->puntosActuales = $puntosActuales;
	}

	public function setAvance($avance){
		$this->avance = $avance;
	}

	public function setCasodeuso($casodeuso){
		array_push($this->casodeuso, $casodeuso);
	}

	public function getAvance(){
		//return (($this->puntosActuales * '100') / $this->casodeuso->getPuntosTot());
	}
} 

 ?>