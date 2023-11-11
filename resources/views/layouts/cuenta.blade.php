@extends("layouts.base")
@section("estilos")
<link rel="stylesheet" href="{{asset('cuentas/cuenta.css')}}">
@endsection
@section("contenido")
<div class="card mb-3">
    <div class="card-header position-relative min-vh-25 mb-7">

        <div class="bg-holder rounded-3 rounded-bottom-0" style="background-color: red;">
            <img style="object-fit: cover;height: 200px; width: 100%;background-color:blue;" src="{{asset('falcon/public/assets/img/generic/4.jpg')}}" alt="">
        </div>

        <!--/.bg-holder-->
        @if($empresa)
        <div class="avatar avatar-5xl avatar-profile"><img class="rounded-circle img-thumbnail shadow-sm" src="{{ asset('imagenes/personas/' . $empresa->logo) }}" width="200" alt=""></div>
        @else
        <div class="avatar avatar-5xl avatar-profile"><img class="rounded-circle img-thumbnail shadow-sm" src="{{ asset('falcon/public/assets/img/team/2.jpg') }}" width="200" alt=""></div>
        @endif

    </div>
    <div class="card-body">
        <div class="row">
            <div>@if(session('mensaje'))
                <div class="alert alert-success">
                    {{session('mensaje')}}
                </div>
                @else
                @if(session('error'))
                <div class="alert alert-danger">
                    {{session('error')}}
                </div>
                @endif
                @endif
            </div>
            <div class="col-md-8 col-lg-8">
                <h4 class="mb-1"> {{$user->name }} {{$persona->apellidos}}<span data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Verified" aria-label="Verified"><svg class="svg-inline--fa fa-check-circle fa-w-16 text-primary" data-fa-transform="shrink-4 down-2" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="check-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.625em;">
                            <g transform="translate(256 256)">
                                <g transform="translate(0, 64)  scale(0.75, 0.75)  rotate(0 0 0)">
                                    <path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z" transform="translate(-256 -256)"></path>
                                </g>
                            </g>
                        </svg><!-- <small class="fa fa-check-circle text-primary" data-fa-transform="shrink-4 down-2"></small> Font Awesome fontawesome.com --></span>
                </h4>
                <h5 class="fs-0 fw-normal">{{$user->email}}</h5>
                <h6 class="fs-0 fw-normal">Telefono => {{$persona->telefono}}</h6>
                <p class="text-500">Unido desde => {{$user->email_verified_at}}</p>
                <div class="border-dashed-bottom my-4 d-lg-none"></div>

                <hr>
                <h5>Mi Suscripción</h5>
                <br>
                <h5 class="fs-0 fw-normal text-dark">ID => <span id="su_id" class="text-dark"></span></h5>
                <h5 class="fs-0 fw-normal text-dark">Numero => <span id="su_nu" class="text-dark"></span></h5>
                <h5 class="fs-0 fw-normal text-dark">Estado => <span id="su_es" class="text-dark"></span></h5>
                <h5 class="fs-0 fw-normal text-dark">Monto => <span id="su_cg" class="text-dark"></span></h5>
                <br>
                <h5 id="cancel-sus" hidden class="fs-0 fw-normal text-danger">TU SUSCRIPCION TERMINA EL => <span id="fin_sus" class="text-danger"></span></h5>

                <br>
                <div class="row">
                    <div class="col-12 col-md-6"><button type="button" class="btn btn-danger" id="btn-cancelar">Cancelar Subscripción</button>

                    </div>
                    <div class="col-12 col-md-6">
                        <form action="{{route('suscriptionResume')}}" method="get" id="form-resume">
                            @csrf
                            @if ($estado =="ESPERANDO" || $estado =="INACTIVO" )
                            <button type="submit" class="btn btn-info" id="btn-reanudar">Reanudar Subscripción</button>
                            @else
                            <button type="submit" class="btn btn-info" id="btn-reanudar" hidden>Reanudar Subscripción</button>

                            @endif
                        </form>
                    </div>
                </div>
                <br>
                <hr>

            </div>
            <form action="/Login/ModificarCuenta" id="form-cuenta" method="post" enctype="multipart/form-data" class="col-md-4 col-lg-4">
                @csrf
                <div class="col ps-2 ps-lg-3">

                    <div class="flex-1">
                        <h6 class="mb-0">Cambiar Foto</h6>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                        <label for="" class="form-label alert-success">Se Recomienda una imagen de 512x512</label>


                    </div>

                    <div class="flex-1 mt-2">
                        <h6 class="mb-0">Cambiar Telefono</h6>
                        <input type="number" name="telefono" id="telefono" class="form-control" autofocus required>
                        <hr>
                        <center><Button class="btn btn-success" type="submit"> Registrar</Button></center>
                    </div>



                </div>

            </form>
            <div class="col-lg-12">
                <hr>
                <h5>Mis Pagos</h5>
                <div class="table-responsive">
                    <table class="table" id="tb-pag">
                        <thead>
                            <th>Estado</th>
                            <th>Suscripción</th>
                            <th>Costo</th>
                            <th>Periodo</th>
                            <th>Fecha Pago</th>

                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    @endsection
    @section("scripts")
    <script src="{{asset('vendor/sweetalert/sweetalert.all.js')}}"></script>

    <script src="{{asset('jquery.js')}}"></script>
    <script src="{{asset('cuentas/cuenta.js')}}"></script>
    @endsection