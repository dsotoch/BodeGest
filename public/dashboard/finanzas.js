$(window).on('load', function () {
    $(document).on('change', '#periodo', function () {
        let f_inicio = $("#f-inicio").val();
        let option = $("#periodo option:selected").val();
        let f_termino = "";
        if (option == "0") {
            alert("Selecciona un Periodo Valido");
        } else {
            f_termino = option;
            $.ajax({
                type: "get",
                url: "/Finanzas/Balance",
                data: { fecha_termino: f_termino, fecha: f_inicio },
                dataType: "json",
                success: function (response) {
                    let datos = response[0];
                    let fecha = "";
                    let m_compra = 0.0;
                    let m_venta = 0.0;
                    let ventas = datos[4];
                    let compras = datos[3];

                    $.each(response, function (indexInArray, valueOfElement) {
                        $.each(valueOfElement[0], function (indexInArray, valueOfElement) {
                            m_compra = valueOfElement;
                        });
                        $.each(valueOfElement[1], function (indexInArray, valueOfElement) {
                            m_venta = valueOfElement;
                        });
                        $.each(valueOfElement[2], function (indexInArray, valueOfElement) {
                            fecha = valueOfElement;
                        });
                    });
                    let ref_ul_ventas = $("#lista-ventas");
                    let ref_ul_compras = $("#lista-compras");
                    if (ventas.ventas.length < 1) {
                        ref_ul_ventas.empty();
                        ref_ul_ventas.append('<li class="btn-danger"> No Hay Ventas en el Rango de Fechas Seleccionado </li>')
                    } else {
                        ref_ul_ventas.empty();
                        $.each(ventas.ventas, function (indexInArray, valueOfElement) {
                            ref_ul_ventas.append('<li> ' + valueOfElement.documento + '/ ' + valueOfElement.fecha + '/ monto => ' + ' ' + valueOfElement.totalVenta + ' </li>')
                        });
                    }
                    if (compras.compras.length < 1) {
                        ref_ul_compras.empty();
                        ref_ul_compras.append('<li class="btn-danger"> No Hay Compras en el Rango de Fechas Seleccionado </li>')
                    }else{
                        ref_ul_compras.empty();
                        $.each(compras.compras, function (indexInArray, valueOfElement) {
                            ref_ul_compras.append('<li> ' + valueOfElement.id + '/ ' + valueOfElement.fecha + '/ ' + valueOfElement.provedor +  '/ monto => ' + ' ' + valueOfElement.totalCompra + ' </li>')
                        });
                    }
                    $("#f-termino").val(fecha);
                    $("#monto-compra").text(parseFloat(m_compra).toFixed(2));
                    $("#monto-venta").text(parseFloat(m_venta).toFixed(2));
                    $("#t-caja").text(((parseFloat(m_venta).toFixed(2)) - (parseFloat(m_compra).toFixed(2))));
                    $("#n-caja").text(((parseFloat(m_venta).toFixed(2)) - (parseFloat(m_compra).toFixed(2))));

                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });

        }


    });
    $(document).on('keyup', '#m-retiro', function () {
        let monto_ingresado = parseFloat($(this).val());
        let total_caja_operacion = parseFloat($("#t-caja").text());
        let nuevo_monto_caja = total_caja_operacion - monto_ingresado ;
        $("#n-caja").text(parseFloat(nuevo_monto_caja).toFixed(2));
    });
    $(document).on('click' ,"#n-operacion",function () {
        window.location.reload();

    });
    $(document).on('click','#g-operacion',function (e) {
        
        e.preventDefault();
        let monto_caja =parseFloat( $("#saldo-caja").text());
        let monto_ingresado = parseFloat($(this).val());
        let total_caja_operacion = parseFloat($("#t-caja").text());
        let nueva_caja=parseFloat($("#n-caja").text());

        if (total_caja_operacion < 1) {
            Swal.fire({
                title: 'Error!',
                text: 'No Hay Registros en el Rango de Fechas Seleccionado para Realizar la Operación',
                icon: 'error',
                confirmButtonText: 'De Acuerdo'
            }).then((value) => {

            });
            return false;
        }
        if(isNaN(nueva_caja)){
            Swal.fire({
                title: 'Error!',
                text: 'Ingresa 0.0 en Monto de Retiro',
                icon: 'error',
                confirmButtonText: 'De Acuerdo'
            }).then((value) => {

            });
            return false;
        }
        let n_saldo=nueva_caja+monto_caja;
        Swal.fire({
            title: 'Nuevo Saldo en Caja',
            text: parseFloat(n_saldo).toFixed(2),
            icon: 'info',
            confirmButtonText: 'De Acuerdo'
        }).then((value) => {
            $("#miform").submit();
        });
    });


});