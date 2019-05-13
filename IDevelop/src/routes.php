<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {

	$routesUsus = require_once __DIR__ . "/../src/routes_usuarios.php";
	$routesProyectos = require_once __DIR__ . "/../src/routes_proyectos.php";
	$container = $app->getContainer();

	$routesUsus($app);
	$routesProyectos($app);

	$app->get('/',function($request,$response,$args){
        $sesion = null;
        if(isset($_SESSION['admin'])){
            $sesion=$_SESSION['admin']; 
        }
        
		return $this->view->render($response,"index.twig",compact('sesion'));
	})->setName("Inicio");

};
