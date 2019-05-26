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
	private $id;

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

	public function getId(){
		return $this->id;
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
	
	public function setId($id2){
		$this->id=$id2;
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


	public function subirProyecto($nombre, $descripcion, $fechaEntrega, $fechaFinPostulacion){


		/*
		fallo en la consulta sql revisando
		$sql=DB::conexion()->prepare("INSERT INTO proyecto(descripcion, fechaEntrega, fechaFinPostulacion, nombre, avance_id) VALUES (?,?,?,?)");
		$sql->bind_param('ssis',$descripcion,$fechaEntrega,$fechaFinPostulacion,$nombre);
		if ($sql->execute()) {
			return "1";
		}else{
			return "0";
		} */

		return "1"; 
	}
	
	public function validarNombreP($nombre){
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

	public function Listar_proyectos_postularse($id){
		$respuesta=null;
		$consulta = DB::conexion()->prepare("SELECT proyecto.*,empresa.nombre AS nombre_empresa ,empresa.id AS id_empresa FROM empresa_proyecto INNER JOIN proyecto ON proyecto.id = empresa_proyecto.proyectos_id INNER JOIN empresa ON empresa.id = empresa_proyecto.Empresa_id AND proyecto.id NOT IN (SELECT proyecto_id FROM postulacion WHERE postulacion.desarrollador_id = '" . $id . "')");
		$consulta->execute();
		$resultado = $consulta->get_result();
		if (mysqli_num_rows($resultado) >= 1) {
			return $resultado;
		} else {
			return $resultado;
		}
	}

		public function Listar_proyectos_despostularse($id){
		$respuesta=null;
		$consulta = DB::conexion()->prepare("SELECT proyecto.*,empresa.nombre AS nombre_empresa ,empresa.id AS id_empresa FROM empresa_proyecto INNER JOIN proyecto ON proyecto.id = empresa_proyecto.proyectos_id INNER JOIN empresa ON empresa.id = empresa_proyecto.Empresa_id AND proyecto.id IN (SELECT proyectos_id FROM desarrollador_proyecto WHERE desarrollador_proyecto.Desarrollador_id = '" . $id . "' AND desarrollador_proyecto.Estado IS NULL)");
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
			return $resultado->fetch_object()->nombre;
		} else {
			return false;
		}
	}


}
?>