grafico_ventas_compras();
grafico_maxima_venta();
grafico_mayores_ventas();
function grafico_ventas_compras() {
    const grafico = document.getElementById('grafico').getContext('2d');
    const xValues = [new Date().toLocaleDateString(undefined, 'America/Lima'), new Date().toLocaleDateString(undefined, 'America/Lima')];
    $.ajax({
        type: "get",
        url: "/Principal/CompraVenta",
        data: "",
        dataType: "json",
        success: function (response) {
            let ventas = [];
            let compras = [];
            ventas.push(response[1]);
            compras.push(response[0]);
            $("#m-ventas").text(response[1]);
            $("#m-compras").text(response[0]);
            new Chart(grafico, {
                type: "bar",
                data: {
                    labels: xValues,
                    datasets: [{
                        data: ventas,
                        borderColor: "red",
                        backgroundColor: "red",
                        fill: true,
                        label: "Ventas de Hoy"
                    }, {
                        data: compras,
                        borderColor: "green",
                        backgroundColor: "green",
                        fill: true,
                        label: "Compras de Hoy"
                    }]
                },
                options: {
                    legend: { display: false },

                }
            });
        }
    });

}

function grafico_maxima_venta() {
    const grafico = document.getElementById('maxima_venta').getContext('2d');
    $.ajax({
        type: "get",
        url: "/Principal/VentasMayores",
        data: "",
        dataType: "json",
        success: function (response) {
            let monto = 0.0;
            let ventas = [];
            let titulos = [];
            if (response.length > 0) {
                $.each(response, function (indexInArray, valueOfElement) {
                    ventas.push(valueOfElement.monto);
                    titulos.push(valueOfElement.cliente);
                });
                monto = response[0].monto;
            } else {
                ventas = [0.0];
                titulos = ['0-ventas'];
            }
            $("#m-ventas-hoy").text(monto);


            var data = {
                labels: titulos,
                datasets: [
                    {
                        data: ventas,
                        backgroundColor: ["red", "orange", "purple"]
                    }
                ]
            };

            // Opciones del gráfico
            var options = {
                responsive: true
            };

            // Crear gráfico
            var myChart = new Chart(grafico, {
                type: "pie",
                data: data,
                options: options
            });




        }
    });

}

function grafico_mayores_ventas() {




}