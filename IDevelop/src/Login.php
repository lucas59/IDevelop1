<?php
    require_once './conexion/abrir_conexion.php';
session_start();

$usuario_login = $_POST['Correo'];
$contrasena_login = $_POST['Contrasena'];

//VERIFICAR SI USUARIO EXISTE

$sql = "SELECT * FROM usuario WHERE email = ".'"'.$usuario_login.'"';
$conexion = new mysqli('localhost', 'root', '', 'idevelop') or die("No se puede conectar con el servidor");
$resultado = $conexion->query($sql);

if(!$resultado){
    header('Location: ../public/Usuario/login');
    die();
    
}
for ($num_fila = $resultado->num_rows - 1; $num_fila >= 0; $num_fila--) {
    $resultado->data_seek($num_fila);
    $fila = $resultado->fetch_assoc();
}
if( $contrasena_login == $fila['contrasenia'] ){
    //las contraseñas son iguales
    $_SESSION['admin'] = $usuario_login;
    header('Location: ../public/');

}else{
    echo 'No son iguales las contraseñas!';
    die();
}
