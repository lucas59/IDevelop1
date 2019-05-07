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

	public function registrase(){
		
		$sql=DB::$conexion()->prepare("INSERT INTO `empresa` (`direccion`, `fechaCreacion`, `mision`, `nombre`, `reclutador`, `rubro`, `telefono`, `vision`, `id`) VALUES (?,?,?,?,?,?,?,?,?");
		$sql->bind_param('sssssssss',$this->direccion,$this->fechaCreacion,$this->mision,$this->nombre,$this->reclutador,$this->rubro,$this->telefono,$this->vision,$this->email);
		return $sql->execute();
	}
}
?>