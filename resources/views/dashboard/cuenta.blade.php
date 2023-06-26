@extends("layouts.base")
@section("estilos")
<link rel="stylesheet" href="{{asset('dashboard/cuenta.css')}}">
<link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">

@endsection
@section("contenido")
<div class="card">
    <div class="card-body">
        <div class="p-2">

            <h3>Las Cuentas de mis Clientes</h3>

        </div>
        <hr>
        <div class="row">
            <div class=" center col-6 col-lg-3 info">

                <label for=""> Total de Cuentas sin Pagar
                </label>
                <center><a class="btn btn-primary" href="#" data-filter="grafico" id="mayores">Mostrar {{$todos}}</a></center>

            </div>


            <div class=" center col-6 col-lg-3 danger">

                <label for=""> Cuentas con Deuda mayor a 15 dias</label>
                <center><a class="btn btn-danger" href="#" data-filter="mayores" id="mayores">Mostrar</a></center>

            </div>
            <div class="center col-6 col-lg-3 warning">

                <label for="">Cuentas Mayores a 100</label>
                <center><a class="btn btn-warning" href="#" data-filter="todas" id="mayores">Mostrar</a></center>
            </div>
            <div class="center col-6 col-lg-3 dark">

                <label for="">Saldos Anteriores</label>
                <center><a class="btn btn-dark" href="#" data-filter="saldos" id="mayores">Mostrar</a></center>
            </div>

        </div>

        @if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
        @else
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <div class="row">

            <div class="contenido" data-filter="grafico">
                <div class="col-lg-12">
                    <label for="" class="form-control" id="titulo-todos"> Total de Cuentas sin Pagar : {{$todos}}</label>
                    <hr>
                    <div class="table-responsive">
                        <table id="tabla-todos" class="table">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th class="w-15">Fecha Inicial</th>
                                    <th class="w-10">Monto Deuda</th>
                                    <th class="w-10">Inicial</th>
                                    <th class="w-10">Total Deuda</th>
                                    <th class="w-10">Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($deudas as $n)

                                <tr>
                                    <td>{{$n->cliente->dni}}-{{$n->cliente->cliente}}</td>
                                    <td>{{$n->fecha_minima}}</td>
                                    <td>{{$n->total_venta}}</td>
                                    <td>{{$n->monto_inicial}}</td>
                                    <td>{{$n->monto_deuda}}</td>
                                    <td class="inline"><button class="btn btn-success" id="detalles" title="Ver Detalles" data-bs-toggle="modal" data-bs-target="#modal-detalles"><i class="fas fa-eye"></i> </button>
                                        <button class="btn btn-warning" id="pagar-cuenta" title="Pagar Cuenta" data-bs-toggle="modal" data-bs-target="#modal-pagar"><i class="fas fa-money-bill-alt"></i> </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

            <div data-filter="mayores" class="contenido">
                <div class="col-lg-12">
                    <label for="" class="form-control" id="titulo-mayores15"> Cuentas Mayores a 15 Dias : {{$mayores15}}</label>
                    <hr>
                    <div class="table-responsive">
                        <table id="tabla-mayores15" class="table">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th class="w-15">Fecha Inicial</th>
                                    <th class="w-10">Monto Deuda</th>
                                    <th class="w-10">Inicial</th>
                                    <th class="w-10">Total Deuda</th>
                                    <th class="w-10">Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cliente as $n)

                                <tr>
                                    <td>{{$n->cliente->dni}}-{{$n->cliente->cliente}}</td>
                                    <td>{{$n->fecha_minima}}</td>
                                    <td>{{$n->total_venta}}</td>
                                    <td>{{$n->monto_inicial}}</td>

                                    <td>{{$n->monto_deuda}}</td>
                                    <td><button class="btn btn-success" id="detalles" title="Ver Detalles" data-bs-toggle="modal" data-bs-target="#modal-detalles"><i class="fas fa-eye"></i> </button>
                                        <button class="btn btn-warning" id="pagar-cuenta" title="Pagar Cuenta" data-bs-toggle="modal" data-bs-target="#modal-pagar"><i class="fas fa-money-bill-alt"></i> </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

            <div data-filter="todas" class="contenido">
                <div class="col-lg-12">
                    <label for="" class="form-control" id="titulo-mayores100"> Cuentas Mayores a 100(USD u S/) : {{$mayores100}}</label>
                    <hr>
                    <div class="table-responsive">
                        <table id="tabla-mayores100" class="table">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th class="w-15">Fecha Inicial</th>
                                    <th class="w-10">Monto Deuda</th>
                                    <th class="w-10">Inicial</th>
                                    <th class="w-10">Total Deuda</th>
                                    <th class="w-10">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clientes as $n)

                                <tr>
                                    <td>{{$n->clientes->dni}}-{{$n->clientes->cliente}}</td>
                                    <td>{{$n->fecha_minima}}</td>
                                    <td>{{$n->total_venta}}</td>
                                    <td>{{$n->monto_inicial}}</td>
                                    <td>{{$n->monto_deuda}}</td>
                                    <td><button class="btn btn-success" id="detalles" title="Ver Detalles" data-bs-toggle="modal" data-bs-target="#modal-detalles"><i class="fas fa-eye"></i> </button>
                                        <button class="btn btn-warning" id="pagar-cuenta" title="Pagar Cuenta" data-bs-toggle="modal" data-bs-target="#modal-pagar"><i class="fas fa-money-bill-alt"></i> </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>

            </div>
            <div data-filter="saldos" class="contenido">
                <div class="col-lg-12">
                    <label for="" class="form-control" id="titulo-saldos"> Saldos de Cuentas Anteriores</label>
                    <hr>
                    <div class="table-responsive">
                        <table id="tabla-saldos" class="table">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th class="w-15">Ultimo Pago</th>
                                    <th class="w-10">Monto Deuda</th>
                                    <th class="w-10"> Monto Cancelado</th>
                                    <th class="w-10">Saldo</th>
                                    <th class="w-10">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($saldos as $n)

                                <tr>
                                    <td>{{$n->clientes->dni}}-{{$n->clientes->cliente}}</td>
                                    <td>{{$n->fecha}}</td>
                                    <td>{{$n->monto_deuda}}</td>
                                    <td>{{$n->monto_recibido}}</td>
                                    <td>{{$n->monto_restante}}</td>
                                    <td>
                                        <button class="btn btn-success" id="pagar-cuenta-saldos" title="Pagar Cuenta" data-bs-toggle="modal" data-bs-target="#modal-pagar"><i class="fas fa-money-bill-alt"></i> </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<!--MODAL DETALLES DE CUENTA-->
