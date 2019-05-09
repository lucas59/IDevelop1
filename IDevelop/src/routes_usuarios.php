<?php 

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require_once 'controladores/ctr_usuarios.php';


return function (App $app){
	$container = $app->getContainer(); 
	$app->get('/Usuario/nuevo',function($request,$response,$args) use ($container){
		return $this->view->render($response,"altaUser.twig");
	})->setName("NuevoUsuario");

	$app->get('/Usuario/login',function($request,$response,$args) use ($container){
		return $this->view->render($response,"login.twig");
	})->setName("ingresar");

	$app->get('/Usuario/validarCorreo/{email}',function($request,$response,$args){
		$controladorUsuarios = new ctr_usuarios();
		$email = $args['email'];
		$retorno = $controladorUsuarios->validarEmail($email);
		return $retorno;
	});

	$app->get('/Usuario/validar/{token}',function($request,$response,$args){
		$controladorUsuarios = new ctr_usuarios();
		$token = $args['token'];
		$validar = $controladorUsuarios->validarCuenta($token);
		if($validar){
			return $this->view->render($response,"login.twig");	
		}else{
			return $this->view->render($response,"index.twig");

		}
	});
	$app->post('/Usuario/NuevoUsuario',function(Request $request, Response $response){
		$data = $request->getParams();
		$email=$data['email'];
		$nombre=$data['nombre'];
		$apellido=$data['apellido'];
		$pass=$data['contraseña'];
		$fecha=$data['fecha'];
		$sexo=$data['sexo'];
		$tipo=$data['tipo'];
		$token=$data['token'];
		ob_clean();
		$retorno = ctr_usuarios::ingresarUsuario($email,$nombre,$apellido,$pass,$fecha,$sexo,$tipo,$token);
		$hijo = ctr_usuarios::ingresarUsuHijo($email,$nombre,$apellido,$fecha,$tipo);
		ob_clean();
		return $hijo;
	});

	$app->post('/Usuario/Validacion/Enviar',function(Request $request, Response $response){
		$data = $request->getParams();
		$email=$data['email'];
		$nombre=$data['nombre'];
		$apellido=$data['apellido'];
		$token=$data['token'];
		
		$controladorUsuarios = new ctr_usuarios();
		$retorno = $controladorUsuarios->enviarValidacion($email,$nombre,$apellido,$token);
		return $retorno;
	});	
}
?>