$(document).ready(function(){
const urlBase = "/IDevelop1/IDevelop/public";

	$.ajax({
		async:false,
		url: urlBase+'/Usuario/Paises',
		type: 'GET',
		dataType: "json",
		success: function(response){
			rellenarSelect(response);
		}
	});	

	$("#idPaises").change(function(){
		var pais = $('#idPaises').val();
		console.log("pais: ", pais);
		$.ajax({
			async:false,
			url: urlBase+'/Usuario/Ciudad/'+pais,
			dataType: "json",
			success: function(response){
				rellenarSelectCiudad(response);
			}
		});	
	}); 	
});

function enviarDatos(){
	event.preventDefault();
	
	var e = document.getElementById("lenguaFav");
	var lenguaje = e.options[e.selectedIndex].value;

	var pais = $('#idPaises').val();
	var email = $('#email').val();
	var ciudad = $('#idCiudad').val();
	var file = document.querySelector('input[type=file]').files[0];
	var fotoPerfil = document.getElementById("fotoPerfil").files[0];
	var datos = new FormData();
	datos.append('fotoPerfil',fotoPerfil);
	datos.append('email',email);
	datos.append('lenguaje',lenguaje);
	datos.append('file',file);
	datos.append('pais',pais);
	datos.append('ciudad',ciudad);
	datos.append('lenguajes',null);
	$.ajax({
		async:false,
		processData: false,
		contentType: false,
		url: urlBase+'/Usuario/Desarrollador/Datos',
		type: 'POST',
		data: datos, 
		success: function(response){
			console.log(response);
			response=response.trim();
			if(response=="1"){
				console.log("llega ok");
				window.location.replace("/IDevelop1/IDevelop/public");
			}else{
				var mensaje = "A ocurrido un problema...Revisa tus datos.";
				$("#mensajeModal").html(mensaje);	
				$("#modalAviso").modal();
				console.log("no llega ok");
			}
		},
		error: function(response){
			console.log("error: " + response);
		}
	});
}

function enviarDatosEmpresa(){
	event.preventDefault();
	console.log("asdasd");
	var pais = $('#idPaises').val();
	var email = $('#email').val();
	var ciudad = $('#idCiudad').val();
	var vision = $('#txtVision').val();
	var mision = $('#txtMision').val();
	var tel = $('#txtTel').val();
	var rubro = $('#txtRubro').val();
	var reclutador = $('#txtReclutador').val();
	var direccion = $('#txtDireccion').val();
	var fotoPerfil = document.getElementById("fotoPerfilEmpresa").files[0];
	var datos = new FormData();

	datos.append('fotoPerfil',fotoPerfil);
	datos.append('email',email);
	datos.append('vision',vision);
	datos.append('mision',mision);
	datos.append('tel',tel);
	datos.append('rubro',rubro);
	datos.append('reclutador',reclutador);
	datos.append('direccion',direccion);
	datos.append('pais',pais);
	datos.append('ciudad',ciudad);
	
	$.ajax({
		async:false,
		processData: false,
		contentType: false,
		url: urlBase+'/Usuario/Empresa/Datos',
		type: 'POST',
		data: datos,
		success: function(response){
			console.log(response);
			response=response.trim();
			if(response=="1"){
				console.log("llega ok");
				window.location.replace(urlBase);
			}else{
				var mensaje = "Revise nuevamente sus datos";
				$("#mensajeModal").html(mensaje);				
				$("#modalAviso").modal();
				console.log("no llega ok");
			}
		},
		error: function(response){
			console.log("error: " + response);
		}
	});
}


function rellenarSelect(arreglo){
	var imprimir = "";
	for (var i=0; i<arreglo.length; i++){
		imprimir += "<option value='"+arreglo[i].id+"'>"+arreglo[i].nombre+"</option>";
	}
	$("#idPaises").html(imprimir);
}

function rellenarSelectCiudad(arreglo){
	var imprimir = "";
	for (var i=0; i<arreglo.length; i++){
		imprimir += "<option value='"+arreglo[i].id+"'>"+arreglo[i].nombre+"</option>";
	}
	$("#idCiudad").html(imprimir);
}

$("#fotoPerfil").change(function () {
	filePreview(this);
});

function filePreview(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#fotoDef').remove();
			$('#foto').after('<img class="img-circle" alt="Cinque Terre" src="'+e.target.result+'" width="120" height="120"/>');
		}
		reader.readAsDataURL(input.files[0]);
	}
}




const form = document.getElementById('formDatosDesarrollador');
if(form){
	form.addEventListener('submit', enviarDatos);
}

const form1 = document.getElementById('formDatosEmpresa');
if(form1){
	form1.addEventListener('submit', enviarDatosEmpresa);
}


