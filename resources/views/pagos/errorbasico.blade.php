<head>
    <title>Error</title>
    <link href="{{ asset('falcon/public/assets/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('falcon/public/assets/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('falcon/public/assets/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('falcon/public/assets/css/user.min.css') }}" rel="stylesheet" id="user-style-default">
    <style>
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
                    <a href="{{route('login')}}" class="btn btn-danger"> Intentar Nuevamente</a>
                    <hr>
                    <br>
                    <h1>Error</h1>
                    <p>Hubo Un Error al Realizar la operación .</p>
                    <div> @if (session('error'))
                        <div class="alert-danger">
                            {{session('error')}}
                        </div>
                        @endif
                    </div>
                    <p>¡Intentalo Nuevamente!</p>

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('falcon/public/vendors/bootstrap/bootstrap.min.js') }}"></script>

</body>