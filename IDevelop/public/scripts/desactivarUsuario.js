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

$("#btn_desactivar").on("click", function(){
    $("#mi-modal").modal('show');
  });

 $("#btn_cerrar").on("click", function(){
    $("#mi-modal").modal('hide');
  });