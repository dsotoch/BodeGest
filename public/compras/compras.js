var table = $('#tabla-compra').DataTable({

    select: true,

    language: {
        "url": "/es.json"
    },
});
var t_prove = $("#tabla-proveedores").DataTable({
    language: { url: '/es.json' }
});
var t_prod = $("#tabla-productos").DataTable({
    language: { url: '/es.json' }
});
codigo_compra();
function codigo_compra() {
    $.ajax({
        method: 'get',
        url: '/Compras/GenerarCodigoCompra',
        data: "",
        dataType: 'json',
        success: function (response) {
            $("#codigo").val(response.codigo);
        }

    });
}

$(document).on('click', "#btn-proveedor", function (e) {
    e.preventDefault();
    t_prove.clear().draw();
    $.ajax({
        method: 'get',
        url: '/Compras/Proveedores',
        data: "",
        dataType: 'json',
        success: function (response) {
            $.each(response, function (index, value) {
                let new_row = [value.id, value.nombre, value.telefono, value.pais, '<button class="btn btn-primary" id="btn-enviar" title="Seleccionar"><i class="fas fa-share"></i></button>'];
                t_prove.row.add(new_row).draw();

            });
        }

    });
});

var id_proveedor_compra = "";
$(document).on('click', "#btn-enviar", function () {
    let row = $(this).closest('tr');
    id_proveedor_compra = $(row.find('td')[0]).text();
    let nombre = $(row.find('td')[1]).text();
    let pais = $(row.find('td')[3]).text();
    $("#proveedor").val(nombre + " " + "/" + pais);
    swal.fire({ title: 'OK', text: nombre + " " + "Agregado", icon: 'success' });
});
$(document).on('click', "#ver-productos", function (e) {
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
    let precioCompra = $(row.find('td')[4]).text();
    let presentacion = $(row.find('td')[2]).text();
    let total = parseInt(stock) * parseFloat(precioCompra);
    let new_row = [id, producto + " " + presentacion, precioCompra, stock, total];
    var indice = $.inArray(id, productos);
    if (indice >= 0) {
        swal.fire({ title: 'Opps.', text: "El Producto ya esta Agregado", icon: 'warning' });

    } else {
        swal.fire({ title: 'OK', text: producto + " " + "Agregado", icon: 'success' });
        table.row.add(new_row).draw();
        productos.push(id);
    }

});
$("#tabla-compra tbody").on('click', 'tr', function () {
    let fila = $(this);
    let producto = $(fila.find('td')[1]).text();
    let id = $(fila.find('td')[0]).text();

    swal.fire({
        title: 'Quitar Producto',
        text: producto,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si, Quitar',
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#C70039'

    }).then((value) => {
        if (value.isConfirmed) {
            let nuevos_productos = $.grep(productos, function (valor) {
                return valor != id;
            });
            productos = nuevos_productos;
            table.row(fila).remove().draw();
        }
    });
});
$(document).on('click', '#registrar-compra', function (e) {
    e.preventDefault();
    let metodo = $("#metodo").val();
    var total = 0.0;
    let fecha = $("#fecha").val();
    let comprobante = $("#comprobante").val();
    let total_compra=$("#total-compra").val();
    $("#tabla-compra tr").each(function () {
        $(this).find('td:last-child').each(function () {
            total += parseFloat($(this).text());
        });

    });
    if (id_proveedor_compra == "") {
        error("Selecciona un Proveedor");
        return;
    }
    if (metodo == "") {
        error("Rellena el Metodo de Pago");

        return;
    }
    if (fecha == "") {
        error("Selecciona una Fecha Valida");

        return;
    }
    if (total_compra == "") {
        error("Rellena el total de la Compra");

        return;
    }
    $("#form-compra").submit();


});

function error(text) {
    swal.fire({
        title: 'Ops',
        text: text,
        icon: 'error'
    });
}