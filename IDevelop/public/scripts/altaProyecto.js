function nuevoProyecto(){
	event.preventDefault();
	$('.lista_tabla').load('/IDevelop1/IDevelop/templates/modal_carga.twig');
	var formulario = document.forms['formAltaProyecto'];
	var nombre = formulario['txtNombre'].value;
	var descripcion = formulario['txtDescripcion'].value;
	var fechaE = formulario['txtFechaE'].value;
	var fechaFP = formulario['txtFechaFP'].value;

	var disponible = nombreProyectoDisponible(nombre);
	
	if(disponible == "1"){
		var mensaje = "ya existe un proyecto bajo ese nombre en IDevelop";
		$("#mensajeModal").html(mensaje);				
		var link = document.getElementById("redirigir");
		$("#modalAviso").modal();
		console.log("El proyecto ya existe");
	}else{
		console.log("el proyecto no existe");
		intento=ingresarProyecto(nombre,descripcion,fechaE,fechaFP);
		console.log("intento:" +intento);
		if(intento==true){
			console.log("ingresado");
			var mensaje = "Proyecto ingresado con exito";
			$("#mensajeModal").html(mensaje);				
			var link = document.getElementById("redirigir");
			link.setAttribute("href", " /IDevelop1/IDevelop/public");
			$("#modalAviso").modal();
		}else{
			var mensaje = "Hubo un problema al registrar del proyecto";
			$("#mensajeModal").html(mensaje);				
			$("#modalAviso").modal();

			console.log("No ingresado")
		}
	}

	var contenedor = document.getElementById('contenedor_carga');
	contenedor.style.visibility = 'hidden';
	contenedor.style.opacity = '0';
	
}


function ingresarProyecto(nombre,descripcion,fechaE,fechaFP){
	var retorno;
	$.ajax({
		async:false,
		url: '/IDevelop1/IDevelop/public/Proyecto/NuevoProyecto',
		type: 'POST',
		data: {
			"nombre": nombre,
			"descripcion": descripcion,
			"fechaE": fechaE,
			"fechaFP": fechaFP,
		},
		success: function(response){
			console.log("coso : " +response);
			response=response.trim();
			if(response=="1"){
				retorno = true;
			}else if(response == "0"){
				retorno =false;
			}
		},
		error: function(response){
			console.log("response:" + eval(response));
		}
	});		
	return retorno;
}

function nombreProyectoDisponible(nombre){
	var retorno;
	$.ajax({
		async:false,
		url: '/IDevelop1/IDevelop/public/Proyecto/validarNombreP/'+nombre,
		
		success: function(response){
			response = response.trim();
			console.log("nombre:" + response);
			retorno = response;
			
		}
	});
	return retorno;
}

const form = document.getElementById('formAltaProyecto');
form.addEventListener('submit', nuevoProyecto);