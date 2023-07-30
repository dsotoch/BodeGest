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


numero_venta();
function numero_venta() {
    $.ajax({
        method: 'get',
        url: '/Ventas/Numero',
        data: "",
        dataType: 'json',
        success: function (response) {
            $("#documento").val(response);
        }

    });
}
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
    if ($("#cantidad").val() > stock) {
        swal.fire({ title: 'Opps.', text: "La cantidad es mayor que el Stock del Producto", icon: 'warning' });

        return false;
    }
    if ($("#cantidad").val() == "" || $("#cantidad").val() <= 0) {
        $("#cantidad").focus();
        swal.fire({ title: 'Opps.', text: "Ingresa una Cantidad Valida y luego Selecciona el Producto", icon: 'warning' });

    } else {

        var resultado = $.grep(productos, function (articulo) {
            return articulo.id == id;
        });

        if (resultado.length > 0) {

            swal.fire({ title: 'Opps.', text: "El Producto ya esta Agregado", icon: 'warning' });

        } else {
            let cantidad = $("#cantidad").val();
            let total = parseFloat($("#cantidad").val()) * parseFloat(precioVenta);

            let new_row = [id, producto + " " + presentacion, precioVenta, $("#cantidad").val(), total, '<button class="btn btn-danger" id="btn-eliminar"> <i class="fas fa-trash"></i> </button>  '];

            swal.fire({ title: 'OK', text: producto + " " + "Agregado", icon: 'success' });
            table.row.add(new_row).draw();
            productos.push({ 'id': id, 'cantidad': cantidad });
            $("#array_productos").val(JSON.stringify(productos));
            calcularMontoVenta();
        }
    }



});
var codigo_otros = [];
$(document).on('click', "#btn-otro-articulo", function (e) {
    e.preventDefault();
    let id = "**";
    let precioVenta = $("#precioVenta").val();
    let presentacion = $("#o-presentacion").val();

    if ($("#o-cantidad").val() == "" || $("#o-cantidad").val() <= 0) {
        $("#o-cantidad").focus();
        swal.fire({ title: 'Opps.', text: "Ingresa una Cantidad Valida y luego Selecciona el Producto", icon: 'warning' });

    }
    if (precioVenta == "" || presentacion == "") {
        swal.fire({ title: 'Opps.', text: "Completa todos los Campos", icon: 'warning' });

    } else {

        let total = parseFloat($("#o-cantidad").val()) * parseFloat(precioVenta);

        let new_row = [id, presentacion, precioVenta, $("#o-cantidad").val(), total, '<button class="btn btn-danger" id="btn-eliminar"> <i class="fas fa-trash"></i> </button>  '];

        swal.fire({ title: 'OK', text: presentacion + " " + "Agregado", icon: 'success' });
        table.row.add(new_row).draw();
        codigo_otros.push({ 'id': id, 'presentacion': presentacion, 'precioVenta': precioVenta, 'cantidad': $("#o-cantidad").val(), 'total': total });
        $("#precioVenta").val("");
        $("#o-presentacion").val("");
        $("#array_productos2").val(JSON.stringify(codigo_otros));
        calcularMontoVenta();
    }
});
$(document).on('click', '#btn-eliminar', function () {
    let $row = $(this).closest('tr');
    let $producto_eliminar = $($row.find('td')[0]).text();
    let presentacion = $($row.find('td')[1]).text();
    $indice_del_producto = productos.indexOf($producto_eliminar);
    if ($indice_del_producto == -1) {
        nuevoarray = codigo_otros.filter(function (obj) {
            return obj.presentacion !== presentacion;
        });
        codigo_otros = nuevoarray;
        table.row($row).remove().draw();
        $("#array_productos2").val(JSON.stringify(codigo_otros));

        calcularMontoVenta();
    } else {
        productos.splice($indice_del_producto, 1);
        table.row($row).remove().draw();
        $("#array_productos").val(JSON.stringify(productos));

        calcularMontoVenta();

    }

});

