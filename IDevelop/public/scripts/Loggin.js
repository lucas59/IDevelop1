	const urlBase = "/IDevelop1/IDevelop/public";

	function Login(){
		event.preventDefault();
		var formulario = document.forms['formLogin'];
		var email = formulario['Correo'].value;
		var pass = formulario['Contrasena'].value;
		login = loguearse(email,pass);
		console.log(login);
		if(login == true){
			window.location.replace(urlBase);
		}else{
			$('#modalLogin').modal();//
			document.getElementById('textoModal').innerHTML = "Error al intentar iniciar sesión"
		}
	}

	function loguearse(email,pass){
		var retorno;
		event.preventDefault();
		$.ajax({
			async:false,
			url: urlBase+'/Usuario/Logearse',
			type: 'POST',
			data: {
				"email": email,
				"pass": pass,
			},
			success: function(response){
				response=response.trim();
				console.log(response);
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