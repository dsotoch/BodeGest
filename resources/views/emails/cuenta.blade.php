<!DOCTYPE html>
<html>

<head>
    <title>Estado de Cuenta</title>
</head>

<body>
    <center>
        <h2 style="background-color: red;color: white;">{{$empresa->nombre}}</h2>
    </center>
    <h3>Te Envio Todos los Datos de Tu Cuenta!</h3>
    <hr>
    <p>Para Cualquier reclamo Comunicarte al numero , {{$empresa->telefono}} .</p>
    <p>Tambien al Correo Electronico, {{$empresa->correo}} .</p>
    <br>
    <hr>
    <p>A continuación Adjunto Comprobante</p>
    <p style="background-color: red;color: white;">Saludos de {{$empresa->nombre}}!</p>
</body>

</html>