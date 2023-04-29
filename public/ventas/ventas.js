var table = $("#tabla-ventas").DataTable({
    language: {
        "url": "/es.json"
    },
});
var t_prod = $("#tabla-productos").DataTable({
    language: {
        "url": "/es.json"
    },
});
$(document).on('click', "#btn-productos", function (e) {
    e.preventDefault();
    t_prod.clear().draw();
    $.ajax({
        method: 'get',
        url: '/Compras/Productos',
        data: "",
        dataType: 'json',
        success: function (response) {
            $.each(response, function (index, value) {
                let new_row = [value.id, value.descripcion + " " + value.marca, value.presentacion + " " + value.medida, value.stock, value.precioCompra, value.precioVenta, '<button class="btn btn-primary" id="btn-enviar-producto" title="Seleccionar"><i class="fas fa-share"></i></button>'];
                t_prod.row.add(new_row).draw();

            });
        }

    });
});
var productos = [];
$(document).on('click', "#btn-enviar-producto", function () {
    let row = $(this).closest('tr');
    let id = $(row.find('td')[0]).text();
    let producto = $(row.find('td')[1]).text();
    let stock = $(row.find('td')[3]).text();
    let precioVenta = $(row.find('td')[5]).text();
    let presentacion = $(row.find('td')[2]).text();

    if ($("#cantidad").val() == "" || $("#cantidad").val() <= 0) {
        $("#cantidad").focus();
        swal.fire({ title: 'Opps.', text: "Ingresa una Cantidad Valida y luego Selecciona el Producto", icon: 'warning' });

    } else {
        var indice = $.inArray(id, productos);
        if (indice >= 0) {

            swal.fire({ title: 'Opps.', text: "El Producto ya esta Agregado", icon: 'warning' });

        } else {
            let total = parseFloat($("#cantidad").val()) * parseFloat(precioVenta);

            let new_row = [id, producto + " " + presentacion, precioVenta, $("#cantidad").val(), total, '<button class="btn btn-danger" id="btn-eliminar"> <i class="fas fa-trash"></i> </button>  '];

            swal.fire({ title: 'OK', text: producto + " " + "Agregado", icon: 'success' });
            table.row.add(new_row).draw();
            productos.push(id);
            calcularMontoVenta();
        }
    }



});




function calcularMontoVenta() {
    let total = 0.0;
    let igv = $("#iva option:selected").val();
    let can_ig = 0.0;
    if (igv == "si") {
        can_ig = parseFloat($("#igv").val()) / 100;
    }
    $("#tabla-ventas tr").each(function () {
        $(this).find('td:nth-last-child(2)').each(function () {
            total += parseFloat($(this).text());
        });

    });

    let subt = can_ig * total;
    $("#t-pagar").val(total + subt);
    $("#p-igv").val(can_ig);
    $("#p-subtotal").val(total);
    $("#p-total").val(total + subt);

}