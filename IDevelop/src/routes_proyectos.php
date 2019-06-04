<?php 

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require_once 'controladores/ctr_proyecto.php';
require_once '../src/Clases/console.php';

return function (App $app){
	$container = $app->getContainer(); 

	$app->get('/Proyecto/nuevo',function($request,$response,$args) use ($container){
		if(isset($_SESSION['admin']) && $_SESSION['admin']->tipo == 1){
			$session=$_SESSION['admin'];
			$sesion = array("session" => $session);
			return $this->view->render($response,"altaProyecto.twig",$sesion);
		}else{
			$mensaje = "Debe iniciar sesion como Empresa para poder crear proyectos";
			$mensaje_sesion = array("mensaje" => $mensaje);
			return $this->view->render($response,"mensaje.twig", $mensaje_sesion);
		}
	})->setName("NuevoProyecto");


	$app->get('/Proyecto/casodeusos',function($request,$response,$args) use ($container){
		$controladorProyecto = new ctr_proyecto();
		$args['casosdeuso'] = $controladorProyecto->Listarcasosdeuso();
		echo Console::log("we",$args);
		return $this->view->render($response,"casodeuso_vista.twig",$args);
	})->setName("casodeusos");

	$app->get('/Proyecto/nuevoCU',function($request,$response,$args) use ($container){
		if(isset($_SESSION['admin']) && $_SESSION['admin']->tipo == 0){
			$session = $_SESSION['admin'];
			$sesion = array("session" => $session);
			return $this->view->render($response,"casosdeuso.twig",$sesion);
		}else{
			$mensaje ="Debe iniciar sesión como Desarrollador para poder planificar proyectos";
			$mensaje_sesion = $arrayName = array('mensaje' => $mensaje );
			return $this->view->render($response,"mensaje.twig",$mensaje_sesion);
		}
	})->setName("NuevoCasoDeUso");

	$app->get('/Proyecto/validarNombreP/{nombre}',function($request,$response,$args){
		$controladorProyecto = new ctr_proyecto();
		$nombre = $args['nombre'];
		$retorno = $controladorProyecto->validarNombreP($nombre);
		return $retorno;
	});

	$app->get('/Proyecto/validarNombreCU/{nombre}',function($request,$response,$args){
		$controladorProyecto = new ctr_proyecto();
		$nombre = $args['nombre'];
		$retorno = $controladorProyecto->validarNombreCasoDeUso($nombre);
		return $retorno;
	});

	$app->post('/Proyecto/NuevoCasoDeUso',function(Request $request, Response $response ){
		$data = $request->getParams();
		$proy = $data['proyecto'];
		$nombre = $data['nombre'];
		$descripcion = $data['descripcion'];
		$impacto = $data['impacto'];
		ob_clean();
		$retorno = ctr_proyecto::agregarCasoDeUso($nombre, $descripcion, $impacto, $proy);
		return $retorno;
	});

	$app->post('/Proyecto/NuevoProyecto',function(Request $request, Response $response){
		if(!$_SESSION){
			return $this->view->render($response,"index.twig",$args);
		}else{
			$data = $request->getParams();
			$nombre=$data['nombre'];
			$descripcion=$data['descripcion'];
			$fechaE=$data['fechaE'];
			$fechaFP=$data['fechaFP'];
			ob_clean();
			$retorno = ctr_proyecto::agregarProyecto($nombre,$descripcion,$fechaE,$fechaFP);
			return $retorno;
		}
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
		echo Console::log("erw",$retorno);
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

	$app->get('/Proyecto/Proyectos',function($request,$response,$args){
		$controladorP = new  ctr_proyecto();
		if (!$_SESSION) {
			return $this->view->render($response,"index.twig",$args);
		}else{
			$session = $_SESSION['admin'];
			$args['session']=$_SESSION['admin'];
			if($session->tipo == 0){
				$proyectos = $controladorP->ListarProyectosDeDesarrolladores($session->id);
				$args['proyectos']=$proyectos;
			}else{
				$proyectos =  $controladorP->ListarProyectosDeEmpresa($session->id);
				$args['proyectos']=$proyectos; 
			}

			return $this->view->render($response,"proyectos.twig",$args);
		}
	})->setName('proyectos');

	$app->get('/Proyecto/{id}', function($request,$response,$args){
		if(!$_SESSION){
			return $this->view->render($response,"index.twig",$args);
		}else{
			$args['session']=$_SESSION['admin'];
			$controladorP = new ctr_proyecto();
			$controladorU = new ctr_usuarios();
			$idProyecto = $args['id'];
			$session = $_SESSION['admin'];
			$proyecto = $controladorP::obtenerProyecto($idProyecto);
			if($proyecto["id"] == null ){
				return $this->view->render($response,"index.twig",$args);
			}else{
				$args['proyecto']=$proyecto;
				if($session->tipo==0){
					$referencia = $controladorP->verificarReferencia($session->id,$idProyecto,0);
					$args['referencia']=$referencia;
					$referencia = $controladorP->verificarPostulacion($session->id,$idProyecto);
					$args['postulacion']=$referencia;
					$referencia = $controladorP->verificarTrabajo_proyecto($session->id,$idProyecto);
					$args['trabajando_proyecto']=$referencia;
					echo Console::log("ew",$referencia);
				}else{
					$referencia = $controladorP->verificarReferencia($session->id,$idProyecto,1);
					$args['referencia']=$referencia;
				}
				return $this->view->render($response,"perfilProyecto.twig",$args);
			}
		}
	});

}
?>