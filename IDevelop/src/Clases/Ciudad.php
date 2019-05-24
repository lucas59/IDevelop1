<?php 
/**
  * 
  */
class Ciudad {

	private $id;
	private $idPais;
	private $nombre;

	public function __construct($id,$isPais,$nombre)
	{

		$this->id = $id;
		$this->idPais=$idPais;
		$this->nombre = $nombre;
	}

	public function getId(){
		return $this->id;
	}
	public function getIdPais(){
		return $this->idPais;
	}
	public function getNombre(){
		return $this->nombre;
	}


	public function setId($id){
		$this->id=$id;
	}

	public function setIdPais($idPais){
		$this->idPais=$idPais;
	}
	public function setNombre($nombre){
		$this->nombre=$nombre;
	}
	/*
	$sql=DB::conexion()->prepare("SELECT * FROM pais");
		$sql->execute();
		$resultado = $sql->get_result();
		while ($fila=$resultado->fetch_array()){
			$rows[] = $fila;
		}
		return $rows;
		*/

	public function listarCiudad($pais){
		$sql=DB::conexion()->prepare("SELECT * FROM ciudad where idPais=?");
		$sql->bind_param("i",$pais);
		$sql->execute();
		$resultado = $sql->get_result();
		while ($fila=$resultado->fetch_array()){
			$rows[] = $fila;
		}
		return $rows;
	}

	public static function obtenerCiudad($id){
		$consulta = DB::conexion()->prepare('SELECT * FROM ciudad WHERE id=? ');
		$consulta->bind_param('i',$id);	
		$consulta->execute();
		$resultado = $consulta->get_result();
		if(!$resultado){
			return "";
		}
		for ($num_fila = $resultado->num_rows - 1; $num_fila >= 0; $num_fila--) {
			$resultado->data_seek($num_fila);
			$fila = $resultado->fetch_assoc();
		}

		return $fila['nombre'];

	}
} ?>