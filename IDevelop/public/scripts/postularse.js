	function Postularse(id,usuario,destino){

		$('.lista_tabla').load('/IDevelop1/IDevelop/templates/modal_carga.twig');
		var retorno = Postularse_proyecto(id,usuario,destino);
		if(retorno == "1"){
			var mensaje = "Usted se postulo correctamente";
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

	function Postularse_proyecto(id,usuario,destino){
		var retorno;
		$.ajax({
			async:false,
			url: urlBase+'/Proyecto/Postularse',
			type: 'POST',
			data: {
				"id": id,
				"usuario": usuario,
				"destino": destino
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

