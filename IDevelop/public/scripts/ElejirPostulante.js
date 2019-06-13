function ElejirPostulante(){
	event.preventDefault();
	var formulario = document.forms['elegirForm'];
	var email = formulario['email'].value;
	var idproyecto = formulario['idProyecto'].value;
	console.log(idproyecto);
	console.log(email);
	//var idEmpresa = formulario['idEmpresa'].value;
	$.ajax({
		async:false,
		url: '/IDevelop1/IDevelop/public/Usuario/ElejirPostulante',
		type: 'POST',
		data: {
			"email": email,
			"idproyecto": idproyecto
		},
		success: function(response){
			response = response.trim();
			console.log(response);
			if(response=="1"){
				alert("Contratado con exito");
				window.location.href="/IDevelop1/IDevelop/public/Proyecto/"+idproyecto;
				//redirigir(idEmpresa);
			}else{
				window.location.href="/IDevelop1/IDevelop/public";
			}
		}
	});	
}
const form = document.getElementById('elegirForm');
form.addEventListener('submit', ElejirPostulante);