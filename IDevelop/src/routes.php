<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {

	$routesUsus = require_once __DIR__ . "/../src/routes_usuarios.php";
	$routesProyectos = require_once __DIR__ . "/../src/routes_proyectos.php";
	require_once 'controladores/ctr_usuarios.php';
	require_once '../src/Clases/console.php';
	$container = $app->getContainer();

	$routesUsus($app);
	$routesProyectos($app);

	$app->get('/',function($request,$response,$args){
		if(isset($_SESSION['admin'])){
			$session = $_SESSION['admin'];

			if ($session->tipo == 1 ) {
				$proyectos = ctr_proyecto::ListarProyectosDeDesarrolladores($session->id);
				$args['proy']=$proyectos;
			}else{
				$postulaciones = ctr_proyecto::ListarProyectosPostulados($session->id);	
				$args['postulaciones']=$postulaciones;

				$asignados = ctr_proyecto::ListarProyectosEnDesarrollo($session->id);
				$args['proy']=$asignados;

				$finalizados = ctr_proyecto::ListarProyectosFinalizados($session->id);
				$args['finalizados']=$finalizados;




			}

			$args["session"]=$_SESSION['admin']; 
	}
		return $this->view->render($response,"index.twig",$args);
	})->setName("Inicio");

};
