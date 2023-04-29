
var unidad_de_medida = "";
var cantidad_de_articulos = "";
var costo_total_del_articulo = "";
$("#btn-precio-minorista").hide();

var table = $('#tabla-productos').DataTable({
    dom: 'lBfrtip',
    select: true,

    language: {
        "url": "/es.json"
    },
    buttons: [
        'excel', 'pdf'
    ]


});

$(document).on('click', '#btn-calcular', function () {
    unidad_de_medida = $("#unidad_medida option:selected").val();
    cantidad_de_articulos = parseFloat($("#cantidad_articulos").val());
    costo_total_del_articulo = parseFloat($("#costo_articulo").val());
    if (cantidad_de_articulos == "" || cantidad_de_articulos == 0.0 || cantidad_de_articulos == 0 || isNaN(cantidad_de_articulos) || costo_total_del_articulo == "" || costo_total_del_articulo == 0.0 || costo_total_del_articulo == 0 || isNaN(costo_total_del_articulo)) {
        Swal.fire({
            title: 'ERROR',
            text: 'Ingrese Datos Validos',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    } else {
        Swal.fire({
            title: 'Ingresa el Porcentaje de ganancia',
            input: 'number',
            inputLabel: 'Ganancia',
            inputPlaceholder: 'Ingresa cuanto % quieres ganar',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            inputValidator: (value) => {
                if (!value) {
                    return 'Debes ingresar el Porcentaje de ganancia';
                } else {
                    if (value <= 0) {
                        return 'Ingrese un Porcentaje Valido';

                    }
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const ganancia = result.value / 100;
                let precio_venta = 0.0;
                let cantidad_ganancia = 0.0;
                let precio_compra = 0.0;
                switch (unidad_de_medida) {
                    case 'unidad':
                        cantidad_ganancia = costo_total_del_articulo / cantidad_de_articulos * ganancia;
                        precio_venta = costo_total_del_articulo / cantidad_de_articulos + cantidad_ganancia;
                        precio_compra = costo_total_del_articulo / cantidad_de_articulos;

                        break;
                    case 'litro':
                        cantidad_ganancia = costo_total_del_articulo / cantidad_de_articulos * ganancia;
                        precio_venta = costo_total_del_articulo / cantidad_de_articulos + cantidad_ganancia;
                        precio_compra = costo_total_del_articulo / cantidad_de_articulos;

                        break;
                    case 'kilogramo':
                        cantidad_ganancia = costo_total_del_articulo / cantidad_de_articulos * ganancia;
                        precio_venta = costo_total_del_articulo / cantidad_de_articulos + cantidad_ganancia;
                        precio_compra = costo_total_del_articulo / cantidad_de_articulos;

                        break;

                    default:
                        cantidad_ganancia = costo_total_del_articulo / cantidad_de_articulos * ganancia;
                        precio_venta = costo_total_del_articulo / cantidad_de_articulos + cantidad_ganancia
                        precio_compra = costo_total_del_articulo / cantidad_de_articulos;
                        break;
                }
                $("#precioCompra").val(Math.round((parseFloat(precio_compra.toFixed(2))) * 10) / 10);
                $("#precioVenta").val(Math.round((parseFloat(precio_venta.toFixed(2))) * 10) / 10);
                $("#ganancia").val(ganancia * 100);
                Swal.fire('El Precio de Compra de cada ' + unidad_de_medida + ' es ' + Math.round((parseFloat(precio_compra.toFixed(2))) * 10) / 10 + '!\n' +
                    'El Precio de Venta de cada ' + unidad_de_medida + ' es ' + Math.round((parseFloat(precio_venta.toFixed(2))) * 10) / 10
                    + '!');
            }
        })
    }


});
var unidad_seleccionada = "";
$(document).on('change', '#unidad_medida_form', function () {
    let presentacion = $("#presentacion");
    unidad_seleccionada = $("#unidad_medida_form option:selected").val();
    let option = "";
    switch (unidad_seleccionada) {
        case 'unidad':
            presentacion.empty();
            for (let index = 1; index < 13; index++) {
                option = $('<option>', {
                    value: index,
                    text: index,
                });
                presentacion.append(option);
            }
            option = $('<option>', {
                value: 'otro',
                text: 'Otra Unidad',
            });
            presentacion.append(option);
            precio_minorista_presentacion();

            break;
        case 'litro':
            presentacion.empty();
            for (let index = 1; index < 11; index++) {
                option = $('<option>', {
                    value: index,
                    text: index,
                });
                presentacion.append(option);
            }
            option = $('<option>', {
                value: 'otro',
                text: 'Otro Litro',
            });
            presentacion.append(option);
            precio_minorista_presentacion();

            break;
        case 'kilogramo':
            presentacion.empty();
            for (let index = 0.25; index < 51; index += 0.25) {
                option = $('<option>', {
                    value: index,
                    text: index,
                });
                presentacion.append(option);
            }
            option = $('<option>', {
                value: 'otro',
                text: 'Otro Kilogramo',
            });
            presentacion.append(option);
            precio_minorista_presentacion();

            break;
        case 'mililitro':
            presentacion.empty();
            for (let index = 100; index < 1000; index += 100) {
                option = $('<option>', {
                    value: index,
                    text: index,
                });
                presentacion.append(option);
            }
            option = $('<option>', {
                value: 'otro',
                text: 'Otro Mililitro',
            });
            presentacion.append(option);
            precio_minorista_presentacion();

            break;
        case 'metro':
            presentacion.empty();
            for (let index = 0.5; index < 30.5; index += 0.5) {
                option = $('<option>', {
                    value: index,
                    text: index,
                });
                presentacion.append(option);

            }
            option = $('<option>', {
                value: 'otro',
                text: 'Otro Metro',
            });
            presentacion.append(option);
            precio_minorista_presentacion();
            break;
        case 'gramo':
            presentacion.empty();
            for (let index = 0.50; index < 500; index += 0.25) {
                option = $('<option>', {
                    value: index,
                    text: index,
                });
                presentacion.append(option);

            }
            option = $('<option>', {
                value: 'otro',
                text: 'Otro Gramo',
            });
            presentacion.append(option);
            precio_minorista_presentacion();
            break;
        default:
            presentacion.empty();
            $("#btn-precio-minorista").hide();


            break;
    }
});
var unidades = 0;
var precio = 0.0;
$(document).on('click', '#btn-precio-minorista', function () {
    let precioVenta = $("#precioVenta").val();
    let presentacion = $("#presentacion option:selected").val();
    $("#unidad").text('1' + " " + unidad_de_medida);
    $("#precio").text(precioVenta);
    $("#medida-presentacion").text(unidad_seleccionada);

});
$(document).on('click', '#btn-calcular-precios', function () {
    let presentacion = $("#presentacion option:selected").val();


    if ($("#precio").text() == "") {
        Swal.fire({
            title: 'Error',
            text: 'El Precio de Venta es Requerido',
            icon: 'error'
        });
    } else {
        if ($("#unidad_medida_form option:selected").val() != unidad_de_medida) {
            Swal.fire({
                title: 'Error',
                text: 'Las Unidades de Medida no son Iguales',
                icon: 'error'
            });
        } else {
            let precio_venta = ((parseFloat($("#precio").text()) * parseFloat($("#forma-presentacion").text()) * 10) / 10);
            let precio_compra = ((parseFloat($("#precioCompra").val()) * parseFloat(presentacion)) * 10) / 10;
            $("#precioVenta").val(parseFloat(precio_venta).toFixed(2));
            $("#precioCompra").val(parseFloat(precio_compra).toFixed(2));


            Swal.fire({
                title: 'Precio de Compra-Venta',
                text: `El precio de Compra de ${$("#forma-presentacion").text()} ${$("#medida-presentacion").text()} es ${parseFloat(precio_compra).toFixed(2)}.\nEl precio de venta de ${$("#forma-presentacion").text()} ${$("#medida-presentacion").text()} es ${parseFloat(precio_venta).toFixed(2)}.`,
                icon: 'info'
            });

        }
    }

});
function precio_minorista_presentacion() {
    let presentacion = $("#presentacion option:selected").val();
    $("#btn-precio-minorista").show();
    $("#forma-presentacion").text(presentacion);

}
$(document).on('change', '#presentacion', function () {
    let presentacion = $("#presentacion option:selected").val();
    $("#forma-presentacion").text(presentacion);
});

$(document).on('click', '#btn-registrar-articulo', function (e) {
    e.preventDefault();

    let productos_stock = $('#stock');
    let productos_sin_stock = $('#sin-stock');
    let descripcion = $('#descripcion').val();
    let marca = $('#marca').val();
    let medida = $('#unidad_medida_form option:selected').val();
    let presentacion = $('#presentacion option:selected').val();
    let stock = $('#stock-form').val();
    let precioCompra = $('#precioCompra').val();
    let precioVenta = $('#precioVenta').val();
    let lucro = $('#ganancia').val();
    let datos = { descripcion: descripcion, marca: marca, medida: medida, presentacion: presentacion, stock: stock, precioCompra: precioCompra, precioVenta: precioVenta, lucro: lucro };
    if (descripcion == "" || marca == "" || medida == "0" || stock == "" || precioCompra == "" || precioVenta == "" || lucro == "") {

        swal.fire({
            title: 'Error',
            text: 'Complete todos los Campos',
            icon: 'error'
        });
    } else {
        $.ajax({
            type: "get",
            url: "/Articulos/Crear-Articulo",
            data: datos,
            dataType: "json",
            success: function (response) {
                let nuevafila = [response.id, response.descripcion, response.marca, response.presentacion + ' ' + response.medida, response.stock, response.precioCompra, response.precioVenta];
                table.row.add(nuevafila).draw();
                let cantid_stock = response.stock;
                let cantidad_sin_stock = parseInt((productos_sin_stock).text());
                let cantidad = parseInt((productos_stock).text());
                if (cantid_stock[0] <= 0) {
                    let nuevaEtiqueta = $('<p>').text(cantidad_sin_stock + 1).addClass('font-sans-serif lh-1 mb-1 fs-4').attr('id', 'sin-stock');
                    productos_sin_stock.replaceWith(nuevaEtiqueta);
                } else {
                    let nuevaEtiqueta = $('<p>').text(cantidad + 1).addClass('font-sans-serif lh-1 mb-1 fs-4').attr('id', 'stock');
                    productos_stock.replaceWith(nuevaEtiqueta);
                }
                Swal.fire({
                    title: 'Confirmación',
                    text: 'Articulo Registrado Correctamente',
                    icon: 'success'
                });
            }
        });
    }
});
$(document).on('click', '#btn-borrar-todo', function () {
    let productos_stock = $('#stock');
    let productos_sin_stock = $('#sin-stock');
    Swal.fire({
        title: 'Peligro',
        text: 'Estás seguro de eliminar todos los artículos?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'

    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "get",
                url: "/Articulos/Eliminar-Todo",
                data: "",
                dataType: "json",
                success: function (response) {
                    if (response == true) {
                        table.clear().draw();
                        var nuevaEtiqueta2 = $('<p>').text('0').addClass('font-sans-serif lh-1 mb-1 fs-4').attr('id', 'sin-stock');

                        var nuevaEtiqueta = $('<p>').text('0').addClass('font-sans-serif lh-1 mb-1 fs-4').attr('id', 'stock');
                        productos_sin_stock.replaceWith(nuevaEtiqueta2);
                        productos_stock.replaceWith(nuevaEtiqueta);
                        swal.fire({
                            title: 'Confirmación',
                            text: 'Se Han Borrado todos los Articulos',
                            icon: 'success'
                        });
                    }
                }
            });
        }
    });

});
$(document).on('click', '#btn-borrar', function () {
    let filaSeleccionada = table.rows({ selected: true }).data()[0];
    let filaSeleccionada2 = table.rows({ selected: true });
    let productos_stock = $('#stock');
    let productos_sin_stock = $('#sin-stock');

    if (filaSeleccionada == undefined) {
        swal.fire({
            title: 'Error',
            text: 'Selecciona el Articulo A Eliminar',
            icon: 'error'
        });
    } else {
        let id = filaSeleccionada[0];
        let tresPrimerasColumnas = filaSeleccionada.slice(0, 3);
        Swal.fire({
            title: 'Peligro',
            text: 'Estás seguro de eliminar el Articulo' + ' ' + tresPrimerasColumnas + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'

        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "get",
                    url: "/Articulos/Eliminar/" + id,
                    data: "",
                    dataType: "json",
                    success: function (response) {
                        if (response == true) {
                            let cantid_stock = table.cell(filaSeleccionada2, 4).data();
                            let cantidad_sin_stock = parseInt((productos_sin_stock).text());
                            let cantidad = parseInt((productos_stock).text());

                            if (cantid_stock[0] <= 0) {
                                let nuevaEtiqueta = $('<p>').text(cantidad_sin_stock - 1).addClass('font-sans-serif lh-1 mb-1 fs-4').attr('id', 'sin-stock');
                                productos_sin_stock.replaceWith(nuevaEtiqueta);
                            } else {
                                let nuevaEtiqueta = $('<p>').text(cantidad - 1).addClass('font-sans-serif lh-1 mb-1 fs-4').attr('id', 'stock');
                                productos_stock.replaceWith(nuevaEtiqueta);
                            }
                            table.rows(filaSeleccionada2).remove().draw();
                            swal.fire({
                                title: 'Confirmación',
                                text: 'Se Ha Borrado el Articulo',
                                icon: 'success'
                            });
                        }
                    }
                });



            }
        });
    }

});
var id_art_modificar = 0;
$(document).on('click', '#btn-modificar', function () {
    let filaSeleccionada = table.rows({ selected: true }).data()[0];
    if (filaSeleccionada == undefined) {
        swal.fire({
            title: 'Error',
            text: 'Selecciona el Articulo A Modificar',
            icon: 'error'
        });
    } else {
        id_art_modificar = filaSeleccionada[0];
        $.ajax({
            type: "get",
            url: "/Articulos/BuscarArticulo/" + id_art_modificar,
            data: "",
            dataType: "json",
            success: function (response) {
                $.each(response, function (index, producto) {
                    $("#descripcion2").val(producto.descripcion);
                    $("#marca2").val(producto.marca);
                    $("#stock-form2").val(producto.stock);
                    $("#precioCompra2").val(producto.precioCompra);
                    $("#precioVenta2").val(producto.precioVenta);
                    $("#ganancia2").val(producto.lucro);
                    $("#btn-modificar-articulo").attr('disabled', false);

                });


            }
        });

    }
});
$(document).on('click', '#btn-modificar-articulo', function (e) {
    e.preventDefault();
    let descripcion = $("#descripcion2").val();
    let marca = $("#marca2").val();
    let stock = $("#stock-form2").val();
    let precioVenta = $("#precioVenta2").val();
    let lucro = $("#ganancia2").val();
    if (descripcion == "" || marca == "" || stock == "" || precioVenta == "" || lucro == "") {
        swal.fire({
            title: 'Error',
            text: 'Complete todos los Campos',
            icon: 'error'
        });
    } else {
        let datos = {
            descripcion: descripcion,
            marca: marca,
            stock: stock,
            precioVenta: precioVenta,
            lucro: lucro,
        };
        $.ajax({
            type: 'get',
            url: '/Articulos/ModificarArticulo/' + id_art_modificar,
            data: datos,
            dataType: 'json',
            success: function (response) {


                swal.fire({
                    title: 'Confirmacion',
                    text: 'Articulo Modificado Correctamente',
                    icon: 'success',
                }).then((value) => {
                    window.location.reload();
                });





            }

        });
    }
});