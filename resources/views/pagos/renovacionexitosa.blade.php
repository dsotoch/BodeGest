<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renovacion Exitosa</title>
</head>
<style>
    body {
        background-color: #151515;
        color: white;
        display: flex;
        text-align: center;
        justify-content: center;
        justify-items: center;
    }

    .contenedor {
        width: 50vw;
        height: auto;
        border: 1px solid white;
        padding: 10px;
    }

    @media (max-width: 768px) {
        .contenedor {
            width: 100vw;
            height: auto;
            border: 1px solid white;
        }

    }
    .title{
        color: greenyellow !important;
        font-weight: bold;
    }
    .conf{
        color: white;
        background-color: red;
        border-radius: 5px;
        padding: 10px;
        cursor: pointer;
    }
</style>

<body>
    <div class="contenedor">
        <img src="/imagenes/logo.png" alt="" srcset="">
        <hr>
        <h3 class="title">RENOVACION EXITOSA EN BODEGEST</h3>
        <h3>QUE BUENO QUE VOLVISTE!</h3>
        <button class="conf" onclick="volver();">CONFIRMAR</button>
    </div>

    <script>
        function volver(){
            window.location.href="/Login/Cuenta";
        }
    </script>
</body>

</html>