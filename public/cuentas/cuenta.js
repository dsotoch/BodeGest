
$.ajax({
    type: "get",
    url: "/Webhook/movimientos",
    data: "",
    dataType: "json",
    success: function (response) {
        $("#su_id").text(response["id"]);
        $("#su_nu").text(response["suscripcion_id"]);
        $("#su_cg").text(response["cantidad_cargo_predeterminada"]);
        let estado = response["estado"] == "ESPERANDO" ? "INACTIVO" :  response["estado"];
        $("#su_es").text(estado);
        if (estado == "INACTIVO") {
            $("#btn-cancelar").prop('disabled', true);
            $("#fin_sus").text(response["fecha"]);
            $("#cancel-sus").prop('hidden', false);
        }

    }
});
$.ajax({
    type: "get",
    url: "/Webhook/pagos",
    data: "",
    dataType: "json",
    success: function (response) {
        if (response) {
            // Verifica si response.estado es verdadero (true) o falso (false)
            response.forEach(element => {

                // Construye la fila de la tabla con los datos de la respuesta
                var newRow = "<tr><td>" + element.estado + "</td><td>" + element.suscripcion_id + "</td><td>" + element.monto + "</td><td>" + element.periodo + "</td><td>" + element.fechaCargo + "</td></tr>";

                // Agrega la nueva fila a la tabla
                $("#tb-pag").append(newRow);
            });
        }


    }

});


$(document).on('click', "#btn-cancelar", function () {
    var csrf_token = $("#form-cancel meta[name='csrf-token']").attr('content');
    $.ajax({
        type: "GET",
        url: "/Webhook/cancel",
        data: {
            _token: csrf_token, // Incluye el token CSRF en la solicitud
        },
        dataType: "json",
        success: function (response) {
            if (response.fecha) {
                Swal.fire(
                    'Confirmación',
                    'Lamentamos que te Vayas... Subscripción Cancelada Correctamente! Tu Suscripción termina el ' + response.fecha,
                    'success'
                ).then(function () {
                    $("#btn-cancelar").prop('disabled', true);
                    $("#fin_sus").text(response.fecha);
                    $("#cancel-sus").prop('hidden', false);
                    $("#su_es").text("INACTIVO");
                    $("#btn-reanudar").prop("hidden",false);

                });
            } else {
                Swal.fire(
                    'ERROR!',
                    'Hubo Un Error, Comunicate con Soporte para Cancelar tu Suscripción!' + response,
                    'error'
                )
            }
        }
    });
});