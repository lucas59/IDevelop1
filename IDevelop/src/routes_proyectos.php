<?php 

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require_once 'controladores/ctr_proyecto.php';
require_once '../src/Clases/console.php';

return function (App $app){
	$container = $app->getContainer(); 

	$app->get('/Proyecto/nuevo',function($request,$response,$args) use ($container){
		if(isset($_SESSION['admin'])){
			$session=$_SESSION['admin'];
			$sesion = array("session" => $session);
			return $this->view->render($response,"altaProyecto.twig",$sesion);
		}else{
			$mensaje = "Debe iniciar sesion como Empresa para poder crear proyectos";
			$mensaje_sesion = array("mensaje" => $mensaje);
			return $this->view->render($response,"mensaje.twig", $mensaje_sesion);
		}
	})->setName("NuevoProyecto");

	$app->get('/Proyecto/nuevoCU',function($request,$response,$args) use ($container){
		if(isset($_SESSION['admin'])){
			$session = $_SESSION['admin'];
			return $this->view->render($response,"casodeuso.twig",compact('sesion'));
		}else{
			$mensaje ="Debe iniciar sesión como Desarrollador para poder planificar proyectos";
			$mensaje_sesion = $arrayName = array('mensaje' => $mensaje );
			return $this->view->render($response,"mensaje.twig",$mensaje_sesion);
		}
	})->setName("NuevoCasoDeUso");

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

	$app->get('/Proyecto/validarNombreCU/{nombre}',function($request,$response,$args){
		$controladorProyecto = new ctr_proyecto();
		$nombre = $args['nombre'];
		$retorno = $controladorProyecto->validarNombreCasoDeUso($nombre);
		return $retorno;
	});

	$app->post('/Proyecto/NuevoCasoDeUso',function(Request $request, Response $response ){
		$data = $request->getParams();
		$nombre = $data['nombre'];
		$descripcion = $data['descripcion'];
		$impacto = $data['impacto'];
		ob_clean();
		$retorno = ctr_proyecto::agregarCasoDeUso($nombre, $descripcion, $impacto);
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
			echo Console::log('asd',$_SESSION['admin']);
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
			$referencia =  $controladorP->verificarReferencia($session->id ,$idProyecto);
			if($referencia['cantidad']==0){
				return $this->view->render($response,"index.twig",$args);		
			}else{
				$proyecto = $controladorP::obtenerProyecto($idProyecto);
				$args['proyecto']=$proyecto;
				return $this->view->render($response,"perfilProyecto.twig",$args);
			}
		}
	});
}
?>