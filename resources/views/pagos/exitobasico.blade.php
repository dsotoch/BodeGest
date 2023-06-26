<head>
    <title>Suscripción Confirmada</title>
    <link href="{{ asset('falcon/public/assets/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('falcon/public/assets/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('falcon/public/assets/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('falcon/public/assets/css/user.min.css') }}" rel="stylesheet" id="user-style-default">
    <style>
        table tbody tr {
            border: 1px solid black;
        }

        a {
            text-decoration: none;
            padding: 4px;

        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">

            <div class="row p-4">
                <div class="col-12" style="text-align: center;">
                    <img src="{{asset('imagenes/open.png')}}" alt="">
                    <hr>
                </div>
                <div class="col-12" style="text-align: center;">
                    <a href="{{route('login')}}" class="btn btn-success"> Confirmar</a>
                    <hr>
                    <br>
                    <h1>Éxito</h1>
                    <p>La operación se ha completado exitosamente.</p>
                    <p>¡Gracias por tu preferencia!</p>
                    <div>
                        @if(session('exito'))
                        <table class="table">

                            <tbody>
                                @foreach(session('exito') as $nombre => $valor)
                                <tr>
                                    <td>{{ $nombre }}</td>
                                    <td>{{ $valor }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('falcon/public/vendors/bootstrap/bootstrap.min.js') }}"></script>
</body>