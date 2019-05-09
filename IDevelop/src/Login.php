<?php
    require_once './conexion/abrir_conexion.php';
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
    $_SESSION['admin'] = $usuario_login;
    header('Location: ../public/');

}else{
    die();
}
