function nuevoUsuario(){
	event.preventDefault();
	var formulario = document.forms['formAlta'];
	var email = formulario['txtID'].value;
	var nombre = formulario['txtNombre'].value;
	var apellido = formulario['txtApellido'].value;
	var contraseña = formulario['txtPass'].value;
	var fecha = formulario['fecha'].value;
	//alert(email);
	var existe = validarEmail(email);
	console.log(existe);
	if(existe == true){
		console.log("El usuario ya existe");
	}else{
	}

}

function validarEmail(email){
	var retorno;
	$.ajax({
		async:false,
		url: '/IDevelop1/IDevelop/public/Usuario/validarCorreo/'+email,
		//data:{"email":email},
		success: function(response){
			console.log(response);
			if(response == true){
				console.log(":)");
				retorno =true;
			}else{
				console.log(":(");			
				retorno =false;
			}		
		}
	});
	return retorno;
}

const form = document.getElementById('formAlta');
form.addEventListener('submit', nuevoUsuario);