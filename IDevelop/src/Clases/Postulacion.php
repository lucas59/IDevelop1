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

	public function Despostularse_postulacion($usuario,$proyecto){
		$sql=DB::conexion()->prepare("DELETE FROM `postulacion` WHERE desarrollador_id = ? AND proyecto_id = ?");
		if($sql){
			$sql->bind_param('ss',$usuario,$proyecto);
			if ($sql->execute()) {

				return "1";
			}else{
				return "0";
			} 
		} 
	}
	
	public static function PostulantesDeProyecto($id){
		$postulantes=array();
		$sql=DB::conexion()->prepare("SELECT * FROM postulacion WHERE proyecto_id = ?");
		$sql->bind_param('i',$id);
		$sql->execute();
		$resultado=$sql->get_result();
		if($resultado->num_rows > 0){
			for ($num_fila = $resultado->num_rows - 1; $num_fila >= 0; $num_fila--) {
				$resultado->data_seek($num_fila);
				$fila = $resultado->fetch_assoc();

				$sql2=DB::conexion()->prepare("SELECT d.*,u.estado, fp.contenido FROM desarrollador as d,usuario as u, fotos_perfiles as fp WHERE u.email = ? AND u.email=d.id AND u.email=fp.nombre ");
				$sql2->bind_param('s',$fila['desarrollador_id']);
				$sql2->execute();
				$resultado2=$sql2->get_result();
				if($resultado2->num_rows > 0){
					for ($num_fila2 = $resultado2->num_rows - 1; $num_fila2 >= 0; $num_fila2--) {
						$resultado2->data_seek($num_fila2);
						$fila2 = $resultado2->fetch_assoc();
						if($fila2['estado'] == 1){
							$email = $fila2['id'];
							$cedula = $fila2['cedula'];			
							$desarrollo_preferido =$fila2['desarrolloPreferido'];
							$desarrollador = new Desarrollador($email,"","",$cedula,"","","","",$desarrollo_preferido,$experienca_laboral = array(), "", $herramientas = array(), $proyectos = array());
							array_push($postulantes,$desarrollador);
						}
					}
				}else{
					return false;
				}

			}
			return $postulantes;
		}else{
			return false;
		}
	}
}
?>