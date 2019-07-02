
function nuevoCasoDeUso(){
	event.preventDefault();
	$('.lista_tabla').load('/IDevelop1/IDevelop/templates/modal_carga.twig');
	var formulario = document.forms['formCasosDeUso'];
	var proyecto = formulario['proyecto_id'].value;
	var nombre = formulario['txtNombreCU'].value;
	var descripcion = formulario['txtDescripcion'].value;
	var combo = document.getElementById("Impacto");
	var impacto = combo.options[combo.selectedIndex].value;
	var urlBase = "/IDevelop1/IDevelop/public";
	var disponible = nombreCdUDisponible(nombre);

	if(disponible == "1"){
		var mensaje = "Ya creo un caso de uso bajo este nombre para esta planificacion";
		$("#mensajeModal").html(mensaje);				
		var link = document.getElementById("redirigir");
		link.setAttribute("href",  urlBase+"/Proyecto/casosdeuso/"+proyecto);
		$("#modalAviso").modal();
		console.log("Existe caso 1");
	}else{
		console.log("No existe caso 1");
		intento=ingresarCasoDeUso(nombre,descripcion,impacto,proyecto);
		console.log("intento:" +intento);
		if(intento==true){
			console.log("ingresado");
			var mensaje = "Caso de uso ingresado con exito";
			$("#mensajeModal").html(mensaje);				
			var link = document.getElementById("redirigir");
			link.setAttribute("href", urlBase+"/Proyecto/casosdeuso/"+proyecto);
			$("#modalAviso").modal();
		}else{
			var mensaje = "Hubo un problema al registrar el nuevo caso de uso";
			$("#mensajeModal").html(mensaje);				
			var link = document.getElementById("redirigir");
			link.setAttribute("href", urlBase+"/Proyecto/nuevoCU/"+proyecto);
			$("#modalAviso").modal();

			console.log("No ingresado")
		}
	}

	var contenedor = document.getElementById('contenedor_carga');
	contenedor.style.visibility = 'hidden';
	contenedor.style.opacity = '0';
}

function ingresarCasoDeUso(nombre,descripcion,impacto,proyecto){
	var retorno;
	
	$.ajax({
		async:false,
		url: '/IDevelop1/IDevelop/public/Proyecto/NuevoCasoDeUso',
		type: 'POST',
		data: {
			"nombre": nombre,
			"descripcion": descripcion,
			"impacto": impacto,
			"proyecto": proyecto,
		},
		success: function(response){
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

function nombreCdUDisponible(nombre){
	var retorno;
	var urlBase = "/IDevelop1/IDevelop/public";

	$.ajax({
		async:false,
		url: urlBase+'/Proyecto/validarNombreCU/'+nombre,
			success: function(response){
			response = response.trim();
			retorno = response;
			}
	});
	return retorno;
}

function actualizarCasoDeUso1(id, puntosTot , nombre){

	console.log(id,nombre);
	var combo = document.getElementById(nombre);
	var progreso = combo.options[combo.selectedIndex].value;	
	
	
	var puntosActuales = (puntosTot * progreso) / 100;
	console.log(puntosActuales);
	intento = actualizarCasoDeUso2(id, puntosActuales, nombre);	
	console.log("intento:" +intento);
	
	if(intento==true){
		var mensaje = "Caso de uso actualizado";
		$("#mensajeModal").html(mensaje);				
		var link = document.getElementById("redirigir");
		$("#modalAviso").modal();
	}else{
		var mensaje = "Hubo un problema en la actualizacion del caso de uso";
		$("#mensajeModal").html(mensaje);				
		var link = document.getElementById("redirigir");
		$("#modalAviso").modal();
	}
}

function EliminarCasoDeUso1(idProyecto,nombreCU){
	console.log(idProyecto,nombreCU);
	var intento = eliminarCU(idProyecto, nombreCU);	
	console.log("intento:" +intento);
	
	if(intento==true){
		var mensaje = "Caso de uso eliminado";
		$("#mensajeModal").html(mensaje);				
		var link = document.getElementById("redirigir");
		$("#modalAviso").modal();
	}else{
		var mensaje = "Problema al eliminar";
		$("#mensajeModal").html(mensaje);				
		var link = document.getElementById("redirigir");
		$("#modalAviso").modal();
	}


}

function eliminarCU(idProyecto,nombreCU){
	var retorno = null;
	$.ajax({
		async:false,
		url: '/IDevelop1/IDevelop/public/Proyecto/eliminarCU',
		type: 'POST',
		data: {
			"nombre": nombreCU,
			"id": idProyecto,
		},
		success: function(response){
			response=response.trim();
			console.log(response);
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

function actualizarCasoDeUso2(id, progreso, nombre){
	var retorno = null;
	console.log("No ingreso");
	
	$.ajax({
		async:false,
		url: '/IDevelop1/IDevelop/public/Proyecto/actualizarCasoDeUso2',
		type: 'POST',
		data: {
			"nombre": nombre,
			"progreso": progreso,
			"id": id,
		},
		success: function(response){
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

	
const form = document.getElementById('formCasosDeUso');
form.addEventListener('submit', nuevoCasoDeUso);