<div class="modal fade" id="modal-detalles" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="/Cuentas/EnviarEmail" method="post" id="form">
                @csrf
                <textarea type="text" name="imagen" id="imagen" hidden></textarea>
                <div class="modal-body p-0" id="cuenta">
                    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                        <h4 class="mb-1" id="staticBackdropLabel">Cuenta del Cliente </h4>
                        <p class="fs--2 mb-0">Con DNI <input type="text" class="link-600 fw-semi-bold" name="dni" id="dni" readonly></p>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-12">

                            <table class="table table-responsive" id="tabla-detalles">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Producto</th>
                                        <th>Inicial</th>
                                        <th>Igv</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                            <div><label for="" id="detalles-foot"></label> </div>

                        </div>
                    </div>
                </div>
                <hr>

                <div class="div-derecha p-2">
                    <button class="btn btn-danger btn-comprobante b" type="button" title="Guardar Comprobante"> <i class="fas fa-image"></i> </button>
                    <button class="btn btn-info btn-enviar-email b" type="submit" title="Enviar por Correo al Cliente"> <i class="fas fa-envelope"></i> </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- MODAL PAGAR-->
<div class="modal fade" id="modal-pagar" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" id="pagar">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="staticBackdropLabel2">Cuenta del Cliente </h4>
                    <p class="fs--2 mb-0">Con DNI <input type="text" class="link-600 fw-semi-bold" name="dni" id="dni2" readonly></p>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <label for="fecha" class="form-label"> Fecha de Pago</label>
                                <input type="date" name="fecha" id="fecha" class="form-control">
                            </div>
                            <div class=" col-6 col-lg-6"> <label for="total-pagar" class="form-label">Total a Pagar</label>
                                <input type="number" name="total-pagar" id="total-pagar" step="0.01" class="form-control" disabled>
                            </div>
                            <div class="col-6 col-lg-6">
                                <label for="total-pagar" class="form-label">Total Recibido</label>

                                <input type="number" name="monto-dado" id="monto-dado" step="0.01" class="form-control" disabled>
                            </div>
                        </div>



                    </div>
                </div>

            </div>
            <hr>

            <div class="div-derecha p-2">
            <button class="btn btn-success btn-pagar-saldos b" type="button" title="Pagar Cuenta" >Pagar</button>
                <button class="btn btn-primary btn-pagar b" type="button" title="Pagar Cuenta"  >Pagar</button>
            </div>

        </div>
    </div>
</div>
@endsection
@section("scripts")
<script src="{{asset('jquery.js')}}"></script>
<script src="{{asset('html2.js')}}"></script>
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

<script src="{{ asset('DataTables/datatables.min.js') }}"></script>
<script src="{{asset('dashboard/cuenta.js')}}"></script>
@endsection