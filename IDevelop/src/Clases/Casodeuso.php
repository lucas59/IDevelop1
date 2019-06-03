<?php 
class Casodeuso 
{
	private $nombre;
	private $descripcion;
	private $puntosTot; // traduccion de tiempo en puntos de realizar el caso de uso
	
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

	public function validarNombreCU($nombre){
		$respuesta = null;
		$consulta = DB::conexion()->prepare("SELECT * FROM casodeuso WHERE nombre =");
		$consulta->bind_param('s',$nombre);
		$consulta->execute();
		$respuesta = $consulta->get_result();
		if(mysqli_num_rows($respuesta) ==1){
			$respuesta ="1";
		}else {
			$respuesta = "0";
		}
		return $respuesta;
	}

	public function subirCasoDeUso($nombre, $descripcion, $impacto){

		$sql=DB::conexion()->prepare("INSERT INTO (descripcion, fechaEntrega, fechaFinPostulacion, nombre, avance_id, estado) VALUES (?,?,?,?,?,?)");
		$sql->bind_param('ssssii',$descripcion,$fechaEntrega,$fechaFinPostulacion,$nombre,$avance,$estado);
		if ($sql->execute()) {
			$proy = Proyecto::obtenerProyecto2($nombre);
			$sql2 =DB::conexion()->prepare("INSERT INTO empresa_proyecto(Empresa_id, proyectos_id) VALUES (?,?)");			
			$sql2->bind_param('si',$usuario,$proy->id);
			if($sql2->execute()){
				return "1";
			}
		}else{
			return "0";
		} 

	}
}
 ?>