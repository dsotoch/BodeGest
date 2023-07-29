var table = $("#tabla-compras").DataTable({
    language: {
        "url": "/es.json"
    },
});

$(document).on('keypress', '#c-compra', function (e) {
    if (e.which === 13 || e.keyCode === 13) {
        let id_compra = $("#c-compra").val();
        if (id_compra.length <= 0) {
            swal.fire({
                title: "Error",
                text: "Ingrese un número de Compra válido",
                icon: "error",
                confirmButtonText: "De acuerdo"
            });
        } else {
            $.ajax({
                type: "get",
                url: "/Compras/Detalles",
                data: { 'compra': id_compra },
                dataType: "json",
                success: function (response) {
                    if (response === 500) {
                        swal.fire({
                            title: "Error",
                            text: "No existe Compra con el Codigo Ingresado",
                            icon: "error",
                            confirmButtonText: "De acuerdo"
                        });
                        $("#metodo_pago").text("sin busqueda");
                        $("#total_compra").text("sin busqueda");
                        $("#proveedor").text("sin busqueda");
                        $("#fecha").text("sin busqueda");
                        let canvas = document.getElementById('imagen');
                        let contexto = canvas.getContext('2d');
                        limpiarCanvas(contexto);

                    } else {

                        $("#metodo_pago").text(response.metodoPago);
                        $("#total_compra").text(response.totalCompra);
                        $("#proveedor").text(response.provedor);
                        $("#fecha").text(response.fecha);
                        let canvas = document.getElementById('imagen');
                        let contexto = canvas.getContext('2d');
                        let img = new Image();
                        let origin_path = window.location.origin + '/' + response.public_path;
                        img.src = origin_path;
                        img.onload = function () {
                            canvas.width = img.width;
                            canvas.height = img.height;

                            contexto.drawImage(img, 0, 0, canvas.width, canvas.height);
                        }

                    }
                },
                error: function (xhr, status, error) {
                    // Manejar errores de la solicitud AJAX
                }
            });
        }
    }
});
$(document).on('keyup', '#c-compra', function (e) {
    if (e.which === 13 || e.keyCode === 13) {
        let id_compra = $("#c-compra").val();
        if (id_compra.length <= 0) {
            swal.fire({
                title: "Error",
                text: "Ingrese un número de Compra válido",
                icon: "error",
                confirmButtonText: "De acuerdo"
            });
        } else {
            $.ajax({
                type: "get",
                url: "/Compras/Detalles",
                data: { 'compra': id_compra },
                dataType: "json",
                success: function (response) {
                    if (response === 500) {
                        swal.fire({
                            title: "Error",
                            text: "No existe Compra con el Codigo Ingresado",
                            icon: "error",
                            confirmButtonText: "De acuerdo"
                        });
                        $("#metodo_pago").text("sin busqueda");
                        $("#total_compra").text("sin busqueda");
                        $("#proveedor").text("sin busqueda");
                        $("#fecha").text("sin busqueda");
                        let canvas = document.getElementById('imagen');
                        let contexto = canvas.getContext('2d');
                        limpiarCanvas(contexto);

                    } else {

                        $("#metodo_pago").text(response.metodoPago);
                        $("#total_compra").text(response.totalCompra);
                        $("#proveedor").text(response.provedor);
                        $("#fecha").text(response.fecha);
                        let canvas = document.getElementById('imagen');
                        let contexto = canvas.getContext('2d');
                        let img = new Image();
                        let origin_path = window.location.origin + '/' + response.public_path;
                        img.src = origin_path;
                        img.onload = function () {
                            canvas.width = img.width;
                            canvas.height = img.height;

                            contexto.drawImage(img, 0, 0, canvas.width, canvas.height);
                        }

                    }
                },
                error: function (xhr, status, error) {
                    // Manejar errores de la solicitud AJAX
                }
            });
        }
    }
});
function limpiarCanvas(contexto) {
    contexto.clearRect(0, 0, contexto.canvas.width, contexto.canvas.height);
}