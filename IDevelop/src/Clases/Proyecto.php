<?php 
class Proyecto 
{
	private $nombre;
	private $descripcion;
	private $fechaEntrega;
	private $fechaFinPostulacion;
	private $estado;
	private $valoracionPuntos; //total de puntos de todos los casos de usos
	private $avanceDesarrollo;
	private $postulacion;
	private $proponente;

	function __construct($nombre, $descripcion, $fechaEntrega,$fechaFinPostulacion, $estado,$avanceDesarrollo, $postulacion, $proponente)
	{
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->fechaEntrega = $fechaEntrega;
		$this->fechaFinPostulacion = $fechaFinPostulacion;
		$this->estado = $estado;
		$this->avanceDesarrollo = $avanceDesarrollo;
		$this->postulacion = $postulacion;
		$this->proponente = $proponente;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function getDescripcion(){
		return $this->descripcion;
	}

	public function getFechaentrega(){
		return $this->fechaEntrega;
	}

	public function getEstado(){
		return $this->estado;
	}

	public function getAvanceDesarrollo(){
		return $this->avanceDesarrollo;
	}

	public function getPostulacion(){
		return $this->postulacion;
	}

	public function getDesarrolladores(){
		return $this->desarrolladores;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}

	public function setFechaentrega($fechaEntrega){
		$this->fechaEntrega = $fechaEntrega;
	}

	public function setEstado($estado){
		array_push($this->estado = $estado);
	}

	public function setAvanceDesarrollo($avanceDesarrollo){
		$this->avanceDesarrollo = $avanceDesarrollo;
	}

	public function setPostulacion($postulacion){
		$this->postulacion = $postulacion;
	}

	public function setDesarrolladores($desarrolladores){
		array_push($this->desarrolladores, $descripcion);
	}


	public function subirProyecto(){

		$estado = new Estado('publicado', new date(),null);
		$sql=DB::conexion()->prepare("INSERT INTO `Proyecto` (`nombre`, `descripcion`, `fechaEntrega`, `fechaFinPostulacion`, `estado`) VALUES (?,?,?,?,?)");
		$sql->bind_param('ssisi',$this->nombre,$this->descripcion,$this->fechaEntrega,$this->fechaFinPostulacion,$estado);
		if ($sql->execute()) {
			return "1";
		}else{
			return "0";
		}  
	}
	
	public function validarNombreProyecto($nombre){
		$respuesta=null;
		$consulta = DB::conexion()->prepare("SELECT * FROM Proyecto WHERE nombre= ?");
		$consulta->bind_param('s',$nombre);		
		$consulta->execute();
		$resultado = $consulta->get_result();
		if (mysqli_num_rows($resultado) == 1) {
			$respuesta = "1";
		} else if($resultado->num_rows==0) {
			$respuesta = "0";
		}
		return $respuesta;
	}
	
	public function obtenerAvanceProyecto(){


	}

	public function Listar_proyectos(){
		$respuesta=null;
		$consulta = DB::conexion()->prepare("SELECT * FROM Proyecto");
		$consulta->execute();
		$resultado = $consulta->get_result();

		if (mysqli_num_rows($resultado) >= 1) {
			return $resultado;
		} else {
			return $resultado;
		}
	}

	public function Buscar_proyecto($id){
		$respuesta=null;
		$consulta = DB::conexion()->prepare("SELECT * FROM Proyecto WHERE id = " . $id);
		$consulta->execute();
		$resultado = $consulta->get_result();

		if (mysqli_num_rows($resultado) >= 1) {
			return $resultado;
		} else {
			return $resultado;
		}
	}

		
}
?>