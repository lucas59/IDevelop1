<?php 
class Avance_desarrollo 
{
	private $puntosTot = '';
	private $avance = '';
	private $casodeuso = array();

	function __construct($puntosTot = '', $avance = '', $casodeuso = array())
	{
		$this->puntosTot = $puntosTot;
		$this->avance = $avance;
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

	public function setPuntosTot($puntosTot){
		$this->puntosTot = $puntosTot;
	}

	public function setAvance($avance){
		$this->avance = $avance;
	}

	public function setCasodeuso($casodeuso){
		array_push($this->casodeuso, $casodeuso);
	}
}

 ?>