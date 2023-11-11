<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasarela de Pago</title>
    <script src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js" kr-public-key="{{$_ENV['IZI_PUBLIC_KEY']}}" kr-get-url-success="{{route('reanudarSuscripcion')}}" ; kr-language="es-ES">
    </script>
    <link rel="stylesheet" href="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/neon-reset.min.css">
    <script type="text/javascript" src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/neon.js">
    </script>
</head>

<body>
    <center>
        <div class="kr-embedded" kr-popin kr-form-token="{{$formToken}}"></div>
    </center>
</body>

</html>