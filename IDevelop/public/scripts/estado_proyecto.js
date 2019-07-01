	function Estado_proyecto(id,estado){
		if(document.getElementById("txtFechaFP").value == '' || document.getElementById("txtFechaE").value == ''){
			var mensaje = "Error, ingrese una fecha valida";
			$("#mensajeModal").html(mensaje);	
			$("#modalAviso").modal();
		}
		else{
			var fechafinP = document.getElementById("txtFechaFP").value; 
			var fechaEntregaP = document.getElementById("txtFechaE").value; 

			var retorno = Estado_proyecto_funcion(id,estado,fechafinP,fechaEntregaP);
			if(retorno == "1" && estado == 4){
				var mensaje = "Usted activo el proyecto correctamente";
				$("#mensajeModal").html(mensaje);	
				$("#modalAviso").modal();
			}else if(retorno == '1' && estado == 0){
				var mensaje = "Usted finalizó el proyecto correctamente";
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
	}

	function Estado_proyecto_des(id,estado){
		var retorno = Estado_proyecto_funcion_des(id,estado);
		if(retorno == "1"){
			var mensaje = "Usted desactivo el proyecto correctamente";
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
	function Estado_proyecto_funcion(id,estado,fechafinP,fechaEntregaP){
		var retorno;
		$.ajax({
			async:false,
			url: urlBase+'/Proyecto/activar_desactivar',
			type: 'POST',
			data: {
				"proyecto": id,
				"estado": estado,
				"fechafinP": fechafinP,
				"fechaEntregaP": fechaEntregaP
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

	function Estado_proyecto_funcion_des(id,estado){
		var retorno;
		$.ajax({
			async:false,
			url: urlBase+'/Proyecto/activar_desactivar_des',
			type: 'POST',
			data: {
				"proyecto": id,
				"estado": estado
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