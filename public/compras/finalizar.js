$(document).on('click', '#pdf-finalizarCompra', function () {
    $.ajax({
        url: '/Compras/PDF',
        method: 'GET',
        data:{'pdf':$("#factura").html()},
        
        success: function(data) {
            var link = document.createElement('a');
            link.href = 'data:application/pdf;base64,' + data.pdf;
            link.download = 'pdf';
            link.target = '_blank';

            // Hacer que el usuario haga clic en el enlace para descargar el archivo
            link.click();
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
});