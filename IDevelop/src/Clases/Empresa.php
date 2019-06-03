<?php 
require_once 'Usuario.php';
class Empresa extends Usuario 
{
	private $nombre = '';
	private $fecha_Creacion = '';
	private $direccion = '';
	private $telefono = '';
	private $reclutador = '';
	private $rubro = '';
	private $mision = '';
	private $vision = '';
	private $proyectos = array();

	function __construct($email,$foto_perfil,$contrasena, $validaciones = array(),$nombre,$fecha_Creacion,$direccion,$telefono,$reclutador,$rubro,$mision,$vision, $proyectos)
	{
		$this->email = $email;
		$this->foto_perfil = $foto_perfil;
		$this->contrasena = $contrasena;
		$this->validaciones = $validaciones;

		$this->nombre = $nombre;
		$this->fecha_Creacion = $fecha_Creacion;
		$this->direccion = $direccion;
		$this->telefono = $telefono;
		$this->reclutador = $reclutador;
		$this->rubro = $rubro;
		$this->mision = $mision;
		$this->vision = $vision;
		$this->proyectos = $proyectos;

	}

	public function getNombre(){
		return $this->nombre;
	}

	public function getFecha_Creacion(){
		return $this->fecha_Creacion;
	}

	public function getDireccion(){
		return $this->direccion;
	}

	public function getTelefono(){
		return $this->telefono;
	}

	public function getReclutador(){
		return $this->reclutador;
	}

	public function getRubro(){
		return $this->rubro;
	}

	public function getMision(){
		return $this->mision;
	}

	public function getVision(){
		return $this->vision;
	}

