
$(document).on('keyup','#c-venta',function (event) {
    if (event.which === 13) {
        let id_venta = $("#c-venta").val();
        if (id_venta.length <= 0) {
            swal.fire({
                title: "Error",
                text: "Ingrese un número de venta válido",
                icon: "error",
                confirmButtonText: "De acuerdo"
            });
        } else {
            $.ajax({
                type: "get",
                url: "/Ventas/Detalles",
                data: { 'venta': id_venta },
                dataType: "json",
                success: function (response) {
                    if (response === 500) {
                        swal.fire({
                            title: "Error",
                            text: "No existe Venta con el Codigo Ingresado",
                            icon: "error",
                            confirmButtonText: "De acuerdo"
                        });
                        $("#cliente").text("sin busqueda");
                        $("#fecha").text("sin busqueda");
                        $("#monto_venta").text("sin busqueda");
                        $("#metodo_pago").text("sin busqueda");
                        $("#estado_venta").text("sin busqueda");
                        $("#tabla_productos tbody").empty();
                    } else {
                        $("#tabla_productos tbody").empty();

                        $.each(response, function (indexInArray, valueOfElement) {
                            $("#cliente").text(valueOfElement[1].cliente);
                            $("#fecha").text(valueOfElement[0].fecha);
                            $("#monto_venta").text(valueOfElement[0].totalVenta);
                            $("#metodo_pago").text(valueOfElement[0].formaPago);
                            $("#estado_venta").text(valueOfElement[0].estado);
                            $.each(valueOfElement[2], function (indexInArray, valueOfElement) {
                                $("#tabla_productos").append('<tr><td>' + valueOfElement.descripcion + " " + valueOfElement.marca + " " + valueOfElement.medida +
                                    '  </td><td>' + valueOfElement.precioVenta + '</td> <td>' + valueOfElement.pivot.cantidad + '  </td><td>' + (parseFloat(valueOfElement.precioVenta) * parseFloat(valueOfElement.pivot.cantidad)).toFixed(2) + ' </td> </tr>');
                            });

                        });


                    }
                },
                error: function (xhr, status, error) {
                    // Manejar errores de la solicitud AJAX
                }
            });
        }
    }
});
$(document).on('keypress', '#c-venta', function (e) {
    if (e.which === 13 || e.keyCode === 13) {
        let id_venta = $("#c-venta").val();
        if (id_venta.length <= 0) {
            swal.fire({
                title: "Error",
                text: "Ingrese un número de venta válido",
                icon: "error",
                confirmButtonText: "De acuerdo"
            });
        } else {
            $.ajax({
                type: "get",
                url: "/Ventas/Detalles",
                data: { 'venta': id_venta },
                dataType: "json",
                success: function (response) {
                    if (response === 500) {
                        swal.fire({
                            title: "Error",
                            text: "No existe Venta con el Codigo Ingresado",
                            icon: "error",
                            confirmButtonText: "De acuerdo"
                        });
                        $("#cliente").text("sin busqueda");
                        $("#fecha").text("sin busqueda");
                        $("#monto_venta").text("sin busqueda");
                        $("#metodo_pago").text("sin busqueda");
                        $("#estado_venta").text("sin busqueda");
                        $("#tabla_productos tbody").empty();
                    } else {
                        $("#tabla_productos tbody").empty();

                        $.each(response, function (indexInArray, valueOfElement) {
                            $("#cliente").text(valueOfElement[1].cliente);
                            $("#fecha").text(valueOfElement[0].fecha);
                            $("#monto_venta").text(valueOfElement[0].totalVenta);
                            $("#metodo_pago").text(valueOfElement[0].formaPago);
                            $("#estado_venta").text(valueOfElement[0].estado);
                            $.each(valueOfElement[2], function (indexInArray, valueOfElement) {
                                $("#tabla_productos").append('<tr><td>' + valueOfElement.descripcion + " " + valueOfElement.marca + " " + valueOfElement.medida +
                                    '  </td><td>' + valueOfElement.precioVenta + '</td> <td>' + valueOfElement.pivot.cantidad + '  </td><td>' + (parseFloat(valueOfElement.precioVenta) * parseFloat(valueOfElement.pivot.cantidad)).toFixed(2) + ' </td> </tr>');
                            });

                        });


                    }
                },
                error: function (xhr, status, error) {
                    // Manejar errores de la solicitud AJAX
                }
            });
        }
    }
});
