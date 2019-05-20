<?php 
require_once 'Usuario.php';
require_once 'Experiencia_laboral.php';
require_once 'Herramienta.php';
require_once 'Proyecto.php';
class Desarrollador extends Usuario 
{
	private $cedula;
	private $apellido;
	private $fecha_Nacimiento;
	private $pais;
	private $ciudad_actual;
	private $desarrollo_preferido;
	private $experienca_laboral = array();
	private $postulacion;
	private $herramientas = array();
	private $proyectos = array();

	function __construct($email,$foto_perfil,$contrasena,$cedula,$apellido,$fecha_Nacimiento,$pais,$ciudad_actual,$desarrollo_preferido,$experienca_laboral = array(), $postulacion, $herramientas = array(), $proyectos = array())
	{
		$this->email = $email;
		$this->foto_perfil = $foto_perfil;
		$this->contrasena = $contrasena;

		$this->cedula = $cedula;
		$this->apellido = $apellido;
		$this->fecha_Nacimiento = $fecha_Nacimiento;
		$this->pais = $pais;
		$this->ciudad_actual = $ciudad_actual;
		$this->desarrollo_preferido = $desarrollo_preferido;
		$this->experienca_laboral = $experienca_laboral;
		$this->postulacion = $postulacion;
		$this->herramientas = $herramientas;
		$this->proyectos = $proyectos;
	}

	public function getCedula(){
		return $this->cedula;
	}

	public function getApellido(){
		return $this->apellido;
	}

	public function getFecha_Nacimiento(){
		return $this->fecha_Nacimiento;
	}

	public function getPais(){
		return $this->pais;
	}

	public function getCiudad_actual(){
		return $this->ciudad_actual;
	}

	public function getDesarrollo_preferido(){
		return $this->desarrollo_preferido;
	}

	public function getExperienciaLaboral(){
		return $this->experienca_laboral;
	}
	
	public function getPostulacion(){
		return $this->postulacion;
	}

	public function getHerramientas(){
		return $this->herramientas;
	}

	public function getProyectos(){
		return $this->proyectos;
	}

	public function setCedula($cedula){
		$this->cedula = $cedula;
	}

	public function setApellido($apellido){
		$this->apellido = $apellido;
	}

	public function setFecha_nacimiento($fecha_Nacimiento){
		$this->fecha_Nacimiento = $fecha_Nacimiento;
	}

	public function setPais($pais){
		$this->pais = $pais;
	}

	public function setCiudad_actual($ciudad_actual){
		$this->ciudad_actual = $ciudad_actual;
	}

	public function setDesarrollo_preferido($desarrollo_preferido){
		$this->desarrollo_preferido = $desarrollo_preferido;
	}

	public function setExperienciaLaboral($experienca_laboral){
		array_push($this->experienca_laboral, $experienca_laboral);
	}

	public function setPostulacion($postulacion){
		$this->postulacion = $postulacion;
	}

	public function setHerramientas($herramientas){
		array_push($this->herramientas, $herramientas);
	}

	public function setProyectos($proyectos){
		array_push($this->proyectos, $proyectos);
	}
	
	public function registrarDesarrollador($nombre,$apellido,$email,$fecha){
		$cedula=null;
		$ciudad=null;
		$desarrolloPreferido=null;
		$pais=null;
		
		$sql=DB::conexion()->prepare("INSERT INTO `desarrollador` (`apellido`, `cedula`, `ciudad_id`, `desarrolloPreferido`, `fechaNacimiento`, `nombre`, `pais_id`, `id`) VALUES (?,?,?,?,?,?,?,?)");
		$sql->bind_param('ssisssis',$apellido,$cedula,$ciudad,$desarrolloPreferido,$fecha,$nombre,$pais,$email);
		if($sql->execute()){
			return "1";
		}else{
			return "0";
		}
	}

	public function obtenerDesarrollador($email){
		$sql = DB::conexion()->prepare("SELECT D.* , U.tipo FROM desarrollador AS D, usuario AS U WHERE D.id = ? AND D.id=U.email");
		$sql->bind_param('s',$email);
		$sql->execute();
		$resultado=$sql->get_result();
		return $resultado->fetch_object();
	}

	public function actualizarAltaUser($email,$idPais,$idCiudad,$lenguajes,$idCurriculum){
		$sql=DB::conexion()->prepare("UPDATE `desarrollador` SET `pais_id` = ?, `ciudad_id` = ?,`desarrolloPreferido`=?,`curriculum_id`=? WHERE `desarrollador`.`id` = ? ");
		$sql->bind_param('iisis',$idPais,$idCiudad,$lenguajes,$idCurriculum,$email);
		if ($sql->execute()){
			return true;
		} else{
			return false;
		}	
	}