	public function getProyecto(){
		return $this->proyecto;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function setFecha_creacion($fecha_Creacion){
		$this->fecha_Creacion = $fecha_Creacion;
	}

	public function setDireccion($direccion){
		$this->direccion = $direccion;
	}

	public function setTelefono($telefono){
		$this->telefono = $telefono;
	}

	public function setReclutador($reclutador){
		$this->reclutador=$reclutador;
	}

	public function setProyecto($proyecto){
		array_push($this->proyecto, $proyecto);
	}

	public function registrarEmpresa($nombre,$fecha,$email){
		$direccion=null;
		$mision=null;
		$reclutador=null;
		$rubro=null;
		$telefono=null;
		$vision=null;
		$sql=DB::conexion()->prepare("INSERT INTO `empresa` (`direccion`, `fechaCreacion`, `mision`, `nombre`, `reclutador`, `rubro`, `telefono`, `vision`, `id`) VALUES (?,?,?,?,?,?,?,?,?)");
		$sql->bind_param('sssssssss',$direccion,$fecha,$mision,$nombre,$reclutador,$rubro,$telefono,$vision,$email);
		if($sql->execute()){
			return "1";
		}else{
			return "0";
		}
	}

	public function actualizarAltaUser($pais,$ciudad,$email,$vision,$mision,$tel,$rubro,$reclutador,$direccion){
		$sql=DB::conexion()->prepare("UPDATE `empresa` SET `direccion` = ?, `mision` = ?, `reclutador` = ?, `rubro` = ?, `telefono` = ?, `vision` = ?,`pais_id` = ?, `ciudad_id` = ? WHERE `empresa`.`id` = ?");
		$sql->bind_param('ssssssiis',$direccion,$mision,$reclutador,$rubro,$tel,$vision,$pais,$ciudad,$email);
		if ($sql->execute()){
			return true;
		} else{
			return false;
		}	
	}

	public function obtenerEmpresa($email){
		$sql = DB::conexion()->prepare("SELECT E.*, U.tipo FROM empresa AS E , usuario AS U WHERE U.email = ? AND E.id=U.email");
		$sql->bind_param('s',$email);
		$sql->execute();
		$resultado=$sql->get_result();
		return $resultado->fetch_object();
	}

	public static function listarempresas(){
		$Empresas = array();
		$sql2 = DB::conexion()->prepare("SELECT * FROM usuario");
		$sql2->execute();
		$resultado2=$sql2->get_result();
		if(!$resultado2->num_rows > 0){
			return false;	
		}
		for ($num_fila2 = $resultado2->num_rows - 1; $num_fila2 >= 0; $num_fila2--) {
			$resultado2->data_seek($num_fila2);
			$fila2 = $resultado2->fetch_assoc();
			if($fila2['estado'] == 1){

				$sql = DB::conexion()->prepare("SELECT * FROM empresa WHERE id= ?");
				$sql->bind_param('s',$fila2['email']);
				$sql->execute();
				$resultado=$sql->get_result();
				if($resultado->num_rows > 0){
					for ($num_fila = $resultado->num_rows - 1; $num_fila >= 0; $num_fila--) {
						$resultado->data_seek($num_fila);
						$fila = $resultado->fetch_assoc();
						
						$nombre = $fila['nombre'];
						$telefono = $fila['telefono'];
						$email = $fila['id'];
						$emp = new Empresa($email,"","","",$nombre,"","",$telefono,"","","","", "");
						array_push($Empresas,$emp);
					}
				}
			}
		}
		return $Empresas;
	}

	public static function perfilEmpresa($email){
		$sql = DB::conexion()->prepare("SELECT e.*,u.foto_id FROM empresa as e,usuario as u WHERE u.email = ? AND e.id= u.email");
		$sql->bind_param('s',$email);
		$sql->execute();
		$resultado=$sql->get_result();
		if(!$resultado->num_rows > 0){
			return false;	
		}
		//$controlador = new ctr_usuarios();
		for ($num_fila = $resultado->num_rows - 1; $num_fila >= 0; $num_fila--) {
			$resultado->data_seek($num_fila);
			$fila = $resultado->fetch_assoc();
		}
		$nombre = $fila['nombre'];
		$telefono = $fila['telefono'];
		$email = $fila['id'];
		$direccion =$fila['direccion'];
		$fecha_Creacion = $fila['fechaCreacion'];
		$mision = $fila['mision'];
		$reclutador = $fila['reclutador'];
		$rubro = $fila['rubro'];
		$vision = $fila['vision'];
		$foto_perfil = "";
		if(isset($fila['foto_id'])){
			$foto_perfil = $fila['foto_id'];
		}
		$empresa = new Empresa($email,$foto_perfil,"", $validaciones = array(),$nombre,$fecha_Creacion,$direccion,$telefono,$reclutador,$rubro,$mision,$vision, $proyectos=array());
		return $empresa;
	}

	public static function proyectosEmpresa($email){
		$proyectos = array();
		$sql = DB::conexion()->prepare("SELECT * FROM empresa_proyecto WHERE Empresa_id = ? ");
		$sql->bind_param('s',$email);
		$sql->execute();
		$resultado=$sql->get_result();
		if(!$resultado->num_rows > 0){
			return $proyectos;	
		}
		for ($num_fila = $resultado->num_rows - 1; $num_fila >= 0; $num_fila--) {
			$resultado->data_seek($num_fila);
			$fila = $resultado->fetch_assoc();
			
			$sql2 = DB::conexion()->prepare("SELECT * FROM proyecto WHERE id = ? ");
			$sql2->bind_param('s',$fila['proyectos_id']);
			$sql2->execute();
			$resultado2=$sql2->get_result();

			for ($num_fila = $resultado2->num_rows - 1; $num_fila >= 0; $num_fila--) {
				$resultado2->data_seek($num_fila);
				$fila2 = $resultado2->fetch_assoc();
			}
			$nombre = $fila2['nombre'];
			$descripcion = $fila2['descripcion'];
			$id = $fila2['id'];
			$proy = new Proyecto($nombre, $descripcion,"","","","","", "");
			$proy->setId($id);
			array_push($proyectos,$proy);
		}
		return $proyectos;
	}
}
?>