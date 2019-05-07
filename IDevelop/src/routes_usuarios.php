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
		//return $email;
		$retorno = $controladorUsuarios->validarEmail($email);
		return $retorno;	
	});
}


?>