function nuevoProyecto(){
	event.preventDefault();
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
		link.setAttribute("href", " /IDevelop1/IDevelop/public/Usuario/login");
		$("#modalAviso").modal();
		console.log("El proyecto ya existe");
	}else{
		console.log("el proyecto no existe");
		intento=ingresarUsuario(nombre,descripcion,fechaE,fechaFP);
		console.log("intento:" +intento);
		if(intento==true){
			console.log("ingresado");
		}else{
			var mensaje = "Hubo un problema al registrar del proyecto";
			$("#mensajeModal").html(mensaje);				
			$("#modalAviso").modal();

			console.log("No ingresado")
		}
	}
	
}


function ingresarProyecto(nombre,descripcion,fechaE,fechaFP){
	var retorno;
	$.ajax({
		async:false,
		url: '/IDevelop1/IDevelop/public/Proyecto/NuevoProyecto',
		type: 'POST',
		data: {
			"email": email,
			"nombre": nombre,
			"apellido": apellido,
			"contraseña": contraseña,
			"fecha": fecha,
			"sexo": sexo,
			"tipo": tipo,
			"token": token,
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
			console.log("Nombre:" + response);
			retorno = response;
			
		}
	});
	return retorno;
}

const form = document.getElementById('formAltaProyecto');
form.addEventListener('submit', nuevoProyecto);