
function nuevoCasoDeUso(){
	event.preventDefault();
	$('.lista_tabla').load('/IDevelop1/IDevelop/templates/modal_carga.twig');
	var formulario = document.forms['formCasosDeUso'];
	var proyecto = "1";  //cambiar por parametro
	var nombre = formulario['txtNombreCU'].value;
	var descripcion = formulario['txtDescripcion'].value;
	var combo = document.getElementById("Impacto");
	var impacto = combo.options[combo.selectedIndex].value;

	console.log(impacto);

	var disponible = nombreCdUDisponible(nombre);
	
	if(disponible == "1"){
		var mensaje = "Ya creo un caso de uso bajo este nombre para esta planificacion";
		$("#mensajeModal").html(mensaje);				
		var link = document.getElementById("redirigir");
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
			link.setAttribute("href", " /IDevelop1/IDevelop/public/");
			$("#modalAviso").modal();
		}else{
			var mensaje = "Hubo un problema al registrar el nuevo caso de uso";
			$("#mensajeModal").html(mensaje);				
			var link = document.getElementById("redirigir");
			link.setAttribute("href", " /IDevelop1/IDevelop/public/Proyecto/nuevoCU");
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

function nombreCdUDisponible(nombre){
	var retorno;
	$.ajax({
		async:false,
		url: '/IDevelop1/IDevelop/public/Proyecto/validarNombreCU/'+nombre,
		
		success: function(response){
			response = response.trim();
			retorno = response;
			
		}
	});
	return retorno;
}

const form = document.getElementById('formCasosDeUso');
form.addEventListener('submit', nuevoCasoDeUso);