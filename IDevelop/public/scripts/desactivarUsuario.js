function desactivarUsuario() {
    var email = $("#emailDesarrollador").val();

    $.ajax({
        url: '/IDevelop1/IDevelop/public/Usuario/Desactivar/' + email,
        success: function(response) {
            console.log(response);
            window.location.href = "/IDevelop1/IDevelop/public/Usuario/cerrar";
        },
        error: function(response) {
            console.log("error: " + response);
        }
    });

}

function descargarPDF() {

    var datos = $("#curriculo").val();
    console.log(datos);

    var pdf = 'data:application/octet-stream;base64,' + datos;

    var dlnk = document.getElementById('descarga');
    dlnk.href = pdf;

    dlnk.click();

}
$("#fotoPerfil").change(function() {
    filePreview(this);
});

function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#fotoActual').remove();
            $("#contenedorFoto").append('<div id="fotoActual" class="col-lg-6"><img id="imgen_perfil" src="' + e.target.result + '" width="120" height="120"/></div>');
            //$('#foto').after('<img id="imgen_perfil" class="img-circle" alt="Cinque Terre" src="'+e.target.result+'" width="120" height="120"/>');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function actualizarPerfil() {
    var email = $("#emailD").val();
    console.log(email);
    var nombre = $('#txtNombre').val();
    var apellido = $('#txtApellido').val();
    var e = document.getElementById("lenguaFav");
    var lenguaje = e.options[e.selectedIndex].value;
    if (nombre == "" || apellido == "") {
        return;
    }
    var file = document.getElementById("curriculum").files[0];
    var fotoPerfil = document.getElementById("fotoPerfil").files[0];
    var datos = new FormData();
    datos.append('email', email);
    datos.append('curriculo', file);
    datos.append('fotoPerfil', fotoPerfil);
    datos.append('lenguaje', lenguaje);
    datos.append('nombre', nombre);
    datos.append('apellido', apellido);

    $.ajax({
        async: false,
        processData: false,
        contentType: false,
        url: urlBase + '/Usuario/Desarrollador/DatosEditar',
        type: 'POST',
        data: datos,
        success: function(response) {
            response = response.trim();
            if (response == "1") {
                window.location.replace("/IDevelop1/IDevelop/public/Usuario/Perfil");
            } else {
                alert("Error");
            }
        },
        error: function(response) {
            console.log("error: " + response);
        }
    });
}


function actualizarPerfilEmpresa() {
    var email = $("#emailD").val();
    console.log(email);
    var nombre = $('#txtNombre').val();
    var rubro = $('#txtRubro').val();
    var mision = $('#txtMision').val();
    var vision = $('#txtVision').val();
    var reclutador = $('#txtReclutador').val();
    var direccion = $('#txtDireccion').val();
    var tel = $('#txtTel').val();
    
    if (nombre == "" || email == "") {
        return;
    }

    var fotoPerfil = document.getElementById("fotoPerfil").files[0];
    var datos = new FormData();
    datos.append('email', email);
    datos.append('nombre', nombre);
    datos.append('rubro', rubro);
    datos.append('mision', mision);
    datos.append('vision',vision);
    datos.append('reclutador', reclutador);
    datos.append('direccion',direccion);
    datos.append('tel', tel);
    datos.append('fotoPerfil', fotoPerfil);
    $.ajax({
        async: false,
        processData: false,
        contentType: false,
        url: urlBase + '/Usuario/Empresa/DatosEditar',
        type: 'POST',
        data: datos,
        success: function(response) {
            console.log(response);
            response = response.trim();
            if (response == "1") {
                window.location.replace("/IDevelop1/IDevelop/public/Usuario/PerfilE");
            } else {
                alert("Error");
            }
        },
        error: function(response) {
            console.log("error: " + response);
        }
    });


}


function editarUsuario() {
    $("#modalEditar").modal('show');
}
function editarEmpresa() {
    $("#modalEditar").modal('show');
}
$("#btn_desactivar").on("click", function() {
    $("#mi-modal").modal('show');
});

$("#btn_cerrar").on("click", function() {
    $("#mi-modal").modal('hide');
});