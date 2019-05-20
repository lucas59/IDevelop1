function Postularse(){
	event.preventDefault();
	var formulario = document.forms['formPostular'];
	var id = formulario['id'].value;



}


function Postularse_pryecto(id){
	var retorno;
	$.ajax({
		async:false,
		url: '/IDevelop1/IDevelop/public/Usuario/Validacion/Enviar',
		type: 'POST',
		data: {
			"email": email,
			"nombre": nombre,
			"apellido": apellido,
			"token": token,
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