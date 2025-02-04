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

	$app->get('/Proyecto/nuevoCU/{id}',function($request,$response,$args) use ($container){
		if(isset($_SESSION['admin']) && $_SESSION['admin']->tipo == 0){
			$session = $_SESSION['admin'];
			$idp = $args['id'];
			$controlador = new ctr_proyecto();
			$proyecto =  $controlador->obtenerProyectoCU($idp);
			$sesion = array("proyecto" => $proyecto, "session" => $session);
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

	$app->post('/Proyecto/existeCasoDeUso',function(Request $request, Response $response){
		$data = $request->getParams();
		$idproyecto = $data['id'];
		$retorno = ctr_proyecto::hayPlanificacion($id);

		if($retorno){
			return "1";
		}else{
			return "0";
		}
	});

	$app->post('/Proyecto/Postularse',function(Request $request, Response $response){
		$data = $request->getParams();
		$id=$data['id'];
		$usuario=$data['usuario'];
		$destino = $data['destino'];
		$retorno = ctr_proyecto::PostularseProyecto($id,$usuario);
		$titulo = "Postulaciones";
		$mensaje = "Un usuario acaba de postularse a un proyecto";
		$retorno_2 = ctr_proyecto::enviarCorreo($id,$destino,$titulo,$mensaje);
		if($retorno && $retorno_2){
			return "1";
		}
		else{
			return "0";
		}
	});

	$app->post('/Proyecto/actualizarCasoDeUso2', function(Request $request, Response $response){
		$data = $request->getParams();
		$id= $data['id'];
		$progreso = $data['progreso'];
		$nombre = $data['nombre'];
		ob_clean();
		
		$retorno = ctr_proyecto::actualizarCU($id, $progreso, $nombre);


		return $retorno;
	});


	$app->post('/Proyecto/eliminarCU', function(Request $request, Response $response){
		$data = $request->getParams();
		$id= $data['id'];
		$nombre = $data['nombre'];
		ob_clean();
		$retorno = ctr_proyecto::eliminarCU($id, $nombre);
		return $retorno;
	});




	$app->post('/Proyecto/activar_desactivar',function(Request $request, Response $response){
		$data = $request->getParams();
		$id = $data['proyecto'];
		$estado = $data['estado'];
		$finPos = $data['fechafinP'];
		$finPro = $data['fechaEntregaP'];
		$retorno = ctr_proyecto::Activar_desactivar_proyecto($id,$estado,$finPos,$finPro);
		if($retorno){
			return "1";
		} else{
			return "0";
		}
	});

	$app->post('/Proyecto/activar_desactivar_des',function(Request $request, Response $response){
		$data = $request->getParams();
		$id = $data['proyecto'];
		$estado = $data['estado'];
		$retorno = ctr_proyecto::Activar_desactivar_proyecto_des($id,$estado);
		if($retorno){
			return "1";
		} else{
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
		if(isset($_SESSION['admin']) && $_SESSION['admin']->tipo == 1){
		$id=$request->getQueryParam("proy");
		$idEmpresa =$request->getQueryParam("IdEmpresa");
		$controladorProyecto = new ctr_proyecto();
		$postulantes=$controladorProyecto->PostulantesDeProyecto($id);
		$sesion=$_SESSION['admin'];
		$proyecto = $controladorProyecto->obtenerProyecto($id);
		$session = array("proyecto" => $proyecto,"session" => $sesion,"postulantes" => $postulantes,"idEmpresa" => $idEmpresa);
		return $this->view->render($response,"PostulantesProyecto.twig",$session);
			}
			return $this->view->render($response,"index.twig");	
	});

	$app->get('/Proyecto/Proyectos',function($request,$response,$args){
		
		$controladorP = new  ctr_proyecto();
		if ($_SESSION) {
			$session = $_SESSION['admin'];
			$args['session']=$_SESSION['admin'];		
			}
			$proyectos = $controladorP->listarProyectos();
			$args['proyectos']=$proyectos;
			echo Console::log('asd',$proyectos);
			return $this->view->render($response,"proyectos.twig",$args);
		
	})->setName('proyectos');

	$app->get('/Proyecto/casosdeuso/{id}', function($request,$response,$args){
		if(isset($_SESSION['admin'])){	
			$session = $_SESSION['admin'];
			$idproyecto = $args['id'];
			$controlador = new ctr_proyecto();
			$proy = $controlador->obtenerProyectoCU($idproyecto);
			$listaCU = $controlador->Listarcasosdeuso($idproyecto);
			$puntosTot = $controlador->obtenerPuntosTotalProy($idproyecto);
			$progresoTot = $controlador->obtenerProgresoTotalProy($idproyecto);

			$args = array("proyecto" => $proy,"casosdeuso" => $listaCU,"puntosTot" => $puntosTot,"progresoTot" => $progresoTot,"session" => $session);
			return $this->view->render($response,"VerCasosDeUso.twig",$args);
		}else{
			$mensaje ="Debe iniciar sesión como Desarrollador para poder planificar proyectos";
			$mensaje_sesion = $arrayName = array('mensaje' => $mensaje );
			return $this->view->render($response,"mensaje.twig",$mensaje_sesion);
		}
	})->setName("CasosDeUso");


	$app->get('/Proyecto/{id}', function($request,$response,$args){
		$session=null;
		if($_SESSION){
			$args['session']=$_SESSION['admin'];
			$session = $_SESSION['admin'];
		}
			$controladorP = new ctr_proyecto();
			$controladorU = new ctr_usuarios();
			$idProyecto = $args['id'];
			$proyecto = $controladorP::obtenerProyecto($idProyecto);
			if($proyecto["id"] == null || $session == null ){
				return $this->view->render($response,"index.twig",$args);
			}else{
				$args['proyecto']=$proyecto;
				if($session->tipo==0){
					$referencia = $controladorP->verificarReferencia($session->id,$idProyecto,0);
					$args['referencia']=$referencia;
					$referencia_2 = $controladorP->verificarPostulacion($session->id,$idProyecto);
					$args['postulacion']=$referencia_2;
					$referencia_3 = $controladorP->verificarTrabajo_proyecto($session->id,$idProyecto);
					$args['trabajando_proyecto']=$referencia_3;
				}else{
					$referencia = $controladorP->verificarReferencia($session->id,$idProyecto,1);
					$args['referencia']=$referencia;
				}
				$contratacion=$controladorP->verificarContratacion($idProyecto);
				
				if($contratacion == false){
				$postulante=$controladorP->PostulantesDeProyecto($idProyecto);
				echo Console::log("asd",$postulante);
				$args['postulante'] = $postulante;
				}
				$args['idProyecto'] = $idProyecto;
				return $this->view->render($response,"perfilProyecto.twig",$args);
			}
		
	});

}
?>