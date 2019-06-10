function VerPerfil(){
	event.preventDefault();
	var formulario = document.forms['formPostulantes'];
	var email = formulario['email'].value;
	var idproyecto = formulario['idproyecto'].value;
	var idEmpresa = formulario['emailE'].value;
    window.location.href="/IDevelop1/IDevelop/public/Usuario/Perfil?email="+email+"&idproyecto="+idproyecto+"&idEmpresa="+idEmpresa;
}
const form = document.getElementById('formPostulantes');
form.addEventListener('submit', VerPerfil);
