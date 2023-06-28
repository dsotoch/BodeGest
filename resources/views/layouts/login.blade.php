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
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('falcon/public/assets/img/favicons/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('falcon/public/assets/img/favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('falcon/public/assets/img/favicons/favicon-16x16.png') }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('falcon/public/assets/img/favicons/favicon.ico') }}">
        <link rel="manifest" href="{{ asset('falcon/public/assets/img/favicons/manifest.json') }}">
        <meta name="msapplication-TileImage" content="{{ asset('falcon/public/assets/img/favicons/mstile-150x150.png') }}">
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
                                    <div class="col-auto fs--1 text-600"><span class="mb-0 undefined">or</span> <span>
                                            <a id="btn-modal-registrarse" href="
                                        #">
                                                Crear
                                                una Nueva Cuenta</a></span></div>
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
                                    <label for="" class="form-label alert-danger">"Tu Cuenta Esta Verificada, pero aun no Cuentas con Ningun Plan Activo"</label>
                                    <br>
                                    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#modalprecios">Ver Planes</button>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Button trigger modal -->


            <!-- Modal Registrarse-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog        ">
                    <div class="modal-content">
                        <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                            <div class="position-relative z-index-1 light">
                                <h4 class="mb-0 text-white">Registrarse</h4>
                                <p class="fs--1 mb-0 text-white">Por favor crea tu cuenta BodeGest </p>
                            </div>
                            <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-4 px-5">
                            <form>

                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="modal-auth-name">Nombres</label>
                                    <input class="form-control" type="text" autocomplete="on" id="modal-auth-name" name="modal-auth-name" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="modal-auth-apellidos">Apellidos</label>
                                    <input class="form-control" type="text" autocomplete="on" id="modal-auth-apellidos" name="modal-auth-apellidos" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="modal-auth-dni">Dni</label>
                                    <input class="form-control" type="text" autocomplete="on" id="modal-auth-dni" name="modal-auth-dni" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="modal-auth-email">Email </label>
                                    <input class="form-control" type="email" autocomplete="on" id="modal-auth-email" name="modal-auth-email" required>
                                </div>
                                <div class="row gx-2">
                                    <div class="mb-3 col-sm-6">
                                        <label class="form-label" for="modal-auth-password">Password</label>
                                        <input class="form-control" type="password" autocomplete="on" id="modal-auth-password" name="modal-auth-password" required>
                                    </div>

                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="modal-auth-register-checkbox" checked>
                                    <label class="form-label" for="modal-auth-register-checkbox">Yo Acepto los <button style="border: none;color: blue;" type="button" data-bs-target="#modal-condiciones" data-bs-toggle="modal">Terminos </a> y Condiciones </label>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary d-block w-100 mt-3" type="button" id="btn-registrarse" name="button" value="Registrarse">Registrarse</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!--Modal Precios -->
            <div class="modal fade" id="modalprecios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog   modal-lg     ">
                    <div class="modal-content">
                        <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                            <div class="position-relative z-index-1 light">
                                <h4 class="mb-0 text-white">Planes de BodeGest</h4>
                                <p class="fs--1 mb-0 text-white">Por favor elige tu plan para Completar tu Registro en BodeGest </p>
                            </div>
                            <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-4 px-5">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-12 text-center mb-4">
                                        <div class="fs-1">Precios de Bodegest</div>
                                        <div class="d-flex justify-content-center">
                                            <h3 class="fs-2 fs-md-3">Pronto estara Disponible el Plan de Facturación Electronica.

                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-9 col-xl-10 col-xxl-8">
                                        <div class="row">
                                            <div class="col-md">

                                                <input type="text" id="cliente" name="cliente" readonly hidden>
                                                <div class="border rounded-3 overflow-hidden mb-3 mb-md-0">
                                                    <div class="d-flex flex-between-center p-4">
                                                        <div>
                                                            <h3 class="fw-light fs-5 mb-0 text-primary">Plan Basico</h3>
                                                            <input type="text" value="{{$planbasico}}" readonly name="planbasico" id="planbasico" hidden>

                                                            <h2 class="fw-light mt-0 text-primary"><sup class="fs-1">S/</sup><span class="fs-3">{{$planbasico}}</span><span class="fs--2 mt-1">/ m</span></h2>
                                                        </div>
                                                        <div class="pe-3"><img src="{{asset('falcon/public/assets/img/icons/free.svg')}}" width="70" alt=""></div>
                                                    </div>
                                                    <div class="p-4 bg-light">
                                                        <ul class="list-unstyled">
                                                            <li class="border-bottom py-2"> <svg class="svg-inline--fa fa-check fa-w-16 text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">
                                                                    <g transform="translate(256 256)">
                                                                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                                            <path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" transform="translate(-256 -256)"></path>
                                                                        </g>
                                                                    </g>
                                                                </svg><!-- <span class="fas fa-check text-primary" data-fa-transform="shrink-2"> </span> Font Awesome fontawesome.com --> Diseño Responsive(Movil - PC)</li>
                                                            <li class="border-bottom py-2"> <svg class="svg-inline--fa fa-check fa-w-16 text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">
                                                                    <g transform="translate(256 256)">
                                                                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                                            <path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" transform="translate(-256 -256)"></path>
                                                                        </g>
                                                                    </g>
                                                                </svg><!-- <span class="fas fa-check text-primary" data-fa-transform="shrink-2"></span> Font Awesome fontawesome.com --> Datos en Tiempo Real Online</li>
                                                            <li class="py-2 border-bottom"><svg class="svg-inline--fa fa-check fa-w-16 text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">
                                                                    <g transform="translate(256 256)">
                                                                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                                            <path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" transform="translate(-256 -256)"></path>
                                                                        </g>
                                                                    </g>
                                                                </svg> Comprobantes(Nota de Venta) </li>
                                                            <li class="py-2 border-bottom"><svg class="svg-inline--fa fa-check fa-w-16 text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">
                                                                    <g transform="translate(256 256)">
                                                                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                                            <path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" transform="translate(-256 -256)"></path>
                                                                        </g>
                                                                    </g>
                                                                </svg> Gratis 7 dias de Prueba</li>
                                                            <li class="py-2 border-bottom"><svg class="svg-inline--fa fa-check fa-w-16 text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">
                                                                    <g transform="translate(256 256)">
                                                                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                                            <path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" transform="translate(-256 -256)"></path>
                                                                        </g>
                                                                    </g>
                                                                </svg> Soporte Continuo </li>
                                                            <li class="py-2 border-bottom"><svg class="svg-inline--fa fa-check fa-w-16 text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">
                                                                    <g transform="translate(256 256)">
                                                                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                                            <path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" transform="translate(-256 -256)"></path>
                                                                        </g>
                                                                    </g>
                                                                </svg> Correos Electronicos Ilimitados </li>
                                                        </ul>


                                                        <button class="btn btn-outline-primary d-block w-100" type="button" id="btn-basico">Iniciar con el Plan Basico </button>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="col-md">
                                                <div class="border rounded-3 overflow-hidden">
                                                    <div class="d-flex flex-between-center p-4">
                                                        <div>
                                                            <h3 class="fw-light text-primary fs-5 mb-0">Facturador</h3>
                                                            <h2 class="fw-light text-primary mt-0"><sup class="fs-1">S/</sup><span class="fs-3">{{$planfacturador}}</span><span class="fs--2 mt-1">/ m</span></h2>
                                                        </div>
                                                        <div class="pe-3"><img src="{{asset('falcon/public/assets/img/icons/pro.svg')}}" width="70" alt=""></div>
                                                    </div>
                                                    <div class="p-4 bg-light">
                                                        <ul class="list-unstyled">
                                                            <li class="border-bottom py-2"> <svg class="svg-inline--fa fa-check fa-w-16 text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">
                                                                    <g transform="translate(256 256)">
                                                                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                                            <path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" transform="translate(-256 -256)"></path>
                                                                        </g>
                                                                    </g>
                                                                </svg><!-- <span class="fas fa-check text-primary" data-fa-transform="shrink-2"> </span> Font Awesome fontawesome.com --> Diseño Responsive(Movil - PC)</li>
                                                            <li class="border-bottom py-2"> <svg class="svg-inline--fa fa-check fa-w-16 text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">
                                                                    <g transform="translate(256 256)">
                                                                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                                            <path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" transform="translate(-256 -256)"></path>
                                                                        </g>
                                                                    </g>
                                                                </svg><!-- <span class="fas fa-check text-primary" data-fa-transform="shrink-2"></span> Font Awesome fontawesome.com --> Datos en Tiempo Real Online</li>

                                                            <li class="py-2 border-bottom"><svg class="svg-inline--fa fa-check fa-w-16 text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">
                                                                    <g transform="translate(256 256)">
                                                                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                                            <path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" transform="translate(-256 -256)"></path>
                                                                        </g>
                                                                    </g>
                                                                </svg> Gratis 7 dias de Prueba</li>
                                                            <li class="py-2 border-bottom"><svg class="svg-inline--fa fa-check fa-w-16 text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">
                                                                    <g transform="translate(256 256)">
                                                                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                                            <path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" transform="translate(-256 -256)"></path>
                                                                        </g>
                                                                    </g>
                                                                </svg> Soporte Continuo </li>
                                                            <li class="py-2 border-bottom"><svg class="svg-inline--fa fa-check fa-w-16 text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">
                                                                    <g transform="translate(256 256)">
                                                                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                                            <path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" transform="translate(-256 -256)"></path>
                                                                        </g>
                                                                    </g>
                                                                </svg> Correos Electronicos Ilimitados </li>
                                                            <li class="py-2 border-bottom"><svg class="svg-inline--fa fa-check fa-w-16 text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">
                                                                    <g transform="translate(256 256)">
                                                                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                                            <path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" transform="translate(-256 -256)"></path>
                                                                        </g>
                                                                    </g>
                                                                </svg>Notas de Venta </li>
                                                            <li class="py-2 border-bottom"><svg class="svg-inline--fa fa-check fa-w-16 text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">
                                                                    <g transform="translate(256 256)">
                                                                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                                            <path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" transform="translate(-256 -256)"></path>
                                                                        </g>
                                                                    </g>
                                                                </svg>Facturas Electronicas </li>
                                                            <li class="py-2 border-bottom"><svg class="svg-inline--fa fa-check fa-w-16 text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">
                                                                    <g transform="translate(256 256)">
                                                                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                                            <path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" transform="translate(-256 -256)"></path>
                                                                        </g>
                                                                    </g>
                                                                </svg>Boletas Electronicas </li>
                                                            <li class="py-2 border-bottom"><svg class="svg-inline--fa fa-check fa-w-16 text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">
                                                                    <g transform="translate(256 256)">
                                                                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                                            <path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" transform="translate(-256 -256)"></path>
                                                                        </g>
                                                                    </g>
                                                                </svg>notas de crédito y débito</li>
                                                            <li class="py-2 border-bottom"><svg class="svg-inline--fa fa-check fa-w-16 text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">
                                                                    <g transform="translate(256 256)">
                                                                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                                            <path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" transform="translate(-256 -256)"></path>
                                                                        </g>
                                                                    </g>
                                                                </svg>Emision en Tiempo Real</li>
                                                        </ul>
                                                        <button class="btn btn-primary d-block w-100" type="button" disabled>Iniciar con el Plan Facturador</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">

                                        <h5 class="mt-5">Somos tu mejor Opción</h5>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal-condiciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog   modal-lg     ">
                    <div class="modal-content">
                        <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                            <div class="position-relative z-index-1 light">
                                <h4 class="mb-0 text-white">Términos y Condiciones</h4>
                                
                            </div>
                            <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-4 px-5">
                            <div class="bkng-tb-cntnt p-2">
                            
                                <p><strong>Aceptación de los términos y condiciones:</strong></p>
                                <p>Al utilizar nuestra aplicación web de proceso de ventas en la nube (en adelante, "la Aplicación"), el usuario acepta los siguientes términos y condiciones. Si no está de acuerdo con estos términos, por favor, absténgase de utilizar la Aplicación.</p>

                                <h5>Licencia de uso</h5>

                                <p> Se otorga al usuario una licencia no exclusiva, intransferible y limitada para utilizar la Aplicación de acuerdo con los términos establecidos en este documento. Esta licencia está sujeta al pago de la suscripción mensual correspondiente.
                                </p>
                                <h5> Propiedad intelectual</h5>

                                <p> Todos los derechos de propiedad intelectual de la Aplicación, incluyendo pero no limitándose a software, diseños, logotipos y contenido, son propiedad exclusiva de nuestra empresa. Queda estrictamente prohibida la reproducción, distribución o modificación no autorizada de la Aplicación.
                                </p>
                                <h5>Limitaciones de responsabilidad</h5>

                                <p> El uso de la Aplicación es bajo la responsabilidad exclusiva del usuario. No nos hacemos responsables por cualquier daño, pérdida o perjuicio derivado del uso de la Aplicación, incluyendo pero no limitándose a errores, interrupciones o inexactitudes en el funcionamiento de la misma.
                                </p>
                                <h5>Garantías</h5>

                                <p> La Aplicación se proporciona "tal cual" sin garantías de ningún tipo, ya sean explícitas o implícitas. No garantizamos la disponibilidad ininterrumpida o libre de errores de la Aplicación, ni la precisión o confiabilidad de su contenido.
                                </p>
                                <h5> Actualizaciones y soporte</h5>

                                <p> Nos reservamos el derecho de realizar actualizaciones, mejoras o modificaciones en la Aplicación en cualquier momento. Podemos ofrecer soporte técnico para la resolución de problemas relacionados con la Aplicación de acuerdo con los términos y condiciones adicionales establecidos para dicho soporte.
                                </p>
                                <h5> Uso permitido</h5>

                                <p> El usuario se compromete a utilizar la Aplicación de acuerdo con la legislación aplicable y estos términos y condiciones. Queda prohibido realizar actividades ilegales, no autorizadas o que puedan afectar la seguridad o integridad de la Aplicación o de otros usuarios.
                                </p>
                                <h5> Privacidad</h5>

                                </p> Recopilamos, utilizamos y protegemos la información personal del usuario de acuerdo con nuestra política de privacidad. Al utilizar la Aplicación, el usuario acepta nuestra política de privacidad y el procesamiento de sus datos personales de acuerdo con la misma.</p>

                                <h5> Terminación</h5>

                                <p> Nos reservamos el derecho de terminar o suspender el acceso del usuario a la Aplicación en caso de incumplimiento de estos términos y condiciones o por cualquier otro motivo justificado a nuestra discreción.</p>

                                <h5>Cobro de la suscripción</h5>
                                <p>Al iniciar la suscripción a nuestra aplicación web de proceso de ventas en la nube, se realizará un cobro de 1 sol peruano. Este cobro se realizará al comienzo del período de suscripción.</p>

                                <h5>Periodo de prueba gratuito</h5>
                                <p>Ofrecemos un periodo de prueba gratuito de 7 días para que los usuarios puedan evaluar la funcionalidad y características de la aplicación. Durante este periodo, no se realizará ningún cobro. Si el usuario decide cancelar la suscripción dentro de los 7 días, no se efectuará ningún cargo.</p>

                                <h5>Cobros recurrentes</h5>
                                <p>Al proporcionar los datos de pago y completar el proceso de suscripción, el usuario autoriza a nuestra empresa a realizar los cobros recurrentes mensuales utilizando los datos de pago proporcionados. El cobro se realizará de forma automática al inicio de cada período de suscripción.</p>

                                <h5>Cancelación de la suscripción</h5>
                                <p>El usuario puede cancelar la suscripción en cualquier momento antes de la renovación automática del período de suscripción. Para cancelar la suscripción, el usuario deberá seguir los procedimientos especificados en la aplicación. La cancelación de la suscripción impedirá futuros cobros y el acceso a las funcionalidades exclusivas de la aplicación.</p>

                                <h5>Reembolsos</h5>
                                <p>No se realizarán reembolsos por pagos realizados previamente, incluyendo el pago inicial al iniciar la suscripción. Sin embargo, si el usuario cancela la suscripción dentro de los 7 días de prueba gratuita, no se efectuará ningún cobro.</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--Modal Pago-->
            <div class="modal fade" id="modal-pagar" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg mt-6" role="document">
                    <div class="modal-content border-0">
                        <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                            <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="bkng-tb-cntnt p-2">
                            <div class="pymnts">
                                <form action="/Pagos/CrearCargo" method="POST" id="payment-form">
                                    @csrf
                                    <input type="hidden" name="token_id" id="token_id">
                                    <div class="pymnt-itm card active">
                                        <h2 class="titulo-tarjetas">Tarjeta de crédito o débito</h2>
                                        <div class="row">
                                            <div class="col-6 ">
                                                <div class="credit">
                                                    <h4>Tarjetas de crédito</h4>
                                                    <br>
                                                    <img src="{{asset('imagenes/cards1.png')}}" alt="">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="debit">
                                                    <h4>Tarjetas de débito</h4>
                                                    <br>
                                                    <img src="{{asset('imagenes/cards2.png')}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">

                                            <div class="col-5">
                                                <label class="form-label">Nombre del titular</label>
                                                <input class="form-control" type="text" placeholder="Como aparece en la tarjeta" autocomplete="off" data-openpay-card="holder_name">
                                            </div>
                                            <div class="col-3">
                                                <label class="form-label">Correo Electronico</label>
                                                <input class="form-control" type="text" id="cliente-email" name="cliente-email" readonly required>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label">Número de tarjeta</label>
                                                <input class="form-control" type="text" autocomplete="off" data-openpay-card="card_number">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12 col-md-6">
                                                <div class="row">
                                                    <label class="form-label">Fecha de expiración</label>
                                                    <div class="col-6">
                                                        <input class="form-control" type="text" placeholder="Mes" data-openpay-card="expiration_month">
                                                    </div>
                                                    <div class="col-6">
                                                        <input class="form-control" type="text" placeholder="Año" data-openpay-card="expiration_year">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Código de seguridad</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <input class="form-control" type="text" placeholder="3 dígitos" autocomplete="off" data-openpay-card="cvv2">
                                                    </div>
                                                    <div class="col-8">
                                                        <img src="{{asset('imagenes/cvv.png')}}" alt="">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-4 col-md-4 col-lg-4 bt">
                                                <div><Label class="form-label">Total A Pagar Mensualmente</Label>
                                                    <div class="flex">
                                                        <input class="form-control cpago" type="text" name="amount" id="amount" readonly required><span class="form-control cpago">PEN</span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-8 col-md-8 col-lg-8">
                                                <div class="row">
                                                    <div class="col-6 br">
                                                        <p class="texto">Transacciones realizadas vía:</p>
                                                        <img src="{{asset('imagenes/openpay.png')}}" alt="">
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="texto">Tus pagos se realizan de forma segura con encriptación de 256 bits</p>
                                                        <img src="{{asset('imagenes/security.png')}}" alt="">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="sctn-row">
                                                <button type="submit" class=" btn btn-danger" id="pay-button">Pagar</button>
                                            </div>



                                        </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

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
        <script type="text/javascript" src="https://js.openpay.pe/openpay.v1.min.js"></script>
        <script type='text/javascript' src="https://js.openpay.pe/openpay-data.v1.min.js">
        </script>
        <script src="{{ asset('iniciosesion/registrarse.js') }}" type="module"></script>
        <script src="{{ asset('pagos/pagos.js') }}"></script>

    </body>

    </html>
</body>

</html>