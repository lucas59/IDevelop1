	var usuarios = null;

	$(document).ready(function() {
		$.ajax({
			async:false,
			url: '/IDevelop1/IDevelop/public/Usuario/buscar',
			type: 'GET',
			dataType: "json",
			success: function(response){
				usuarios=response;
			}
		});	


	});

	function filtrarBuscador(){
		$('#searchTable tr').remove();
		var form = document.forms['formBuscar'];
		var element = document.getElementById('buscador').value;
		if(element==""){
			return;
		}
		
		for (var i = 0; i < usuarios.length; i++) {
			if(usuarios[i]['apellido']){			
				var nombreYapellido=usuarios[i]['nombre'].toLowerCase() + usuarios[i]['apellido'].toLowerCase();
				var nombre = usuarios[i]['nombre'];
				var apellido = usuarios[i]['apellido'];
			}else{
				var nombreYapellido=usuarios[i]['nombre'].toLowerCase();
				var nombre = usuarios[i]['nombre'];
				var apellido = "";
			}
			var pais=usuarios[i]['pais'].toLowerCase();
			var tabla = document.getElementById('searchTable');
				var tipo;
				if(usuarios[i]['tipo']==0){
					tipo="Desarrollador";
				}else{
					tipo="Empresa";
				}
			if (nombreYapellido.includes(element.toLowerCase()) ||tipo.toLowerCase().includes(element.toLowerCase()) || pais.includes(element.toLowerCase()) ) {
				var row = tabla.insertRow();
				row.id= usuarios[i]['id'];
				var cell1 = row.insertCell(0);
				var nuevaFila = "<a href=/IDevelop1/IDevelop/public/Usuario/Perfil?email="+usuarios[i]['email']+">";
				nuevaFila += mayuscula(nombre) + " " + mayuscula(apellido);
				nuevaFila +=  "</a>";
				nuevaFila += "<br><small>" + tipo + "-" + mayuscula(pais) + "</small><br>";
				cell1.innerHTML = nuevaFila;
			}
		}
		
	}

	function mayuscula(string){//le convierte la primera letra a mayuscula a una cadena
  return string.charAt(0).toUpperCase() + string.slice(1);
}