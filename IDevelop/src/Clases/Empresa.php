<?php 
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
}
?>