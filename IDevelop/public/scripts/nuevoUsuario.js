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

	console.log(tipo);
	
	var existe = validarEmail(email);
	if(existe == "1"){
		var mensaje = "Usuario ya registrado en IDevelop";
		$("#mensajeModal").html(mensaje);				
		$("#modalAviso").modal();

		console.log("El usuario ya existe");
	}else{
		console.log("el usuario no existe");
		var token = makeid(10);
		intento=ingresarUsuario(email,nombre,apellido,contraseña,fecha,sexo,tipo,token);
		console.log("intento:" +intento);
		if(intento==true){
			console.log("ingresado");
			var intentoValidacion = enviarValidacion(email,nombre,apellido,token);
			var mensaje = "Usuario registrado con exito, se a enviado el enlace activador a su correo electronico.";
			$("#mensajeModal").html(mensaje);				
			$("#modalAviso").modal();
			
		}else{
			var mensaje = "Hubo un problema al registrar el nuevo usuario en IDevelop";
			$("#mensajeModal").html(mensaje);				
			$("#modalAviso").modal();

			console.log("No ingresado")
		}
	}
	
}
function makeid(length) {
	var result = '';
	var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	var charactersLength = characters.length;
	for ( var i = 0; i < length; i++ ) {
		result += characters.charAt(Math.floor(Math.random() * charactersLength));
	}
	return result;
}

function enviarValidacion(email,nombre,apellido,token){
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


function ingresarUsuario(email,nombre,apellido,contraseña,fecha,sexo,tipo,token){
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
			"token": token,
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
	return retorno;
}

function validarEmail(email){
	var retorno;
	$.ajax({
		async:false,
		url: '/IDevelop1/IDevelop/public/Usuario/validarCorreo/'+email,
		//data:{"email":email},
		success: function(response){
			response = response.trim();
			console.log("email:" + response);
			retorno = response;
			
		}
	});
	return retorno;
}


const form = document.getElementById('formAlta');
form.addEventListener('submit', nuevoUsuario);