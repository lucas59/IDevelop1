<?php /**
 * 
 */
class curriculum {
	private $id;
	private $datos;
	private $extension;

	function __construct($id,$datos,$extension)
	{
		$this->datos=$datos;
		$this->id=$id;
		$this->extension;
	}

	public function subirCurriculum($curriculum,$email){

		$curriculum=json_decode($curriculum);
		$sql = DB::conexion()->prepare("INSERT INTO `curriculum` (`id`, `datos`, `extension`, `nombreCurriculum`) VALUES (NULL, ?, ?,?)");
		$sql->bind_param('sss',$curriculum->base64,$curriculum->extension,$email);
		if ($sql->execute()) {
			return true;
		} else{
			return false;
		}
	}

	public function obtenerIDCurriculo($nombreC){
		$sql = DB::conexion()->prepare("SELECT * FROM curriculum WHERE nombreCurriculum = ? ");
		$sql->bind_param("s",$nombreC);
		$sql->execute();
		$resultado = $sql->get_result();
		$curriculum=$resultado->fetch_object();
		return $curriculum->id;
	}


	public function obtenerCurriculo($nombreC){
		$sql = DB::conexion()->prepare("SELECT * FROM curriculum WHERE nombreCurriculum = ?");
		$sql->bind_param("s",$nombreC);
		$sql->execute();
		$resultado = $sql->get_result();
		$curriculum=$resultado->fetch_object();
		return $curriculum;
	}


} ?>