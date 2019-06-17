function desactivarUsuario(){
	var email =	$("#emailDesarrollador").val();
	
	$.ajax({
		url: '/IDevelop1/IDevelop/public/Usuario/Desactivar/'+email,
		success: function(response){
			console.log(response);
			window.location.href="/IDevelop1/IDevelop/public/Usuario/cerrar";
		},
		error: function(response){
			console.log("error: " + response);
		}
	});	

}

function descargarPDF(){

	var datos =	$("#curriculo").val();
	console.log(datos);

	var pdf = 'data:application/octet-stream;base64,' + datos;

	var dlnk = document.getElementById('descarga');
    dlnk.href = pdf;

    dlnk.click();

}

$("#btn_desactivar").on("click", function(){
    $("#mi-modal").modal('show');
  });

 $("#btn_cerrar").on("click", function(){
    $("#mi-modal").modal('hide');
});