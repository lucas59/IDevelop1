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
		success: function(response){
			
			return response;
		},
		error: function(response){
			alert(response);
			
		}
	});

}

const form = document.getElementById('formAlta');
form.addEventListener('submit', nuevoUsuario);