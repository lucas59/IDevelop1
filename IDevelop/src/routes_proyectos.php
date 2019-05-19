<?php 

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require_once 'controladores/ctr_proyecto.php';
require_once '../src/Clases/console.php';


return function (App $app){
	$container = $app->getContainer(); 
	$app->get('/Proyecto/nuevo',function($request,$response,$args) use ($container){
		return $this->view->render($response,"altaProyecto.twig");
	})->setName("NuevoProyecto");

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

	$app->post('/Usuario/Empresa/Datos',function (Request $request, Response $response){
		$vision = $_POST['vision'];
		$mision = $_POST['mision'];
		$tel = $_POST['tel'];
		$rubro = $_POST['rubro'];
		$reclutador = $_POST['reclutador'];
		$direccion = $_POST['direccion'];
		$email = $_POST['email'];
		$pais = $_POST['pais'];
		$ciudad = $_POST['ciudad'];

		$controladorUsuarios = new ctr_usuarios();
		$retorno = $controladorUsuarios->enviarDatosEmpresa($pais,$ciudad,$email,$vision,$mision,$tel,$rubro,$reclutador,$direccion);
		if($retorno==1){
			ctr_usuarios::ponerSession($email,'e');
			return "1";
		}else{
			return "0";
		}
	});

}
?>