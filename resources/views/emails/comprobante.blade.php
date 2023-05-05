<!DOCTYPE html>
<html>

<head>
    <title>Comprobante de Venta</title>
</head>

<body>
    <center>
        <h2 style="background-color: red;color: white;">{{$empresa->nombre}}</h2>
    </center>
    <h3>Muchas Gracias por Tu Compra!</h3>
    <hr>
    <p>Para Cualquier reclamo Comunicarte al numero , {{$empresa->telefono}} .</p>
    <p>Tambien al Correo Electronico, {{$empresa->correo}} .</p>
    <br>
    <hr>
    <p>A continuación Adjunto Comprobante</p>
    <p style="background-color: red;color: white;">Saludos de {{$empresa->nombre}}!</p>
</body>

</html>