$('#buscador-cliente').on('keyup', function () {
    const filtro = $(this).val().toUpperCase();
    $('#seleccion option').each(function () { // Iterar por cada opción
        const texto = $(this).text().toUpperCase();
        if (texto.includes(filtro)) { // Si el texto contiene el filtro, mostrar opción
            $(this).show();
        } else { // De lo contrario, ocultar opción
            $(this).hide();
        }
    });
});

$("#btn-guardar-cliente").on('click', function (e) {
    e.preventDefault();
    let cliente = $("#cliente-n").val();
    let dni = $("#dni-n").val();
    let telefono = $("#telefono-n").val();
    let email = $("#correo-n").val();
    if (email == "" || dni == "" || telefono == "" || cliente == "") {
        error("Completa todos los Campos");
        return;
    }
    $.ajax({
        type: 'GET',
        url: '/Clientes/Crear',
        data: { cliente: cliente, dni: dni, telefono: telefono, email: email },
        dataType: 'json',
        success: function (response) {
            let new_option = $('<option>').attr('value', response.dni).text(response.cliente + "--" + response.dni);
            $("#seleccion").append(new_option);
            new_option.attr('selected', true);
            confirmacion("Cliente Registrado ,ahora ya Esta disponible en el menu de Seleccion");
        },
        error: function (response) {
            alert(response);
        },
    });
});

$("#iva").on('change', function () {
    if ($("#iva option:selected").val() == "si") {
        calcularMontoVenta();
    } else {
        calcularMontoVentaSINIVA();
    }
});
$("#pago").on('change', function () {
    if ($("#pago option:selected").val() == "parcial") {
        $("#monto").attr('readonly', false);
        $("#monto").focus();

    } else {
        $("#monto").attr('readonly', true);
    }
});


$("#btn-vender").click(function (e) {
    e.preventDefault();
    let documento = $("#documento").val();
    let fecha = $("#fecha").val();
    let iva = $("#iva option:selected").val();
    let nota = $("#remision").val();
    let formaPago = $("#pago option:selected").val();
    let montoInicio = $("#monto").val();
    let totalVenta = $("#t-pagar").val();
    let montoRecibido = $("#t-recibido").val();
    let moneda = $("#moneda option:selected").val();
    let cliente = $("#seleccion option:selected").val();

    if (documento == "" || fecha == "") {
        error("Completa Todos los Datos Necesarios para la Compra");
        return false;
    }
    if (cliente == "") {
        $("#seleccion").focus();

        error("Selecciona Un cliente Valido");
        return false;
    }
    if (formaPago == "parcial" && montoInicio == "" || parseFloat(montoInicio) < 0) {
        error("Ingresa Cuanto dio como inicial el Cliente");
        return false;
    }
    if (totalVenta == "" || parseFloat(totalVenta <= 0)) {
        error("Esta Venta no Tiene Productos");
        return false;
    }
    if (montoRecibido == "" || montoRecibido == "") {
        error("El Monto Recibido esta vacio o es invalido");
        return false;
    }
    if (parseFloat(montoRecibido) < parseFloat(totalVenta)) {
        error("Estas Recibiendo menos dinero que el total de la Venta");
    } else {
        let cambio = (parseFloat(montoRecibido) - parseFloat(totalVenta)).toFixed(2);
        swal.fire({
            title: 'OK',
            text: 'Venta Realizada , El Cambio es :' + ' ' + cambio,
            icon: 'success',
            confirmButtonText: 'De Acuerdo',

        }).then((value) => {
            $("#miform").submit();
        });
    }


});

