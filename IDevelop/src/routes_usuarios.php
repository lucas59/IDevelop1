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
		if($_SESSION){
			$args['session']=$_SESSION['admin'];
			return $this->view->render($response,"index.twig",$args);	
		}
		return $this->view->render($response,"login.twig");
	})->setName("ingresar");

	$app->get('/Usuario/VerDesarrolladores',function($request,$response,$args) use ($container){
		$session = null;
		if(isset($_SESSION['admin'])){
			$session=$_SESSION['admin']; 
		}
		$controladorUsuarios = new ctr_usuarios();
		$usuarios = $controladorUsuarios->obtenerUsuarios();
		return $this->view->render($response,"listadousuarios.twig",compact('usuarios','session'));
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
			echo Console::log("er",$usuario);
			return $this->view->render($response,"altaUser2.twig",$usuario);	
		}else{
			return $this->view->render($response,"index.twig");

		}
	});

	$app->get('/Usuario/Paises',function($request,$response,$args){
		$controladorUsuarios = new ctr_usuarios();
		$response->getBody()->write(json_encode($controladorUsuarios->listarPaises()));
		return $response;
	});

	$app->get('/Usuario/buscar',function($request,$response,$args){
		$controladorUsuarios = new ctr_usuarios();
		$arreglo = $controladorUsuarios->obtenerDesarrolladoresParaFiltrar();
		$arreglo1 = $controladorUsuarios->obtenerEmpresasParaFiltrar();
		$retorno = array_merge($arreglo,$arreglo1);
		return json_encode($retorno);
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
		if($controladorUsuarios->desactivarUsuario($correo)){
			return "1";
		}else{
			return "0";
		}
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
		$foto = $_FILES['fotoPerfil'];		
		$pais = $_POST['pais'];
		$ciudad = $_POST['ciudad'];
		$email = $_POST['email'];
		$lenguaje = $_POST['lenguaje'];
		//obtengo el curriculo
		$nombreArchivo = $_FILES['file']['name'];
		$base64 = base64_encode(file_get_contents($_FILES["file"]["tmp_name"]));
		$tamañoArchivo = $_FILES['file']['size'];
		$extension = explode('.', $nombreArchivo);
		$extension = end($extension);
		$extension = strtolower($extension);

		$arrayCurriculo = array('base64' =>$base64 ,'tamaño'=>$tamañoArchivo,'extension'=>$extension );

		$curriculo = json_encode($arrayCurriculo);

//obtengo la foto de perfil

		$nombreArchivo = $_FILES['fotoPerfil']['name'];
		$base64 = base64_encode(file_get_contents($_FILES["fotoPerfil"]["tmp_name"]));
		$tamañoArchivo = $_FILES['fotoPerfil']['size'];
		$extension = explode('.', $nombreArchivo);
		$extension = end($extension);
		$extension = strtolower($extension);

		$arrayFoto = array('base64' =>$base64 ,'tamaño'=>$tamañoArchivo,'extension'=>$extension );

		$foto = json_encode($arrayFoto);


		$controladorUsuarios = new ctr_usuarios();
		$retorno = $controladorUsuarios->enviarDatosDesarrollador($email,$pais,$ciudad,$lenguaje,$curriculo,$foto);
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

//
		$nombreArchivo = $_FILES['fotoPerfil']['name'];
		$base64 = base64_encode(file_get_contents($_FILES["fotoPerfil"]["tmp_name"]));
		$tamañoArchivo = $_FILES['fotoPerfil']['size'];
		$extension = explode('.', $nombreArchivo);
		$extension = end($extension);
		$extension = strtolower($extension);

		$arrayFoto = array('base64' =>$base64 ,'tamaño'=>$tamañoArchivo,'extension'=>$extension );

		$foto = json_encode($arrayFoto);



		$controladorUsuarios = new ctr_usuarios();
		$retorno = $controladorUsuarios->enviarDatosEmpresa($pais,$ciudad,$email,$vision,$mision,$tel,$rubro,$reclutador,$direccion,$foto);
		if($retorno==1){
			ctr_usuarios::ponerSession($email,'e');
			return "1";
		}else{
			return "0";
		}	
	});
	$app->get('/Usuario/Perfil',function(Request $request, Response $response,$args){
		$email=$request->getQueryParam("email");
		if($request->getQueryParam("idproyecto") != null){
		$args['idProyecto']=$request->getQueryParam("idproyecto");
		$args['idEmpresa']=$request->getQueryParam("idEmpresa");
		}
		if($email==null){
			if(isset($_SESSION['admin'])){
				if($_SESSION['admin']->tipo==1){
					$args['session']=$_SESSION['admin'];
					return $this->view->render($response,"index.twig",$args);					
				}else{
					
					$email=$_SESSION['admin']->id; 	
				}
			}else{
				return $this->view->render($response,"index.twig",$args);
			}
		}
		$controladorUsuarios = new ctr_usuarios();
		$Desarrollador = $controladorUsuarios->PerfilDesarrollador($email);
		$experiencia=null;
		$herramientas=null;
		$proyectos=null;
		if($Desarrollador){
			$args['Desarrollador']=$Desarrollador;
			echo Console::log('asd',$Desarrollador);
			$args['herramientas']=$controladorUsuarios->DesarrolladorHerramientas($email);
			$args['proyectos']=$controladorUsuarios->DesarrolladorProyectos($email);
			$args['experiencia']=$controladorUsuarios->DesarrolladorExperiencia($email);
			if($_SESSION && $_SESSION['admin']->tipo == 0){
					$args['session']=$_SESSION['admin'];		
			}		
			return $this->view->render($response,"PerfilDesarrollador.twig",$args);
		}
		return $this->view->render($response,"index.twig",$args);
	})->setName('perfil');

	$app->get('/Usuario/VerEmpresas',function($request,$response,$args){
		$controladorUsuarios = new ctr_usuarios();
		$Empresas = $controladorUsuarios->listarEmprezas();
		if(isset($_SESSION['admin'])){
			if($_SESSION['admin']->tipo == 0){
				$session=$_SESSION['admin'];
				return $this->view->render($response,"listadoempreza.twig",compact('Empresas','session'));
			}else if($_SESSION['admin']->tipo == 1){
				$session=$_SESSION['admin']; 
				return $this->view->render($response,"listadoempreza.twig",compact('Empresas','session'));
			}
		}
		return $this->view->render($response,"listadoempreza.twig",compact('Empresas'));
	})->setName("listadoE");

	$app->get('/Usuario/PerfilE',function($request,$response,$args){
		$email=$request->getQueryParam("email");
		if($email==null){
			if(isset($_SESSION['admin'])){
				$email=$_SESSION['admin']->id; 			
			}else{
				return $this->view->render($response,"index.twig",$args);
			}
		}
		$controladorUsuarios = new ctr_usuarios();
		$Empresa = $controladorUsuarios->PerfilEmpresa($email);
		$proyectos= array();
		if($Empresa){
			$proyectos = $controladorUsuarios->proyectosEmpresa($email);
		}
		if(isset($_SESSION['admin'])){
			if($_SESSION['admin']->tipo == 0){
				$session=$_SESSION['admin'];
				return $this->view->render($response,"PerfilEmpresa.twig",compact('Empresa','proyectos','session')); 
			}else if($_SESSION['admin']->tipo == 1){
				$session=$_SESSION['admin']; 
				return $this->view->render($response,"PerfilEmpresa.twig",compact('Empresa','proyectos','session')); 
			}
		}
		return $this->view->render($response,"PerfilEmpresa.twig",compact('Empresa','proyectos'));
	})->setName("PerfilE");
	
	$app->get('/Usuario/ElejirPostulante',function($request,$response,$args){
		/*$data = $request->getParams();
		$email=$data['email'];
		$idProyecto=$data['idproyecto'];*/
		$email=$request->getQueryParam("email");
		$idProyecto=$request->getQueryParam("idProyecto");
		if($email==null){
			header("Location: http://localhost/IDevelop1/IDevelop/public/Proyecto/$idProyecto");
		}
		$controladorUsuarios = new ctr_usuarios();
		$Postulante = $controladorUsuarios->ElejirPostulante($email,$idProyecto);
	
		if(isset($_SESSION['admin'])){
				$session=$_SESSION['admin'];	
		}
		header("Location: http://localhost/IDevelop1/IDevelop/public/Proyecto/$idProyecto");
exit();
	})->setName("EPostulate");
}
?>