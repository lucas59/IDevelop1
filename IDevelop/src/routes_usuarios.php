<?php 

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app){
	$container = $app->getContainer();
	$app->get('/Usuario/nuevo',function($request,$response,$args) use ($container){
		return $this->view->render($response,"altaUser.twig");
	});
	$app->get('/Usuario/login',function($request,$response,$args) use ($container){
		return $this->view->render($response,"login.twig");
	});
}


?>