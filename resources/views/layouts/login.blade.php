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
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('falcon/public/assets/img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('falcon/public/assets/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('falcon/public/assets/img/favicons/favicon-16x16.png') }}">
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
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
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
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4"><a class="d-flex flex-center mb-4"
                        href="{{ asset('falcon/public/index.html') }}"><img class="me-2"
                            src="{{ asset('falcon/public/assets/img/icons/spot-illustrations/falcon.png') }}"
                            alt="" width="58" /><span
                            class="font-sans-serif fw-bolder fs-5 d-inline-block">falcon</span></a>
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
                            <form id="form-iniciar-sesion">
                                @csrf
                                <div class="mb-3">
                                    <input class="form-control" type="email" placeholder="Email address" id="email"/>
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" type="password" placeholder="Password" id="password" />
                                </div>
                                <div class="row flex-between-center">

                                    <div class="col-auto"><a class="fs--1"
                                            href="{{ asset('falcon/public/pages/authentication/simple/forgot-password.html') }}">Olvidaste
                                            tu Contraseña?</a></div>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                        name="submit" id="btn-iniciar-sesion">Iniciar Sesión</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog        ">
                <div class="modal-content">
                    <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                        <div class="position-relative z-index-1 light">
                            <h4 class="mb-0 text-white">Registrarse</h4>
                            <p class="fs--1 mb-0 text-white">Por favor crea tu cuenta BodeGest </p>
                        </div>
                        <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4 px-5">
                        <form>

                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="modal-auth-name">Nombres</label>
                                <input class="form-control" type="text" autocomplete="on" id="modal-auth-name"
                                    name="modal-auth-name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="modal-auth-name">Apellidos</label>
                                <input class="form-control" type="text" autocomplete="on"
                                    id="modal-auth-apellidos" name="modal-auth-apellidos" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="modal-auth-email">Email </label>
                                <input class="form-control" type="email" autocomplete="on" id="modal-auth-email"
                                    name="modal-auth-email" required>
                            </div>
                            <div class="row gx-2">
                                <div class="mb-3 col-sm-6">
                                    <label class="form-label" for="modal-auth-password">Password</label>
                                    <input class="form-control" type="password" autocomplete="on"
                                        id="modal-auth-password" name="modal-auth-password" required>
                                </div>

                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="modal-auth-register-checkbox"
                                    checked>
                                <label class="form-label" for="modal-auth-register-checkbox">I accept the <a
                                        href="#!">terms </a>and <a href="#!">privacy policy</a></label>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    id="btn-registrarse" name="submit" value="Registrarse">Registrarse</button>
                            </div>
                        </form>

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
    <script src="{{ asset('iniciosesion/registrarse.js') }}" type="module"></script>
</body>

</html>
