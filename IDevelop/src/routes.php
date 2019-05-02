<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require "../src/routes_usuarios.php";
require "../src/routes_proyectos.php";


return function (App $app) {
    $container = $app->getContainer();

    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        //return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

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
