<?php 
/**
  * 
  */
class Pais {
	private $id;
	private $nombre;

	public function __construct($id,$nombre)
	{

		$this->id = $id;
		$this->nombre = $nombre;
	}

	public function getId(){
		return $this->id;
	}

	public function getNombre(){
		return $this->nombre;
	}


	public function setId($id){
		$this->id=$id;
	}

	public function setNombre($nombre){
		$this->nombre=$nombre;
	}

	public function listarPaises(){
		$sql=DB::conexion()->prepare("SELECT * FROM pais");
		$sql->execute();
		$resultado = $sql->get_result();
		while ($fila=$resultado->fetch_array()){
			$rows[] = $fila;
		}
		return $rows;
	}
} ?>