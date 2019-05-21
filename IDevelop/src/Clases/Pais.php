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
	public static function obtenerPais($id){
		$consulta = DB::conexion()->prepare('SELECT * FROM pais WHERE id=? ');
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