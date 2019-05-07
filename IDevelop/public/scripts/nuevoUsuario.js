function nuevoUsuario(){
	event.preventDefault();
	alert("asd");
	var formulario = document.forms['formAlta'];
	var email = formulario['txtID'].value;
	var nombre = formulario['txtNombre'].value;
	var apellido = formulario['txtApellido'].value;
	var contraseña = formulario['txtPass'].value;
	var fecha = formulario['fecha'].value;
	//alert(email);
	if(validarEmail(email)){
		alert("sisisi");

	}

}

function validarEmail(email){
	var retorno = false;
	$.ajax({
		url: '/IDevelop1/IDevelop/public/Usuario/validarCorreo/'+email,
		//data:{"email":email},
		success: function(response){
			console.log(response);			
			retorno =  response;
		},
		error: function(response){
			alert(response);
			console.log(response);
		}
	});
	return retorno;

}

const form = document.getElementById('formAlta');
form.addEventListener('submit', nuevoUsuario);