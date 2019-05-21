<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
	$url  = parse_url($_SERVER['REQUEST_URI']);
	$file = __DIR__ . $url['path'];
	if (is_file($file)) {
		return false;
	}
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
$dependencies = require __DIR__ . '/../src/dependencies.php';
$dependencies($app);

// Register middleware
$middleware = require __DIR__ . '/../src/middleware.php';
$middleware($app);

// Register routes
//$routes = require __DIR__ . '/../src/routes.php';
//$routes($app);

$container = $app->getContainer();

$container['view']= function($container){
	$view = new \Slim\Views\Twig('../templates',[
		'cache'=> false
	]);

	$view->addExtension(new \Slim\Views\TwigExtension(
		$container->router,
		$container->request->getUri()
	));
	$view->addExtension(new \Twig_Extension_Debug());
	return $view;

};

$routes = require_once __DIR__ . '/../src/routes.php';

$routes($app);

// Run app
$app->run();
