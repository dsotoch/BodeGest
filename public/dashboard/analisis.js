Datos();
grafico_ingresos_vs_egresos();
grafico_ventas_mensual();
function Datos() {
    $.ajax({
        type: "get",
        url: "/Administracion/Datos",
        data: "",
        dataType: "json",
        success: function (response) {
            let length = response.length;
            let div = $(".progress");
            let clientes_div = $(".row-progress");
            let cliente_top1 = {};
            let conta = 0;
            div.empty();
            clientes_div.empty();
            switch (length) {
                case 1:
                    $.each(response, function (indexInArray, value) {
                        conta++;
                        if (conta == 1) {
                            let row = '<div class="progress-bar bg-success border-end border-white border-2" title="' + parseFloat(value.porcentaje).toFixed(0) + '%" role="progressbar" style="width:' + parseFloat(value.porcentaje).toFixed(0) + '%" aria-valuenow="' + parseFloat(value.porcentaje).toFixed(0) + '" aria-valuemin="0" aria-valuemax="100"></div>'
                            div.append(row);

                            let row_cli = '<div class="col-auto d-flex align-items-center pe-3"><span class="dot bg-success"></span><span>' + value.cliente.dni + '-' + value.cliente.cliente + '</span><span class="d-none d-md-inline-block d-lg-none d-xxl-inline-block">(' + parseFloat(value.porcentaje).toFixed(0) + '%)</span></div>';
                            clientes_div.append(row_cli);
                        }


                    });
                    break;
                case 2:
                    $.each(response, function (indexInArray, value) {
                        conta++;
                        if (conta == 1) {
                            let row = '<div class="progress-bar bg-success border-end border-white border-2" role="progressbar" title="' + parseFloat(value.porcentaje).toFixed(0) + '%" style="width:' + parseFloat(value.porcentaje).toFixed(0) + '%" aria-valuenow="' + parseFloat(value.porcentaje).toFixed(0) + '" aria-valuemin="0" aria-valuemax="100"></div>'
                            div.append(row);
                            let row_cli = '<div class="col-auto d-flex align-items-center pe-3"><span class="dot bg-success"></span><span>' + value.cliente.dni + '-' + value.cliente.cliente + '</span><span class="d-none d-md-inline-block d-lg-none d-xxl-inline-block">(' + parseFloat(value.porcentaje).toFixed(0) + '%)</span></div>';
                            clientes_div.append(row_cli);


                        }
                        if (conta == 2) {
                            let row = '<div class="progress-bar bar bg-progress-gradient border-end border-white border-2" title="' + parseFloat(value.porcentaje).toFixed(0) + '%" role="progressbar" style="width:' + parseFloat(value.porcentaje).toFixed(0) + '%" aria-valuenow="' + parseFloat(value.porcentaje).toFixed(0) + '" aria-valuemin="0" aria-valuemax="100"></div>'
                            div.append(row);
                            let row_cli = '<div class="col-auto d-flex align-items-center pe-3"><span class="dot bg-progress-gradient"></span><span>' + value.cliente.dni + '-' + value.cliente.cliente + '</span><span class="d-none d-md-inline-block d-lg-none d-xxl-inline-block">(' + parseFloat(value.porcentaje).toFixed(0) + '%)</span></div>';
                            clientes_div.append(row_cli);

                        }


                    });
                    break;

                case 3:
                    $.each(response, function (indexInArray, value) {
                        conta++;
                        if (conta == 1) {
                            let row = '<div class="progress-bar bg-success border-end border-white border-2" title="' + parseFloat(value.porcentaje).toFixed(0) + '%"  role="progressbar" style="width:' + parseFloat(value.porcentaje).toFixed(0) + '%" aria-valuenow="' + parseFloat(value.porcentaje).toFixed(0) + '" aria-valuemin="0" aria-valuemax="100"></div>'
                            div.append(row);
                            let row_cli = '<div class="col-auto d-flex align-items-center pe-3"><span class="dot bg-success"></span><span>' + value.cliente.dni + '-' + value.cliente.cliente + '</span><span class="d-none d-md-inline-block d-lg-none d-xxl-inline-block">(' + parseFloat(value.porcentaje).toFixed(0) + '%)</span></div>';
                            clientes_div.append(row_cli);
                        }
                        if (conta == 2) {
                            let row = '<div class="progress-bar bar bg-progress-gradient border-end border-white border-2" title="' + parseFloat(value.porcentaje).toFixed(0) + '%" role="progressbar" style="width:' + parseFloat(value.porcentaje).toFixed(0) + '%" aria-valuenow="' + parseFloat(value.porcentaje).toFixed(0) + '" aria-valuemin="0" aria-valuemax="100"></div>'
                            div.append(row);
                            let row_cli = '<div class="col-auto d-flex align-items-center pe-3"><span class="dot bg-progress-gradient"></span><span>' + value.cliente.dni + '-' + value.cliente.cliente + '</span><span class="d-none d-md-inline-block d-lg-none d-xxl-inline-block">(' + parseFloat(value.porcentaje).toFixed(0) + '%)</span></div>';
                            clientes_div.append(row_cli);
                        }
                        if (conta == 3) {
                            let row = '<div class="progress-bar bar bg-info border-end border-white border-2" title="' + parseFloat(value.porcentaje).toFixed(0) + '%" role="progressbar" style="width:' + parseFloat(value.porcentaje).toFixed(0) + '%" aria-valuenow="' + parseFloat(value.porcentaje).toFixed(0) + '" aria-valuemin="0" aria-valuemax="100"></div>'
                            div.append(row);
                            let row_cli = '<div class="col-auto d-flex align-items-center pe-3"><span class="dot bg-info"></span><span>' + value.cliente.dni + '-' + value.cliente.cliente + '</span><span class="d-none d-md-inline-block d-lg-none d-xxl-inline-block">(' + parseFloat(value.porcentaje).toFixed(0) + '%)</span></div>';
                            clientes_div.append(row_cli);
                        }

                    });
                    break;

                default:
                    break;
            }



        }
    });

}


