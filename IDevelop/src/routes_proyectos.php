<?php 

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require_once 'controladores/ctr_proyecto.php';
require_once '../src/Clases/console.php';

return function (App $app){
	$container = $app->getContainer(); 

	$app->get('/Proyecto/nuevo',function($request,$response,$args) use ($container){
		$session=$_SESSION['admin'];
		return $this->view->render($response,"altaProyecto.twig",compact('session'));
	})->setName("NuevoProyecto");

	$app->get('/Proyecto/PostularseProyecto',function($request,$response,$args) use ($container){
		if($_SESSION){
			$controladorProyecto = new ctr_proyecto();
			$sesio = $_SESSION['admin'];
			$id_usuario = $sesio->id;
			$lista = $controladorProyecto->Listar_Proyectos($id_usuario);
			$sesion = array("listas" => $lista,"session" => $sesio);
			return $this->view->render($response,"postularse.twig", $sesion);
		}
		else{
			$mensaje = "No existe un usuario en la sesión";
			$mensaje_sesion = array("mensaje" => $mensaje);
			return $this->view->render($response,"mensaje.twig", $mensaje_sesion);
		}
	})->setName("Postularse");

	$app->get('/Proyecto/BajarseProyecto',function($request,$response,$args) use ($container){
		if($_SESSION){
			$controladorProyecto = new ctr_proyecto();
			$sesio = $_SESSION['admin'];
			$id_usuario = $sesio->id;
			$lista = $controladorProyecto->Listar_Proyectos_usuario($id_usuario);
			$sesion = array("listas" => $lista,"session" => $sesio);
			return $this->view->render($response,"Bajarse_proyecto.twig", $sesion);
		}
		else{
			$mensaje = "No existe un usuario en la sesión";
			$mensaje_sesion = array("mensaje" => $mensaje);
			return $this->view->render($response,"mensaje.twig", $mensaje_sesion);
		}
	})->setName("BajarseProyecto");


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
		return $retorno;

	});

	$app->post('/Proyecto/Postularse',function(Request $request, Response $response){
		$data = $request->getParams();
		$id=$data['id'];
		$usuario=$data['usuario'];
		$retorno = ctr_proyecto::PostularseProyecto($id,$usuario);
		if($retorno){
			return "1";
		}
		else{
			return "0";
		}
	});

	$app->post('/Proyecto/Despostularse',function(Request $request, Response $response){
		$data = $request->getParams();
		$id=$data['id'];
		$usuario=$data['usuario'];
		$retorno = ctr_proyecto::DespostularseProyecto($usuario,$id);
		if($retorno){
			return "1";
		}
		else{
			return "0";
		}
	});

	$app->get('/Proyecto/VerPostulantes',function($request,$response,$args){
		$id=$request->getQueryParam("proy");
		$controladorProyecto = new ctr_proyecto();
		$args['postulantes']=$controladorProyecto->PostulantesDeProyecto($id);
		if(isset($_SESSION['admin'])){
			if($_SESSION['admin']->tipo == 0){
				$args['session']=$_SESSION['admin'];	
			}else if($_SESSION['admin']->tipo == 1){
				$args['sesion']=$_SESSION['admin']; 
			}
		}
		return $this->view->render($response,"PostulantesProyecto.twig",$args);
		
	});
}
?>