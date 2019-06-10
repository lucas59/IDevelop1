function verDatosdeProyecto(){
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
}

function mostrarProyecto(id){
	console.log("llego");
	window.location.href = "/IDevelop1/IDevelop/public/Proyecto/"+id;
	
}