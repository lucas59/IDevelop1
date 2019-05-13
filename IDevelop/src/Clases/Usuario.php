<?php 
if(class_exists("Usuario"))
	return;

class Usuario 
{
	private $email;
	private $foto_perfil;
	private $contrasenia ;
	private $validaciones = array();
	function __construct($email,$foto_perfil,$contrasenia, $validaciones)
	{
		$this->email = $email;
		$this->foto_perfil = $foto_perfil;
		$this->contrasenia = $contrasenia;
		$this->validaciones = $validaciones;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getFoto_perfil(){
		return $this->foto_perfil;
	}

	public function getContrasenia(){
		return $this->contrasena;
	}

	public function getValidaciones(){
		return $this->validaciones;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function setFoto_perfil($foto_perfil){
		$this->foto_perfil = $foto_perfil;
	}

	public function setContrasenia($contrasena){
		$this->contrasena = $contrasena;
	}

	public function setValidaciones($validaciones){
		array_push($this->validaciones, $validaciones);
	}

	public function verificarExistencia($email){
		$retorno=null;
		$consulta = DB::conexion()->prepare("SELECT * FROM usuario WHERE email= ?");
		$consulta->bind_param('s',$email);		
		$consulta->execute();
		$resultado = $consulta->get_result();
		if (mysqli_num_rows($resultado) == 1) {
			$retorno = "1";
		} else if($resultado->num_rows==0) {
			$retorno = "0";
		}
		return $retorno;
	}


	public function registrarUsuario($email,$foto,$contrasenia){	
		$sql=DB::conexion()->prepare("INSERT INTO `usuario` (`email`, `contrasenia`, `foto`) VALUES (?,?,?)");
		$sql->bind_param('sss',$email,$contrasenia,$foto);
		if ($sql->execute()) {
			return "1";
		}else{
			return "0";
		} 
	}

public function Login($email,$pass){
		 
	$consulta = DB::conexion()->prepare('SELECT * FROM usuario WHERE email= ?');
	$consulta->bind_param('s',$email);		
	$consulta->execute();
	$resultado = $consulta->get_result();
	if(!$resultado){
		return "0";	
	}
	
	for ($num_fila = $resultado->num_rows - 1; $num_fila >= 0; $num_fila--) {
		$resultado->data_seek($num_fila);
		$fila = $resultado->fetch_assoc();
	}
	$contaseñaencriptada = $fila['contrasenia'];
	
	if( sha1($pass) == $contaseñaencriptada){
		
		//las contraseñas son iguales
		$consulta2 = DB::conexion()->prepare('SELECT * FROM desarrollador WHERE id= ?');
		$consulta2->bind_param('s',$email);		
		$consulta2->execute();
		$resultado2 = $consulta2->get_result();
		if($resultado2){
		for ($num_fila2 = $resultado2->num_rows - 1; $num_fila2 >= 0; $num_fila2--) {
			$resultado2->data_seek($num_fila2);
			$fila2 = $resultado2->fetch_assoc();
		}
		
		$email = $fila2['id'];
		$foto = $fila['foto'];
		$cedula = $fila2['cedula'];
		$apellido =  $fila2['apellido'];
		$fecha_Nacimiento =$fila2['fechaNacimiento'];
		$pais =$fila2['pais'];
		$ciudad_actual =$fila2['ciudad'];
		$desarrollo_preferido =$fila2['desarrolloPreferido'];
		$desarrollador = new Desarrollador($email,$foto,"",$cedula,$apellido,$fecha_Nacimiento,$pais,$ciudad_actual,$desarrollo_preferido,$experienca_laboral = array(), "", $herramientas = array(), $proyectos = array());	
		$_SESSION['admin'] = $desarrollador;
		return "1";
	
	}else{
		$consulta3 = DB::conexion()->prepare('SELECT * FROM empreza WHERE id= ?');
		$consulta3->bind_param('s',$email);		
		$consulta3->execute();
		$resultado3 = $consulta3->get_result();
	   
		if($resultado2){
	
		for ($num_fila3 = $resultado3->num_rows - 1; $num_fila3 >= 0; $num_fila3--) {
			$resultado3->data_seek($num_fila3);
			$fila3 = $resultado3->fetch_assoc();
		}
		
		$email = $fila3['id'];
		$foto_perfil = $fila['foto'];
		$cedula = $fila3['cedula'];
		$nombre =  $fila3['nombre'];
		$fecha_Creacion =$fila3['fechaCreacion'];
		$direccion  =$fila3['direccion'];
		$telefono =$fila3['telefono'];
		$reclutador =$fila3['reclutador'];
		$vision =$fila3['vision'];
		$mision =$fila3['mision'];
		$rubro =$fila3['rubro'];
		$empreza = new Empreza($email,$foto_perfil,"", $validaciones = array(),$nombre,$fecha_Creacion,$direccion,$telefono,$reclutador,$rubro,$mision,$vision,"");
		$_SESSION['admin'] = $empreza;
		return "1";
	}else{
		return "0";
	}
	}
 }else{
	 return "0";
 }
}
}
?>