$("#btn-detalle-nueva-venta").on('click', function () {
    window.location.href = "/Ventas/Index"
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
    $("#t-pagar").val(parseFloat(total + subt).toFixed(2));
    $("#p-igv").val(can_ig);
    $("#p-subtotal").val(total);
    $("#p-total").val(parseFloat(total + subt).toFixed(2));

}

function calcularMontoVentaSINIVA() {
    let total = 0.0;
    let can_ig = 0.0;
    $("#tabla-ventas tr").each(function () {
        $(this).find('td:nth-last-child(2)').each(function () {
            total += parseFloat($(this).text());
        });
    });
    let subt = can_ig * total;
    $("#t-pagar").val(parseFloat(total + subt).toFixed(2));
    $("#p-igv").val(can_ig);
    $("#p-subtotal").val(total);
    $("#p-total").val(parseFloat(total + subt).toFixed(2));

}
//DETALLES VENTAS

$("#btn-whatsapp").on('click', function () {

    let telefono = $("#telefono").text();
    let mensaje = "Hola, te envío este comprobante";
    let url = `https://api.whatsapp.com/send?phone=${telefono}&text=${mensaje}`;
    let documento = $("#documento").text();
    let cliente = $("#cliente").text();
    // Abre el enlace en una nueva pestaña

    html2canvas($(".pdf")[0]).then(function (canvas) {
        // Obtiene la imagen como base64
        let imageData = canvas.toDataURL("image/png");
        // Crea un enlace de descarga
        let enlace = document.createElement("a");
        enlace.href = imageData;
        enlace.download = documento + "-" + cliente;

        // Agrega el enlace al DOM y haz clic en él para descargar la imagen
        document.body.appendChild(enlace);
        enlace.click();
        document.body.removeChild(enlace);
    });

    window.open(url, "_blank");

});
$("#btn-email").click(function (e) {
    e.preventDefault();
    let email = $("#correo").text();
    html2canvas($(".pdf")[0]).then(function (canvas) {
        let imagen = canvas.toDataURL("image/jpeg");

        $("#imagen").val(imagen);
        $("#email").val(email);
        // Enviar el formulario
        $("#form").submit();

        $("#imagen").val("");
        $("#email").val("");
    });
});
function generar_window() {
    html2canvas($(".pdf")[0]).then(function (canvas) {
        let imagen = canvas.toDataURL("image/png");
        let popup = window.open("", "myPopup", "scrollbars=yes,resizable=yes");
        popup.document.write("<html><head><title>Imprimir</title><style>@media print {body {margin: 0;padding: 0;display: flex;justify-content: center;align-items: center;height: 100vh;}img {max-width: 100%;max-height: 100%;}}</style></head><body><img src='" + imagen + "'/></body></html>");
        popup.document.close();
        setTimeout(function () {
            popup.print();
            popup.close();
        }, 600);
    });
}
$(document).on('click', "#btn-imprimir", function () {
    movil();
});
function movil() {
    let pdfElement = document.querySelector(".pdf");
  
    // Crear un objeto jspdf
    let pdf = new jspdf.jsPDF();
  
    // Función para cargar las imágenes en el PDF
    function addImageToPDF(imgData) {
      pdf.addImage(imgData, 'PNG', 10, 10, pdf.internal.pageSize.getWidth() - 10, pdf.internal.pageSize.getHeight() - 20);
      pdf.autoPrint();
      // Crear un iframe para mostrar el PDF dentro del navegador
      let pdfDataUri = pdf.output('datauristring');
      let iframe = document.createElement('iframe');
      iframe.src = pdfDataUri;
      iframe.width = "100%";
      iframe.height = "600px"; // Ajusta el alto según tus necesidades
  
      // Agregar el iframe al cuerpo del documento actual
      document.body.appendChild(iframe);
    }
  
    // Convertir el contenido HTML a una imagen con html2canvas
    html2canvas(pdfElement).then(function (canvas) {
      let imagen = canvas.toDataURL("image/png");
  
      // Agregar la imagen al PDF
      addImageToPDF(imagen);
    }).catch(function (error) {
      console.error("Error al generar el PDF:", error);
    });
  }
  

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