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

        // Render index view
        //return $container->get('renderer')->render($response, 'index.phtml', $args);

    $app->get('/ticket/{id}', function (Request $request, Response $response, $args) use ($container) {
       $ticket_id = (int)$args['id'];

       $container->get('logger')->info("/tieckt/id",array($args));
       $response->getBody()->write(json_encode(['ticket' => $ticket_id,'mensaje'=>"el id es"]));
       return $response;
   });

   $app->post('/ticket/', function (Request $request, Response $response, $args) use ($container) {
       $params=$request->getParams();
       $ticket_id = (int)$params['id'];

       $container->get('logger')->info("/tieckt/id",array($args));
       $response->getBody()->write(json_encode(['ticket' => $ticket_id,'mensaje'=>"el id es"]));
       return $response;
   });
};
