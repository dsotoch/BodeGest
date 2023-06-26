const table_15 = $("#tabla-mayores15").DataTable({
    language: {
        "url": "/es.json"
    },
});
const table_100 = $("#tabla-mayores100").DataTable({
    language: {
        "url": "/es.json"
    },
});
const table_all = $("#tabla-todos").DataTable({
    language: {
        "url": "/es.json"
    },
});
const table_saldos = $("#tabla-saldos").DataTable({
    language: {
        "url": "/es.json"
    },
});
$('.contenido[data-filter="grafico"]').show();
$('a[data-filter]').click(function (e) {
    e.preventDefault(); // Evita que el enlace realice su acción predeterminada
    var filtro = $(this).data('filter');
    $('.contenido').hide(); // Oculta todo el contenido
    $('.contenido[data-filter="' + filtro + '"]').show(); // Muestra el contenido correspondiente al filtro seleccionado

});
$(document).on('click', '#detalles', function () {
    let row = $(this).closest('tr');
    let datos = $(row.find('td')[0]).text();
    let datos_parseado = datos.split('-');
    let dni = datos_parseado[0];
    let cliente = datos_parseado[1];
    $(".alert").empty();
    $("#tabla-detalles tbody tr").remove();
    $("#tabla-detalles tfoot tr").remove();
    $.ajax({
        type: "get",
        url: "/Cuentas/Show/" + dni,
        data: "",
        dataType: "json",
        success: function (response) {

            $("#staticBackdropLabel").text("Detalles de la Cuenta del Cliente " + " " + cliente);
            $("#dni").val(dni);

            $.each(response, function (index, venta) {
                let articulos_html = '';

                $.each(venta.articulos, function (index, articulo) {
                    let descripcion = articulo.descripcion;
                    articulos_html += '<ul> <li>' + articulo.pivot.cantidad + '-' + descripcion + ' ' + articulo.marca + ' ' + articulo.presentacion + ' ' + articulo.medida + '/ Costo:' + ' ' + articulo.precioVenta + '</li></ul>';

                });

                var new_row = '<tr><td>' + venta.fecha + '</td><td>' + articulos_html + '</td><td class="inicial">' + venta.montoInicio + '</td><td>' + parseFloat(venta.igv).toFixed(2) + '</td><td class="total">' + venta.total + '</td></tr>';
                $('#tabla-detalles').append(new_row);

            });
            let total = 0.0;
            let inicial = 0.0;
            $("#tabla-detalles td.total").each(function () {
                let ultima_Celda = $(this).text().trim();
                let valor_numerico = parseFloat(ultima_Celda);
                total += valor_numerico;
            });
            $("#tabla-detalles td.inicial").each(function () {
                let ultima_Celda = $(this).text().trim();
                let valor_numerico = parseFloat(ultima_Celda);
                if (!isNaN(valor_numerico)) {
                    inicial += valor_numerico;

                }
            });
            $('#detalles-foot').text("Total de la Deuda" + " " + (total - inicial).toFixed(2));


        }
    });
});
$(document).on('click', '.btn-comprobante', function (e) {
    e.preventDefault();
    let cliente = $("#dni").val();

    html2canvas($("#cuenta")[0]).then(function (canva) {
        let imagen = canva.toDataURL('image/png');
        let enlace = document.createElement('a');
        enlace.download = cliente + '/Comprobante.png';
        enlace.href = imagen;
        enlace.addEventListener('click', function () {
            document.body.removeChild(enlace);
        });
        document.body.appendChild(enlace);
        enlace.click();



    });
    confirmacion("Comprobante Generado Correctamente, Revisa Tus Descargas");
});
$('#form').on('keypress', function (event) {
    if (event.which === 13) {
        event.preventDefault();
    }
});
$('.btn-enviar-email').on('click', function (event) {
    event.preventDefault();
    html2canvas($("#cuenta")[0]).then(function (canvas) {
        let imagenbase64 = canvas.toDataURL('image/png');
        $("#imagen").val(imagenbase64);

        $('#form').submit();

    });
});
var objeto_pago = {};

