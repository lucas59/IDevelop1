<?php 
class Postulacion 
{
	private $id = '';
	private $fecha_postulacion = '';
	private $desarrollador = '';
	private $proyecto = '';

	function __construct($fecha_postulacion, $desarrollador, $proyecto)
	{
		$this->fecha_postulacion = $fecha_postulacion;
		$this->desarrollador = $desarrollador;
		$this->proyecto = $proyecto;
	}
	public function getID(){
		return $this->id;
	}

	public function getFechapostulacion(){
		return $this->fecha_postulacion;
	}

	public function getDesarrollador(){
		return $this->desarrollador;
	}

	public function getProyecto(){
		return $this->proyecto;
	}
	public function setID($id){
		$this->id = $id;
	}

	public function setFechapostulacion($fecha_postulacion){
		$this->fecha_postulacion = $fecha_postulacion;
	}

	public function setDesarrollador($desarrollador){
		$this->desarrollador = $desarrollador;
	}

	public function setProyecto($proyecto){
		$this->proyecto = $proyecto;
	}

	public function AltaPostulacion($usuario,$proyecto){
		$sql=DB::conexion()->prepare("INSERT INTO `postulacion` (`fechaPostulacion`, `desarrollador_id`, `proyecto_id`) VALUES (?,?,?)");
		if($sql){
			$date = date("Y-m-d H:i:s");
			$sql->bind_param('sss',$date,$usuario,$proyecto);
			if ($sql->execute()) {
				return "1";
			}else{
				return "0";
			} 
		} 
	}

	public function Buscar_postulacion($id,$correo){
		$respuesta=null;
		$consulta = DB::conexion()->prepare("SELECT * FROM postulacion WHERE desarrollador_id = '" . $correo . "' AND proyecto_id = '" . $id . "'");
		$consulta->execute();
		$resultado = $consulta->get_result();
		if (mysqli_num_rows($resultado) >= 1) {
			return $resultado->fetch_object()->id;
		} else {
			return false;
		}
	}

public function Despostularse_postulacion($usuario,$proyecto){
		$sql=DB::conexion()->prepare("UPDATE `desarrollador_proyecto` SET Estado = 0 WHERE Desarrollador_id = ? AND proyectos_id = ?");
		if($sql){
			$sql->bind_param('ss',$usuario,$proyecto);
			if ($sql->execute()) {
				return "1";
			}else{
				return "0";
			} 
		} 
	}
}
?>