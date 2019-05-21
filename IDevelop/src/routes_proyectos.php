<?php 

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require_once 'controladores/ctr_proyecto.php';
require_once '../src/Clases/console.php';

return function (App $app){
	$container = $app->getContainer(); 

	$app->get('/Proyecto/nuevo',function($request,$response,$args) use ($container){
		if($_SESSION){
			$usuarioActual = $_SESSION['admin'];
			echo Console::log('prueba',$usuarioActual);
			if($usuarioActual->tipo == 1){
				$args['session'] = $_SESSION['admin'];
				return $this->view->render($response,"altaProyecto.twig",$args);	
			}else{
				return $this->view->render($response,"index.twig",$args);	
			}
		}else{
			return $this->view->render($response,"index.twig",$args);
		}
	})->setName("NuevoProyecto");

	$app->get('/Proyecto/PostularseProyecto',function($request,$response,$args) use ($container){
		$controladorProyecto = new ctr_proyecto();
		$lista = $controladorProyecto->Listar_Proyectos();
		$sesio = $_SESSION['admin'];
		echo Console::log("prueba",$sesio);
		$ses = array("listas" => $lista,"session" => $sesio);
		return $this->view->render($response,"postularse.twig", $ses);
	})->setName("Postularse");


	$app->get('/Proyecto/validarNombreP/{nombre}',function($request,$response,$args){
		$controladorProyecto = new ctr_proyecto();
		$nombre = $args['nombre'];
		$retorno = $controladorProyecto->validarNombreP($nombre);
		return $retorno;
	});

	$app->post('/Proyecto/NuevoProyecto',function(Request $request, Response $response){
		$data = $request->getParams();
		$nombre=$data['nombre'];
		$descripcion=$data['descripcion'];
		$fechaE=$data['fechaE'];
		$fechaFP=$data['fechaFP'];
		ob_clean();
		$retorno = ctr_proyecto::agregarProyecto($nombre,$descripcion,$fechaE,$fechaFP);
		if($retorno == "1"){
			ob_clean();
		}else{
			return "0";
		}

	});

	$app->post('Proyecto/Nuevo/Postularse',function(Request $request, Response $response){
		$data = $request->getParams();
		$id=$data['id'];
		$retorno = ctr_proyecto::PostularseProyecto($id);
		return $retorno;
	});
}
?>