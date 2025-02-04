<?php 

require_once '../src/Clases/console.php';
require_once '../src/Clases/Usuario.php';

class Proyecto 
{
	private $nombre;
	private $descripcion;
	private $fechaEntrega;
	private $fechaFinPostulacion;
	private $estado;
	private $id;

	function __construct($nombre, $descripcion, $fechaEntrega,$fechaFinPostulacion, $estado)
	{
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->fechaEntrega = $fechaEntrega;
		$this->fechaFinPostulacion = $fechaFinPostulacion;
		$this->estado = $estado;
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


	public function subirProyecto($nombre, $descripcion, $fechaEntrega, $fechaFinPostulacion, $usuario){

		$estado= 0;
		$sql=DB::conexion()->prepare("INSERT INTO proyecto(descripcion, fechaEntrega, fechaFinPostulacion, nombre, estado) VALUES (?,?,?,?,?)");
		$sql->bind_param('ssssi',$descripcion,$fechaEntrega,$fechaFinPostulacion,$nombre,$estado);
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
	
	public function obtenerProyecto2($nombre){
		$respuesta=null;
		$consulta = DB::conexion()->prepare("SELECT * FROM Proyecto WHERE nombre= ?");
		$consulta->bind_param('s',$nombre);		
		$consulta->execute();
		$resultado=$consulta->get_result();
		return $resultado->fetch_object();
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
		$consulta = DB::conexion()->prepare("SELECT * FROM empresa_proyecto INNER JOIN proyecto ON proyecto.id = empresa_proyecto.proyectos_id INNER JOIN empresa ON empresa.id = empresa_proyecto.Empresa_id AND proyecto.id NOT IN (SELECT proyecto_id FROM postulacion WHERE postulacion.desarrollador_id = '" . $id . "')");
		$consulta->execute();
		$resultado = $consulta->get_result();
		if (mysqli_num_rows($resultado) >= 1) {
			return $resultado;
		} else {
			return $resultado;
		}
	}

public function ListarProyectosPostulados($id){
		$respuesta=null;
		$consulta = DB::conexion()->prepare("SELECT P.* FROM `proyecto` AS p, postulacion AS PN, usuario AS U WHERE U.email=? AND P.id = PN.proyecto_id AND P.estado = 0");
		$consulta->bind_param("s",$id);
		$consulta->execute();
		$resultado = $consulta->get_result();
		if (mysqli_num_rows($resultado) >= 1) {
			return $resultado;
		} else {
			return $resultado;
		}
	}
	public function ListarProyectosFinalizados($id){
		$respuesta=null;
		$consulta = DB::conexion()->prepare("SELECT P.* FROM `proyecto` AS p, postulacion AS PN, usuario AS U WHERE U.email=? AND P.id = PN.proyecto_id AND P.estado = 3");
		$consulta->bind_param("s",$id);
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

	public function obtenerProyectoCU($idproy){
		$respuesta = null;
		$sql = DB::conexion()->prepare("SELECT * FROM proyecto WHERE id = ?");
		$sql->bind_param('i',$idproy);
		$sql->execute();
		return $sql->get_result()->fetch_assoc();
	}

	public function ListarProyectosDeDesarrolladores($email){
		$sql=DB::conexion()->prepare("SELECT P.id, P.nombre,P.fechaEntrega,P.descripcion, P.estado FROM `proyecto` AS P, desarrollador_proyecto AS DP , desarrollador AS D WHERE D.id=DP.Desarrollador_id AND P.id=DP.proyectos_id AND D.id= ?");
		$sql->bind_param('s',$email);
		$sql->execute();
		$resultado = $sql->get_result();
		$myArray = array();

		while($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
			$myArray[] = $row;
		}
		return $myArray;
	}

	public function ListarProyectosEnDesarrollo($email){
		$sql=DB::conexion()->prepare("SELECT P.id, P.nombre,P.fechaEntrega,P.descripcion, P.estado FROM `proyecto` AS P, desarrollador_proyecto AS DP , desarrollador AS D WHERE D.id=DP.Desarrollador_id AND P.id=DP.proyectos_id AND P.estado = 2 AND D.id= ?");
		$sql->bind_param('s',$email);
		$sql->execute();
		$resultado = $sql->get_result();
		$myArray = array();

		while($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
			$myArray[] = $row;
		}
		return $myArray;
	}
	
	public function ListarProyectosDeEmpresa($email){
		$sql=DB::conexion()->prepare("SELECT P.id, P.nombre,P.fechaEntrega,P.descripcion, P.estado FROM `proyecto` AS P, empresa_proyecto AS EP , empresa AS EMP WHERE EMP.id=EP.Empresa_id AND P.id=EP.proyectos_id  AND EMP.id= ?");
		$sql->bind_param('s',$email);
		$sql->execute();
		$resultado = $sql->get_result();
		$myArray = array();

		while($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
			$myArray[] = $row;
		}
		return $myArray;
	}

	public function ListarProyectos(){
		$sql=DB::conexion()->prepare("SELECT * FROM `proyecto`");
		$sql->execute();
		$resultado = $sql->get_result();
		$myArray = array();

		while($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
			$myArray[] = $row;
		}
		return $myArray;

	}

	public function obtenerProyecto($idProyecto){
		$sql=DB::conexion()->prepare("SELECT P.*,D.Empresa_id FROM proyecto AS P ,empresa_proyecto AS D WHERE P.id=? AND D.proyectos_id = ?");
		$sql->bind_param("ss",$idProyecto,$idProyecto);
		$sql->execute();
		return $sql->get_result()->fetch_assoc();
	}
	


public function usuario_postualarse_validacion($id,$usuario){
		$respuesta=null;
		$consulta = DB::conexion()->prepare("SELECT * FROM proyecto WHERE proyecto.id IN (SELECT postulacion.proyecto_id FROM postulacion WHERE postulacion.desarrollador_id = '" . $usuario . "' AND postulacion.proyecto_id = '". $id ."')");
		$consulta->execute();
		$resultado = $consulta->get_result();
		if (mysqli_num_rows($resultado) == 0) {
			echo Console::log("ew","2");
			return "1";
		} else {
			return "0";
		}
	}
public function Activar_desactivar_proyecto($proyecto,$estado,$finPos,$finPro){
		$sql=DB::conexion()->prepare("UPDATE proyecto SET estado = ?,fechaEntrega = '$finPro',fechaFinPostulacion = '$finPos' WHERE id = ?");
		if($sql){
			$sql->bind_param('ii',$estado,$proyecto);
			if ($sql->execute()) {
				return "1";
			}else{
				return "0";
			} 
		} 
	}

public function Activar_desactivar_proyecto_des($proyecto,$estado){
		$sql=DB::conexion()->prepare("UPDATE proyecto SET estado = ? WHERE id = ?");
		if($sql){
			$sql->bind_param('ii',$estado,$proyecto);
			if ($sql->execute()) {
				return "1";
			}else{
				return "0";
			} 
		} 
	}
public function verificar_Trabajo_proyecto_validacion($id,$usuario){
		$respuesta=null;
		$consulta = DB::conexion()->prepare("SELECT * FROM proyecto WHERE proyecto.id IN (SELECT desarrollador_proyecto.proyectos_id FROM desarrollador_proyecto WHERE desarrollador_proyecto.proyectos_id = '". $id ."' AND desarrollador_proyecto.Desarrollador_id = '" . $usuario . "')");
		$consulta->execute();
		$resultado = $consulta->get_result();
		if (mysqli_num_rows($resultado) == 0) {
			echo Console::log("ew","2");
			return "1";
		} else {
			return "0";
		}
	}

	public static function verificarContratacion($idProyecto){
		$consulta = DB::conexion()->prepare('SELECT * FROM desarrollador_proyecto WHERE proyectos_id=? ');
		$consulta->bind_param('i',$idProyecto);		
		$consulta->execute();
		$resultado = $consulta->get_result();
		if($resultado->num_rows > 0){
			return true;	
		}else{
			return false;
		}
	}

}

?>