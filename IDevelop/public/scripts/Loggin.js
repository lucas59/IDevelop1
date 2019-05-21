function Login(){
	event.preventDefault();
	var formulario = document.forms['formLogin'];
	var email = formulario['Correo'].value;
	var pass = formulario['Contrasena'].value;
	login = loguearse(email,pass);
	if(login == true){
		alert("Sesion iniciada");
		window.location.replace("/IDevelop1/IDevelop/public");
	}else{
		alert("Error al intentar iniciar sesion");
	}
}

function loguearse(email,pass){
	var retorno;
	event.preventDefault();
	$.ajax({
		async:false,
		url: '/IDevelop1/IDevelop/public/Usuario/Logearse',
		type: 'POST',
		data: {
			"email": email,
			"pass": pass,
		},
		success: function(response){
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

const form = document.getElementById('formLogin');
form.addEventListener('submit', Login);