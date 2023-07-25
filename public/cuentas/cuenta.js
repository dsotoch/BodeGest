$.ajax({
    type: "get",
    url: "/Webhook/movimientos",
    data: "",
    dataType: "json",
    success: function (response) {
        $("#tb-movi").append("<tr><td>" + response.estado + "</td><td>" + response.suscripcion_id + "</td><td>" + response.cantidad_cargo_predeterminada + "</td><td>" + response.numero_periodo_actual + "</td><td>" + response.fecha_fin_periodo + "</td> </tr>");

    }
});

$(document).on('click', "#btn-cancelar", function () {
    $("#btn-cancelar").prop('disabled',true);
    $.ajax({
        type: "get",
        url: "/Webhook/cancel",
        data: "",
        dataType: "json",
        success: function (response) {
            if (response == true) {
                Swal.fire(
                    'Confirmación',
                    'Lamentamos que te Vayas... Subscripción Cancelada Correctamente!',
                    'success'
                ).then(function () {
                        window.location.href="/";
                });
            } else {
                Swal.fire(
                    'ERROR!',
                    'Hubo Un Error, Comunicate con Soporte para Cancelar tu Suscripción!'+ response,
                    'error'
                )
            }
        }
    });
});