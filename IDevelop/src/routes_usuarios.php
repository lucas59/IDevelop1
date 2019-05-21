<?php 

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require_once 'controladores/ctr_usuarios.php';
require_once '../src/Clases/console.php';


return function (App $app){
	$container = $app->getContainer(); 
	$app->get('/Usuario/nuevo',function($request,$response,$args) use ($container){
		return $this->view->render($response,"altaUser.twig");
	})->setName("NuevoUsuario");

	$app->get('/Usuario/login',function($request,$response,$args) use ($container){
		return $this->view->render($response,"login.twig");
	})->setName("ingresar");

	$app->get('/Usuario/VerDesarrolladores',function($request,$response,$args) use ($container){
		$sesion = null;
		if(isset($_SESSION['admin'])){
		$sesion=$_SESSION['admin']; 
		}
		$controladorUsuarios = new ctr_usuarios();
		$usuarios = $controladorUsuarios->obtenerUsuarios();
		return $this->view->render($response,"listadousuarios.twig",compact('usuarios','sesion'));
	})->setName("listado");

	$app->get('/Usuario/cerrar',function($request,$response,$args) use ($container){
		$controladorUsuarios = new ctr_usuarios();
		$controladorUsuarios->cerrarsesion();
		$sesion = null;
		return $this->view->render($response,"index.twig",compact('sesion'));
	})->setName("cerrar");

	$app->get('/Usuario/validarCorreo/{email}',function($request,$response,$args){
		$controladorUsuarios = new ctr_usuarios();
		$email = $args['email'];
		$retorno = $controladorUsuarios->validarEmail($email);
		return $retorno;
	});

	$app->get('/Usuario/validar/{token}',function($request,$response,$args){
		$controladorUsuarios = new ctr_usuarios();
		$token = $args['token'];
		$validar = $controladorUsuarios->validarCuenta($token);
		if($validar){
			$usuario=$controladorUsuarios->obtenerUsuarioPorToken($token);
			$usuario = array ("usuario"  => $usuario);
			return $this->view->render($response,"altaUser2.twig",$usuario);	
		}else{
			return $this->view->render($response,"index.twig");

		}
	});

	$app->get('/Usuario/Paises',function($request,$response,$args){
		$controladorUsuarios = new ctr_usuarios();
		//echo json_encode($controladorUsuarios->listarPaises());
		$response->getBody()->write(json_encode($controladorUsuarios->listarPaises()));
		return $response;
	});

	$app->get('/Usuario/Ciudad/{pais}',function($request,$response,$args){
		$controladorUsuarios = new ctr_usuarios();
		$pais = $args['pais'];
		$response->getBody()->write(json_encode($controladorUsuarios->listarCiudades($pais)));
		return $response;
	});

	$app->get('/Usuario/Desactivar/{correo}',function($request,$response,$args){
		$controladorUsuarios = new ctr_usuarios();
		$correo = $args['correo'];
		return $controladorUsuarios->desactivarUsuario($correo);
	});

	$app->post('/Usuario/NuevoUsuario',function(Request $request, Response $response){
		$data = $request->getParams();
		$email=$data['email'];
		$nombre=$data['nombre'];
		$apellido=$data['apellido'];
		$pass=$data['contraseña'];
		$fecha=$data['fecha'];
		$sexo=$data['sexo'];
		$tipo=$data['tipo'];
		$token=$data['token'];
		ob_clean();
		$retorno = ctr_usuarios::ingresarUsuario($email,$nombre,$apellido,$pass,$fecha,$sexo,$tipo,$token);
		if($retorno == "1"){
			return ctr_usuarios::ingresarUsuHijo($email,$nombre,$apellido,$fecha,$tipo);
			ob_clean();
		}else{
			return "0";
		}

	});

	$app->post('/Usuario/Validacion/Enviar',function(Request $request, Response $response){
		$data = $request->getParams();
		$email=$data['email'];
		$nombre=$data['nombre'];
		$apellido=$data['apellido'];
		$token=$data['token'];
		
		$retorno = ctr_usuarios::enviarValidacion($email,$nombre,$apellido,$token);
		return $retorno;
	});
	$app->post('/Usuario/Logearse',function(Request $request, Response $response){

		$data = $request->getParams();
		$email=$data['email'];
		$pass=$data['pass'];
		$controladorUsuarios = new ctr_usuarios();
		$retorno = $controladorUsuarios->Login($email,$pass);
		return $retorno;
	});

	$app->post('/Usuario/Desarrollador/Datos',function (Request $request, Response $response){
		$file = $_FILES['file'];
		$pais = $_POST['pais'];
		$ciudad = $_POST['ciudad'];
		$email = $_POST['email'];
		$lenguajes = $_POST['lenguajes'];
		//echo Console::log("lenguajes",$lenguajes);

		$nombreArchivo = $_FILES['file']['name'];
		$base64 = base64_encode(file_get_contents($_FILES["file"]["tmp_name"]));
		$tamañoArchivo = $_FILES['file']['size'];
		$extension = explode('.', $nombreArchivo);
		$extension = end($extension);
		$extension = strtolower($extension);

		$arrayCurriculo = array('base64' =>$base64 ,'tamaño'=>$tamañoArchivo,'extension'=>$extension );

		$curriculo = json_encode($arrayCurriculo);

		$controladorUsuarios = new ctr_usuarios();
		$retorno = $controladorUsuarios->enviarDatosDesarrollador($email,$pais,$ciudad,$lenguajes,$curriculo);
		if($retorno==1){
			ctr_usuarios::ponerSession($email,'d');
			return "1";
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
	$app->get('/Usuario/Perfil',function(Request $request, Response $response,$args){
		$email=$request->getQueryParam("email");
		$controladorUsuarios = new ctr_usuarios();
		$Desarrollador = $controladorUsuarios->PerfilDesarrollador($email);
		$experiencia=null;
		$herramientas=null;
		$proyectos=null;
		if($Desarrollador){
			$herramientas=$controladorUsuarios->DesarrolladorHerramientas($email);
			$proyectos=$controladorUsuarios->DesarrolladorProyectos($email);
			$experiencia=$controladorUsuarios->DesarrolladorExperiencia($email);
		}
		$sesion = null;
		if(isset($_SESSION['admin'])){
			$sesion=$_SESSION['admin']; 
		}
		return $this->view->render($response,"PerfilDesarrollador.twig",compact('Desarrollador','sesion','experiencia','herramientas','proyectos'));
	});

	$app->get('/Usuario/VerEmpresas',function($request,$response,$args){
		$controladorUsuarios = new ctr_usuarios();
$Empresas = $controladorUsuarios->listarEmprezas();
		return $this->view->render($response,"listadoempreza.twig",compact('Empresas'));
	})->setName("listadoE");

	$app->get('/Usuario/PerfilE',function($request,$response,$args){
		$email=$request->getQueryParam("email");
		$controladorUsuarios = new ctr_usuarios();
		$Empresa = $controladorUsuarios->PerfilEmpresa($email);
		if($Empresa){
		$proyectos = $controladorUsuarios->proyectosEmpresa($email);
	}
		return $this->view->render($response,"PerfilEmpresa.twig",compact('Empresa','proyectos'));
	});
}
?>