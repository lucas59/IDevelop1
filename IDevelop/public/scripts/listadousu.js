	const urlBase = "/IDevelop1/IDevelop/public";

	function Perfil(){
		window.location.replace(urlBase);
	}

	const a =document.getElementById('verperfil');
	a.addEventListener('submit', Perfil);