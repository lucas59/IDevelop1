	const urlBase = "/IDevelop1/IDevelop/public";

	function desactivarUsuario(){
		var email =	$("#emailDesarrollador").val();

		$.ajax({
			url: urlBase+'/Usuario/Desactivar/'+email,
			success: function(response){
				console.log(response);
				window.location.href=urlBase+"/Usuario/cerrar";
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