	public static function perfil($email){
		$sql=DB::conexion()->prepare("SELECT * FROM desarrollador WHERE id= ?");
		$sql->bind_param('s',$email);
		$sql->execute();
		$resultado=$sql->get_result();
		if(!$resultado){
			return null;
		}
		for ($num_fila = $resultado->num_rows - 1; $num_fila >= 0; $num_fila--) {
			$resultado->data_seek($num_fila);
			$fila = $resultado->fetch_assoc();
		}
		$controlador =new ctr_usuarios();
		$apellido=$fila['apellido'];
		$cedula=$fila['cedula'];
		$ciudad =$controlador->obtenerCiudad($fila['ciudad_id']);
		$fecha_Nacimiento=$fila['fechaNacimiento'];
		$desarrolloPreferido=$fila['desarrolloPreferido'];
		$nombre=$fila['nombre'];
		$pais ="";
		$pais=$controlador->obtenerPais($fila['pais_id']);

		$sql2=DB::conexion()->prepare("SELECT * FROM usuario WHERE email= ?");
		$sql2->bind_param('s',$email);
		$sql2->execute();
		$resultado2=$sql2->get_result();
		for ($num_fila = $resultado2->num_rows - 1; $num_fila >= 0; $num_fila--) {
			$resultado2->data_seek($num_fila);
			$fila2 = $resultado2->fetch_assoc();
		}
		$foto=$fila2['foto'];
		$desarrollador =$desarrollador = new Desarrollador($email,$foto,"",$cedula,$apellido,$fecha_Nacimiento,$pais,$ciudad,$desarrolloPreferido,$experienca_laboral = array(), "", $herramientas = array(), $proyectos = array());
		return $desarrollador;
	}

	public static function ObtenerExperiencia($email){
		$experiencia = array();
		$sql=DB::conexion()->prepare("SELECT * FROM desarrollador_experiencialaboral WHERE Desarrollador_id = ?");
		$sql->bind_param('s',$email);
		$sql->execute();
		$resultado=$sql->get_result();
		if(!$resultado){
			return $experiencia;
		}
		for ($num_fila = $resultado->num_rows - 1; $num_fila >= 0; $num_fila--) {
			$resultado->data_seek($num_fila);
			$fila = $resultado->fetch_assoc();

			$expid = $fila['experiencias_id'];
			$sql2=DB::conexion()->prepare("SELECT * FROM experiencialaboral WHERE id = ?");
		$sql2->bind_param('i',$expid);
		$sql2->execute();
		$resultado2=$sql2->get_result();

		for ($num_fila = $resultado2->num_rows - 1; $num_fila >= 0; $num_fila--) {
			$resultado2->data_seek($num_fila);
			$fila2 = $resultado2->fetch_assoc();
		}

$empresa=$fila2['empresa'];
$fechaini=$fila2['fechaInicio'];
$fechafin=$fila2['fechaFin'];
$descripcion=$fila2['descripcion'];
$contacto=$fila2['contacto'];
		$exp = new Experiencia_laboral($empresa, $descripcion, $fechaini, $fechafin, $contacto);
		array_push($experiencia,$exp);
	}
	return $experiencia;
}

public static function ObtenerHerramientas($email){
$herramientas = array();
$sql=DB::conexion()->prepare("SELECT * FROM desarrollador_herramienta WHERE Desarrollador_id = ?");
$sql->bind_param('s',$email);
$sql->execute();
$resultado=$sql->get_result();
if(!$resultado){
	return $herramientas;
}
for ($num_fila = $resultado->num_rows - 1; $num_fila >= 0; $num_fila--) {
	$resultado->data_seek($num_fila);
	$fila = $resultado->fetch_assoc();

	$herid = $fila['herramientas_id'];
	$sql2=DB::conexion()->prepare("SELECT * FROM herramienta WHERE id = ?");
	$sql2->bind_param('i',$herid);
	$sql2->execute();
	$resultado2=$sql2->get_result();
	
for ($num_fila = $resultado2->num_rows - 1; $num_fila >= 0; $num_fila--) {
	$resultado2->data_seek($num_fila);
	$fila2 = $resultado2->fetch_assoc();
}

$nombre=$fila2['nombre'];

$her = new Herramienta($nombre);
array_push($herramientas,$her);
}
return $herramientas;
}

public static function ObtenerProyectos($email){
	$proyectos = array();
$sql=DB::conexion()->prepare("SELECT * FROM desarrollador_proyecto WHERE Desarrollador_id = ?");
$sql->bind_param('s',$email);
$sql->execute();
$resultado=$sql->get_result();
if(!$resultado){
	return $herramientas;
}
for ($num_fila = $resultado->num_rows - 1; $num_fila >= 0; $num_fila--) {
	$resultado->data_seek($num_fila);
	$fila = $resultado->fetch_assoc();

	$proyid = $fila['proyectos_id'];
	$sql2=DB::conexion()->prepare("SELECT * FROM proyecto WHERE id = ?");
	$sql2->bind_param('i',$proyid);
	$sql2->execute();
	$resultado2=$sql2->get_result();
	
for ($num_fila = $resultado2->num_rows - 1; $num_fila >= 0; $num_fila--) {
	$resultado2->data_seek($num_fila);
	$fila2 = $resultado2->fetch_assoc();
}

$nombre=$fila2['nombre'];
$descripcion=$fila2['descripcion'];
$fechaEntrega=$fila2['fechaEntrega'];


$proy = new Proyecto($nombre, $descripcion, $fechaEntrega,"","","", "", "");
array_push($proyectos,$proy);
}
return $proyectos;
}

}
?>