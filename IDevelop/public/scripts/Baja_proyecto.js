const urlBase = "/IDevelop1/IDevelop/public";

function Baja(id,usuario){
	$('.lista_tabla').load('/IDevelop1/IDevelop/templates/modal_carga.twig');
	var retorno = Baja_postulacion(id,usuario);
	console.log("js:" + retorno);
	if(retorno == "1"){
		var mensaje = "Acción correcta";
		$("#mensajeModal").html(mensaje);	
		$("#modalAviso").modal();
	}
	else{
		var mensaje = "Acción incorrecta";
		$("#mensajeModal").html(mensaje);	
		$("#modalAviso").modal();
	}
	var contenedor = document.getElementById('contenedor_carga');
	contenedor.style.visibility = 'hidden';
	contenedor.style.opacity = '0';
}

function Baja_postulacion(id,usuario){
	var retorno;
	$.ajax({
		async:false,
		url: urlBase+'/Proyecto/Despostularse',
		type: 'POST',
		data: {
			"id": id,
			"usuario": usuario
		},
		success: function(response){
			response = response.trim();
			if(response=="1"){
				retorno = "1";
			}else{
				retorno = "0";
			}
		}
	});		
	return retorno;
}
