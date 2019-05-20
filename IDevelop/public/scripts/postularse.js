function Postularse(){
	event.preventDefault();
	var formulario = document.forms['formPostular'];
	var id = formulario['id'].value;
	var retorno = Postularse_proyecto(id);
	if(retorno == "1"){
		var mensaje = "Usted se postulo correctamente";
		$("#mensajeModal").html(mensaje);	
	}
}


function Postularse_proyecto(id){
	var retorno;
	$.ajax({
		async:false,
		url: '/IDevelop1/IDevelop/public/Proyecto/Nuevo/Postularse',
		type: 'POST',
		data: {
			"id": id,
		},
		success: function(response){
			if(response=="1"){
				retorno = "1";
			}else{
				retorno ="0";
			}
		}
	});		
	return retorno;
}

const form = document.getElementById('formPostular');
form.addEventListener('submit', Postularse);