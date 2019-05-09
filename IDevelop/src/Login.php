<?php
    require_once './conexion/abrir_conexion.php';
    require_once './Clases/Desarrollador.php';
    require_once './Clases/Empresa.php';
    
session_start();

$usuario_login = $_POST['Correo'];
$contrasena_login = sha1($_POST['Contrasena']);

//VERIFICAR SI USUARIO EXISTE

$consulta = DB::conexion()->prepare('SELECT * FROM usuario WHERE email= ?');
$consulta->bind_param('s',$usuario_login);		
$consulta->execute();
$resultado = $consulta->get_result();
if(!$resultado){
    header('Location: ../public/Usuario/login');
    die();
    
}
for ($num_fila = $resultado->num_rows - 1; $num_fila >= 0; $num_fila--) {
    $resultado->data_seek($num_fila);
    $fila = $resultado->fetch_assoc();
}
$contaseñaencriptada = $fila['contrasenia'];

if( $contrasena_login == $contaseñaencriptada){
    //las contraseñas son iguales
    $consulta2 = DB::conexion()->prepare('SELECT * FROM desarrollador WHERE id= ?');
    $consulta2->bind_param('s',$usuario_login);		
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
    header('Location: ../public/');

}else{
    $consulta3 = DB::conexion()->prepare('SELECT * FROM empreza WHERE id= ?');
    $consulta3->bind_param('s',$usuario_login);		
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
    header('Location: ../public/');
}else{
    header('Location: ../public/Usuario/login');
    die();
}
}
}