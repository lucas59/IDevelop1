function Postularse(id,usuario){
	 $('.lista_tabla').load('/IDevelop1/IDevelop/templates/modal_carga.twig');
	var retorno = Postularse_proyecto(id,usuario);
	var contenedor = document.getElementById('contenedor_carga');
	contenedor.style.visibility = 'hidden';
	contenedor.style.opacity = '0';
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
}


function Postularse_proyecto(id,usuario){
	var retorno;
	$.ajax({
		async:false,
		url: '/IDevelop1/IDevelop/public/Proyecto/Nuevo/Postularse',
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
