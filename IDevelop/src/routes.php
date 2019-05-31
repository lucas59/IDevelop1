<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {

	$routesUsus = require_once __DIR__ . "/../src/routes_usuarios.php";
	$routesProyectos = require_once __DIR__ . "/../src/routes_proyectos.php";
	require_once 'controladores/ctr_usuarios.php';
	$container = $app->getContainer();

	$routesUsus($app);
	$routesProyectos($app);

	$app->get('/',function($request,$response,$args){
		if(isset($_SESSION['admin'])){
			if($_SESSION['admin']->tipo == 0){
			$args["session"]=$_SESSION['admin']; 
		}else if($_SESSION['admin']->tipo == 1){
			$args["sesion"]=$_SESSION['admin']; 
		}
	}
		return $this->view->render($response,"index.twig",$args);
	})->setName("Inicio");

};