$(document).on('click', '#pagar-cuenta', function () {
    let row = $(this).closest('tr');
    let datos = $(row.find('td')[0]).text();
    let monto_venta = $(row.find('td')[2]).text();
    let datos_parseado = datos.split('-');
    let dni = datos_parseado[0];
    let cliente = datos_parseado[1];
    $("#staticBackdropLabel2").text(cliente + " " + "monto a Cancelar :" + " " + monto_venta);
    $("#dni2").val(dni);
    $("#total-pagar").val(monto_venta);
    objeto_pago = { 'dni': dni, 'cliente': cliente, 'monto_deuda': monto_venta };
    $("#monto-dado").prop('disabled', false);
    $(".btn-pagar").show();
    $(".btn-pagar-saldos").hide();

});
$(document).on('click', '.btn-pagar', function () {
    let monto_deuda = parseFloat($("#total-pagar").val());
    let monto_recibido = parseFloat($("#monto-dado").val());
    let fecha = $("#fecha").val();
    if (fecha == "") {
        error("Ingrese Una Fecha Valida");
        return false;
    }
    if (monto_recibido == 0 || isNaN(monto_recibido)) {
        error("Completa los Campos con un Monto Valido");
        return false;
    }
    if (monto_recibido < monto_deuda) {
        let resultado = monto_deuda - monto_recibido;
        objeto_pago.monto_recibido = monto_recibido.toFixed(2);

        objeto_pago.monto_restante = resultado.toFixed(2);
        objeto_pago.fecha = fecha;

        $.ajax({
            type: "get",
            url: "/Cuentas/GuardarRestante",
            data: objeto_pago,
            dataType: "json",
            success: function (response) {
                swal.fire({
                    title: "Cuenta Cancelada del Cliente :" + " " + response.dni + "-" + response.cliente,
                    text: "Queda un Saldo de  :" + " " + resultado.toFixed(2),
                    confirmButtonText: 'De Acuerdo',

                }).then(function (value) {
                    window.location.reload();
                });

            }
        });
    } else {
        let dni = $("#dni2").val();
        $.ajax({
            type: "get",
            url: "/Cuentas/CancelarDeuda/" + dni,
            data: "",
            dataType: "json",
            success: function (response) {

                swal.fire({
                    title: 'Confirmación',
                    text: "Cuenta Cancelada del Cliente :" + " " + response.dni + "-" + response.cliente,
                    confirmButtonText: 'De Acuerdo',

                }).then(function (value) {
                    window.location.reload();
                });

            }
        });

    }

});
$(document).on('click', '#pagar-cuenta-saldos', function () {
    let row = $(this).closest('tr');
    let datos = $(row.find('td')[0]).text();
    let monto_venta = $(row.find('td')[4]).text();
    let datos_parseado = datos.split('-');
    let dni = datos_parseado[0];
    let cliente = datos_parseado[1];
    $("#staticBackdropLabel2").text(cliente + " " + "monto a Cancelar :" + " " + monto_venta);
    $("#dni2").val(dni);
    $("#total-pagar").val(monto_venta);
    objeto_pago = { 'dni': dni, 'cliente': cliente, 'monto_deuda': monto_venta };
    $("#monto-dado").val(monto_venta);
    $("#monto-dado").prop('disabled', true);
    $(".btn-pagar").hide();
    $(".btn-pagar-saldos").show();


});
$(document).on('click', '.btn-pagar-saldos', function () {
    let monto_deuda = parseFloat($("#total-pagar").val());
    let monto_recibido = parseFloat($("#monto-dado").val());
    let dni=$("#dni2").val();
    let fecha = $("#fecha").val();
    if (fecha == "") {
        error("Ingrese Una Fecha Valida");
        return false;
    }
    $.ajax({
        type: "get",
        url: "/Cuentas/CancelarSaldo/"+dni,
        data: {fecha:fecha,recibido:recibido},
        dataType: "json",
        success: function (response) {
            swal.fire({
                title: "Cuenta Cancelada del Cliente :" + " " + response.dni + "-" + response.cliente,
                text: "Fecha de Pago :" + " " + fecha,
                confirmButtonText: 'De Acuerdo',

            }).then(function (value) {
                window.location.reload();
            });

        }
    });


});
function error(texto) {
    swal.fire({
        title: 'Ops',
        text: texto,
        icon: 'error',
        confirmButtonText: 'De Acuerdo'
    });
}

function confirmacion(texto) {
    swal.fire({
        title: 'Correcto',
        text: texto,
        icon: 'success',
        confirmButtonText: 'De Acuerdo'
    });
}