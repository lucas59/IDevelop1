function nuevoUsuario(){
	event.preventDefault();
	var formulario = document.forms['formAlta'];
	var email = formulario['txtID'].value;
	var nombre = formulario['txtNombre'].value;
	var apellido = formulario['txtApellido'].value;
	var contraseña = formulario['txtPass'].value;
	var fecha = formulario['fecha'].value;
	var sexo = document.querySelector('input[name="sexo"]:checked').value;
	var tipo = document.querySelector('input[name="tipo"]:checked').value;
	
	//alert(email);
	var existe = validarEmail(email);
	if(existe == true){
		console.log("El usuario ya existe");
	}else{
		intento=ingresarUsuario(email,nombre,apellido,contraseña,fecha,sexo,tipo);
		console.log("intento : " + intento);
		if(intento==true){
			console.log("ingresado");
		}else{
			console.log("No ingresado")
		}
	}
	
}


function ingresarUsuario(email,nombre,apellido,contraseña,fecha,sexo,tipo){
	var retorno;
	$.ajax({
		async:false,
		url: '/IDevelop1/IDevelop/public/Usuario/NuevoUsuario',
		type: 'POST',
		data: {
			"email": email,
			"nombre": nombre,
			"apellido": apellido,
			"contraseña": contraseña,
			"fecha": fecha,
			"sexo": sexo,
			"tipo": tipo,
		},
		success: function(response){
			console.log("asd: "+response);
			if(response=="1"){
				retorno = true;
			}else{
				retorno =false;
			}
		},
		error: function(response){
			console.log(response);
		}
	});		
	return retorno;
}

function validarEmail(email){
	var retorno;
	$.ajax({
		async:false,
		url: '/IDevelop1/IDevelop/public/Usuario/validarCorreo/'+email,
		success: function(response){
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