<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio</title>
    <link rel="stylesheet" href="{{asset('pagos/pago.css')}}">

</head>

<body>

    <!DOCTYPE html>
    <html lang="en-US" dir="ltr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <!-- ===============================================-->
        <!--    Document Title-->
        <!-- ===============================================-->



        <!-- ===============================================-->
        <!--    Favicons-->
        <!-- ===============================================-->
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('imagenes/logo.png')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('imagenes/logo.png')}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('imagenes/logo.png')}}">
        <link rel="icon" href="{{asset('imagenes/logo.png')}}" type="image/png">
        <link rel="manifest" href="{{ asset('falcon/public/assets/img/favicons/manifest.json') }}">
        <meta name="msapplication-TileImage" content="{{asset('imagenes/logo.png')}}">
        <meta name="theme-color" content="#ffffff">
        <script src="{{ asset('falcon/public/assets/js/config.js') }}"></script>
        <script src="{{ asset('falcon/public/vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script>


        <!-- ===============================================-->
        <!--    Stylesheets-->
        <!-- ===============================================-->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
        <link href="{{ asset('falcon/public/vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
        <link href="{{ asset('falcon/public/assets/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
        <link href="{{ asset('falcon/public/assets/css/theme.min.css') }}" rel="stylesheet" id="style-default">
        <link href="{{ asset('falcon/public/assets/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
        <link href="{{ asset('falcon/public/assets/css/user.min.css') }}" rel="stylesheet" id="user-style-default">
        <script src="{{asset('vendor/sweetalert/sweetalert.all.js')}}"></script>
        <script>
            var isRTL = JSON.parse(localStorage.getItem('isRTL'));
            if (isRTL) {
                var linkDefault = document.getElementById('style-default');
                var userLinkDefault = document.getElementById('user-style-default');
                linkDefault.setAttribute('disabled', true);
                userLinkDefault.setAttribute('disabled', true);
                document.querySelector('html').setAttribute('dir', 'rtl');
            } else {
                var linkRTL = document.getElementById('style-rtl');
                var userLinkRTL = document.getElementById('user-style-rtl');
                linkRTL.setAttribute('disabled', true);
                userLinkRTL.setAttribute('disabled', true);
            }
        </script>

    </head>


    <body>

        <!-- ===============================================-->
        <!--    Main Content-->
        <!-- ===============================================-->
        <main class="main" id="top">

            <div class="container" data-layout="container">
                <script>
                    var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                    if (isFluid) {
                        var container = document.querySelector('[data-layout]');
                        container.classList.remove('container');
                        container.classList.add('container-fluid');
                    }
                </script>
                <div class="row flex-center min-vh-100 py-6">
                    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4"><a class="d-flex flex-center mb-4" href="{{ asset('imagenes/logo.png') }}"><img class="me-2" src="{{ asset('imagenes/logo.png') }}" alt="" width="58" /><span class="font-sans-serif fw-bolder fs-5 d-inline-block">BodeGest</span></a>
                        <div class="card">
                            <div class="card-body p-4 p-sm-5">
                                <div class="row flex-between-center mb-2">

                                    <div class="col-auto">
                                    </div>
                                    <h5>Inicio de Sesión</h5>

                                </div>

                                <div class="mb-3">
                                    <input class="form-control" type="email" placeholder="Email address" id="email" />
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" type="password" placeholder="Password" id="password" />
                                </div>
                                <div class="row flex-between-center">

                                    <div class="col-auto"><button class="fs--1" style="border: none;background-color: transparent;" id="pass-ol">
                                            <a href="#">Olvidaste
                                                tu Contraseña?</a></button></div>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary d-block w-100 mt-3" type="button" id="btn-iniciar-sesion">Iniciar Sesión</button>
                                </div>

                                <hr>
                                <div class="mb-3" id="sinlicencia" hidden>
                                    <label for="" class="form-label alert-danger">"Tu Subscripción Esta Inactiva por Falta de Pago"</label>
                                    <div class="card">
                                        <div class="card-body">
                                            <label for="" class="form-label">Actualmente Estas Registrado con el Plan</label>
                                            <label for="" class="text-success">PLAN BASICO 22PEN</label>

                                        </div>
                                    </div>
                                    <br>
                                    <center>
                                        <form action="{{ route('suscriptionResume') }}" method="get">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Reanudar Subscripción</button>

                                        </form>
                                        <br>

                                        <a href="{{ config('general.url_cambiar_plan') }}" class="btn btn-warning" id="btn-">Cambiar de Plan</a>

                                    </center>
                                    <hr>


                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Button trigger modal -->





        </main>
        <!-- ===============================================-->
        <!--    End of Main Content-->
        <!-- ===============================================-->

        <!-- Button trigger modal -->
        <!-- Button trigger modal -->

        <!-- Modal -->


        <!-- Modal -->



        <!-- ===============================================-->
        <!--    JavaScripts-->
        <!-- ===============================================-->
        <script src="{{ asset('falcon/public/vendors/popper/popper.min.js') }}"></script>
        <script src="{{ asset('falcon/public/vendors/bootstrap/bootstrap.min.js') }}"></script>
        <script src="{{ asset('falcon/public/vendors/anchorjs/anchor.min.js') }}"></script>
        <script src="{{ asset('falcon/public/vendors/is/is.min.js') }}"></script>
        <script src="{{ asset('falcon/public/vendors/fontawesome/all.min.js') }}"></script>
        <script src="{{ asset('falcon/public/vendors/lodash/lodash.min.js') }}"></script>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
        <script src="{{ asset('falcon/public/vendors/list.js/list.min.js') }}"></script>
        <script src="{{ asset('falcon/public/assets/js/theme.js') }}"></script>
        <script src="{{ asset('jquery.js') }}"></script>

        <script src="{{ asset('iniciosesion/registrarse.js') }}" type="module"></script>

    </body>

    </html>
</body>

</html>