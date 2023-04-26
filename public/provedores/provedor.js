
var table = $('#tabla-provedores').DataTable({
    dom: 'lBfrtip',
    select: true,

    language: {
        "url": "/es.json"
    },
    buttons: [
        'excel', 'pdf'
    ]


});


$(document).on('click','.btn-detalles', function () {
    let row = $(this).closest('tr');
    let id_provedor = row.find('td').eq(0).text().trim();
    $.ajax({
        url: '/Provedores/Detalle-Provedor/' + id_provedor,
        method: 'get',
        data: "",
        dataType: 'json',
        success: function (response) {

            $("p#detalle-nombres").text(response.nombre);
            $("p#detalle-servicio").text(response.servicio);
            $("p#detalle-direccion").text(response.direccion);
            $("p#detalle-telefono").text(response.telefono);
            $("p#detalle-pais").text(response.pais);
            $("p#detalle-email").text(response.correo);

        }
    });

});
var fila_editar = "";
$(document).on('click','.btn-editar', function () {
    fila_editar = $(this).closest('tr');
    let id_provedor = $(fila_editar.find('td')[0]).text().trim();
    $.ajax({
        url: '/Provedores/Detalle-Provedor/' + id_provedor,
        method: 'get',
        data: "",
        dataType: 'json',
        success: function (response) {
            $("#editar-codigo").val(response.id);
            $("#editar-nombre").val(response.nombre);
            $("#editar-servicio").val(response.servicio);
            $("#editar-direccion").val(response.direccion);
            $("#editar-telefono").val(response.telefono);
            $("#editar-pais").val(response.pais);
            $("#editar-email").val(response.correo);

        }
    });


});
$("#btn-editar-provedor").on('click', function (e) {
    e.preventDefault();
    let nombre = $("#editar-nombre").val();
    let telefono = $("#editar-telefono").val();
    let direccion = $("#editar-direccion").val();
    let email = $("#editar-email").val();
    let pais = $("#editar-pais").val();
    let servicio = $("#editar-servicio").val();
    let token = $("#form-editar input[name='_token']").val();
    let id_provedor_modificar = $("#editar-codigo").val();

    if (nombre == "" || telefono == "" || direccion == "" || email == "" || servicio == "" || pais == "") {
        error("Por Favor Completa todos los Campos");
    } else {
        let datos = {
            nombre: nombre,
            telefono: telefono,
            direccion: direccion,
            email: email,
            pais: pais,
            servicio: servicio,
            _token: token,

        }
        $.ajax({
            url: '/Provedores/Modificar-Provedor/' + id_provedor_modificar,
            method: 'get',
            data: datos,
            dataType: 'json',
            success: function (response) {
                table.cell(fila_editar, 1).data(response.nombre).draw();
                table.cell(fila_editar, 2).data(response.telefono).draw();
                table.cell(fila_editar, 3).data(response.pais).draw();
                confirmacion("Provedor Modificado Correctamente");

            }
        });

    }
});

$(document).on('click','.btn-eliminar', function () {
    let fila_eliminar = $(this).closest('tr');
    let id_provedor_eliminar = $(fila_eliminar.find('td')[0]).text();
    swal.fire({
        title: 'Warning',
        text: "Esta acción no se puede deshacer.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, borrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/Provedores/Eliminar-Provedor/' + id_provedor_eliminar,
                method: 'get',
                data: "",
                dataType: 'json',
                success: function (response) {
                    table.row(fila_eliminar).remove().draw();
                    confirmacion("Proveedor Eliminado Correctamente");

                }
            });
        }
    });


});
$("#btn-agregar").on('click', function () {
    $.ajax({
        url: '/Provedores/Generar-Codigo',
        method: 'get',
        data: "",
        dataType: 'json',
        success: function (response) {
            $("#codigo").val(parseInt(response.codigo) + 1);
        }
    });


});

$("#save-provedor").on('click', function (e) {

    e.preventDefault();
    let nombre = $("#nombre").val();
    let telefono = $("#telefono").val();
    let direccion = $("#direccion").val();
    let email = $("#correo").val();
    let pais = $("#pais").val();
    let servicio = $("#servicio").val();

    if (nombre == "" || telefono == "" || direccion == "" || email == "" || servicio == "" || pais == "") {
        error("Por Favor Completa todos los Campos");
    } else {
        let datos = {
            nombre: nombre,
            telefono: telefono,
            direccion: direccion,
            email: email,
            pais: pais,
            servicio: servicio
        }

        $.ajax({
            url: '/Provedores/Registrar-Provedor',
            method: 'get',
            data: datos,
            dataType: 'json',
            success: function (response) {
                let new_row = [response.id, response.nombre, response.telefono, response.pais, '<div class="row" id="div-opciones"><button title="Editar" class="btn-warning btn-editar" data-bs-toggle="modal" data-bs-target="#modal-editar-provedor"> <i class="fas fa-edit"></i> </button><button title="Eliminar" class="btn-danger btn-eliminar"> <i class="fas fa-trash"></i> </button><button title="Detalles" class="btn-primary btn-detalles" data-bs-toggle="modal" data-bs-target="#mymodal"> <i class="fas fa-eye"></i> </button></div>'];
                table.row.add(new_row).draw();
                confirmacion("Provedor Registrado Correctamente");
            }
        });
    }
});



function confirmacion(text) {
    swal.fire({
        title: 'Confirmacion',
        text: text,
        icon: 'success'
    });
}

function error(text) {
    swal.fire({
        title: 'Ocurrio Un Problema',
        text: text,
        icon: 'error',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Aceptar',
    });
}