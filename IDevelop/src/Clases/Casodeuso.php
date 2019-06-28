<?php 
require_once '../src/Clases/console.php';

class Casodeuso 
{
	private $nombre;
	private $descripcion;
	private $puntosActuales; // traduccion de tiempo en puntos de realizar el caso de uso
	private $puntosTot;
	private $proyecto_id;


	function __construct($nombre, $descripcion, $puntosTot)
	{
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->puntosTot = $puntosTot;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function getDescripcion(){
		return $this->descripcion;
	}

	public function getPuntosTot(){
		return $this->puntosTot;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}

	public function setPuntosTot($puntos){
		$this->puntosTot = $puntos;
	}

	public function validarNombreCU($nombre, $proyecto){
		$respuesta = null;
		$consulta = DB::conexion()->prepare("SELECT * FROM casodeuso WHERE nombre = ? AND proyecto_id = ?");
		$consulta->bind_param('si',$nombre, $proyecto);
		$consulta->execute();
		$respuesta = $consulta->get_result();
		if(mysqli_num_rows($respuesta) ==1){
			$respuesta ="1";
		}else {
			$respuesta = "0";
		}
		return $respuesta;
	}

	public function ExistePlanificacion($id){
		$respuesta = null;
		$consulta = DB::conexion()->prepare("SELECT * FROM casodeuso WHERE proyecto_id =");
		$consulta->bind_param('i',$id);
		$consulta->execute();
		$respuesta = $consulta->get_result();
		if(mysql_num_rows($respuesta) < 1){
			$respuesta = "1";
		}else{
			$respuesta = "0";
		}
		return $respuesta;
	}

	public function subirCasoDeUso($nombre, $descripcion, $impacto,$proy){
		$puntosA = "0";
		$sql=DB::conexion()->prepare("INSERT INTO casodeuso ( descripcion, nombre, puntosActuales, puntosTot, proyecto_id) VALUES (?,?,?,?,?)");
		$sql->bind_param('ssiii',$descripcion,$nombre,$puntosA,$impacto,$proy);
		$respuesta = null;
		if ($sql->execute()) {
			$respuesta = "1";
		}else{
			$respuesta = "0";
		} 
		return $respuesta;
	}

	public function actualizarCasoDeUso($id, $progreso, $nombre){
		$sql= DB::conexion()->prepare("UPDATE casodeuso SET puntosActuales=? WHERE proyecto_id = ? AND nombre = ?");
		$sql->bind_param('iis', $progreso, $id, $nombre);
		
		$respuesta = null;
		
		if($sql->execute()){
			$respuesta = "1";
		} else {
			$respuesta = "0";
		}	
		return $respuesta;
	}

	public function listacasodeuso($idProyecto){
		$sql=DB::conexion()->prepare("SELECT * FROM casodeuso WHERE proyecto_id = ?");
		$sql->bind_param('i',$idProyecto);
		$sql->execute();
		return $sql->get_result();
	}

	public function calcularProgresoTotalProyecto($idProyecto){

		$consulta = DB::conexion()->prepare('SELECT puntosTot FROM casodeuso WHERE proyecto_id = ?');
		$consulta->bind_param('i', $idProyecto);
		$consulta->execute();
		$resultado = $consulta->get_result();
		$puntosTotales = 0;
		$progresoTotal = 0;
		
		while($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
			$progresoTotal = $progresoTotal + $row['puntosTot'];
		}
		
		return $progresoTotal;
	}

	public function calcularPuntosTotalesProyecto($idProyecto){

		$consulta = DB::conexion()->prepare('SELECT puntosActuales FROM casodeuso WHERE proyecto_id = ?');
		$consulta->bind_param('i', $idProyecto);
		$consulta->execute();
		$resultado = $consulta->get_result();
		$puntosTotales = 0;
		while($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
			$puntosTotales = $puntosTotales + $row['puntosTot'];
		}

		return $puntosTotales;
	}
}
 ?>