function grafico_ingresos_vs_egresos() {
    var ctx = document.getElementById('ingresos-vs-egresos').getContext('2d');

    $.ajax({
        type: "get",
        url: "/Administracion/ingresos_vs_egresos",
        data: "",
        dataType: "json",
        success: function (response) {
            let fechas = [];
            let ingresos = [];
            let egresos = [];

            $.each(response, function (indexInArray, valueOfElement) {

                $.each(valueOfElement.fechas, function (indexInArray, valueOfElement) {
                    fechas.push(valueOfElement.inicio + '-' + valueOfElement.fin,);
                });
                $.each(valueOfElement.ingresos, function (indexInArray, valueOfElement) {
                    ingresos.push(valueOfElement.ingresos);
                });
                $.each(valueOfElement.egresos, function (indexInArray, valueOfElement) {
                    egresos.push(valueOfElement.egresos);
                });
            });

            var miGrafico = new Chart(ctx, {
                type: 'line', // Tipo de gráfico
                data: {
                    labels: fechas, // Etiquetas para el eje X
                    datasets: [{
                        label: 'Ingresos', // Etiqueta para el primer conjunto de datos
                        data: ingresos, // Datos para el primer eje Y
                        backgroundColor: 'rgba(255, 99, 132, 0.2)', // Color de fondo
                        borderColor: 'rgba(255, 99, 132, 1)', // Color del borde
                        borderWidth: 2, // Ancho del borde
                        fill: true // Desactiva el relleno de la línea
                    },
                    {
                        label: 'Egresos', // Etiqueta para el segundo conjunto de datos
                        data: egresos, // Datos para el segundo eje Y
                        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
                        borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
                        borderWidth: 2, // Ancho del borde
                        fill: true // Desactiva el relleno de la línea
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
            miGrafico.render();
        }
    });

}
function grafico_ventas_mensual() {
    let xValues = [];
    let yValues = [];
    let barColors = ["red", "green", "blue", "orange", "brown", "purple"];
    let ctx = document.getElementById("ventas-mensual").getContext('2d');
    $.ajax({
        type: "get",
        url: "/Administracion/VentasSemestral",
        data: "",
        dataType: "json",
        success: function (response) {

            $.each(response, function (indexInArray, valueOfElement) {

                $.each(valueOfElement.meses, function (indexInArray, valueOfElement) {

                    xValues.push(valueOfElement);
                });
                $.each(valueOfElement['montos'], function (indexInArray, valueOfElement) {
                    yValues.push(valueOfElement);

                });

            });
            let grafico = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: barColors,
                        data: yValues,
                        label: 'Montos de Ventas'
                    }]
                },
                options: {
                    animation: {
                      duration: 2000,
                      easing: 'easeOutBounce'
                    },
                   
                  }
            });
            grafico.render();

        }

    });

}
