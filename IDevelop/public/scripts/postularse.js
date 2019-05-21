function Postularse(id,usuario){
	var retorno = Postularse_proyecto(id,usuario);
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
