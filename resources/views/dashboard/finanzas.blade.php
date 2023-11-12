@extends("layouts.base")
@section("estilos")
<link rel="stylesheet" href="{{asset('dashboard/finanzas.css')}}">
@endsection
@section("contenido")
<div class="container">
    @if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    <div class="card">

        <h4 class="card-title">Mis Finanzas</h4>
        <form action="/Finanzas/SaveBalance" method="post" id="miform">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-6 col-md-4">
                        <label for="f-inicio">Fecha de Termino del Balance Anterior</label>
                        <input type="text" name="f-anterior" id="f-anterior" class="form-control text-info" value="{{$anterior->format('d-m-Y')}}" readonly>
                    </div>
                    <div class="col-6 col-md-3">
                        <label for="">Saldo en Caja</label>

                        <label for="" class="form-control btn-warning" id="saldo-caja">{{$saldo}}</label>
                    </div>
                    <div class="col-6 col-md-5">
                        <label for="r-periodo">Periodo de Balance</label>
                        <select name="periodo" id="periodo" class="form-select">
                            <option value="0" selected>Seleccione un Periodo</option>
                            <option value="semanal">Semanal</option>
                            <option value="quincenal">Quincenal</option>
                            <option value="mensual">Mensual</option>
                            <option value="trimestral">Trimestral</option>
                            <option value="anual">Anual</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6 col-lg-3">
                        <div class="t-r">
                            <label for="f-inicio">Fecha de Inicio del Nuevo Balance</label>
                            <input type="text" name="f-inicio" id="f-inicio" class="form-control text-success" value="{{$ultimo->format('d-m-Y')}}" readonly>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="t-r">
                            <label for="f-termino">Fecha de Termino del Nuevo Balance</label>
                            <input type="text" name="f-termino" id="f-termino" class=" form-control text-danger" readonly>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <label for="">Total compras</label><br>
                        <label class="montos" id="monto-compra">0.0</label>
                    </div>
                    <div class="col-6 col-lg-3">
                        <label for="">Total Ventas</label> <br>
                        <label class="montos" id="monto-venta">0.0</label>
                    </div>
                </div>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 col-md-4 col-lg-4">

                                <h6>Todas las Compras</h6>
                                <hr>
                                <ul id="lista-compras">
                                </ul>

                            </div>
                            <div class="col-6 col-md-4 col-lg-4">

                                <h6>Todas las Ventas</h6>
                                <hr>
                                <ul id="lista-ventas">

                                </ul>

                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Panel de Opciones</h6>
                                        <div class="row">
                                            <div class="col-12">
                                                <p>En Base al Total de las Ventas menos el Monto de Compras, mas el saldo en caja, el Total
                                                    en Caja es => <span class="btn-warning" id="t-caja">0.0</span>
                                                    <=>
                                                        tu decides!.¿Cuanto vas a Retirar? <span> <input class="form-control" type="number" name="m-retiro" id="m-retiro" step="0.01"> </span>
                                                        lo que estas dejando en Caja es <span class="btn-danger" id="n-caja"></span>
                                                </p>
                                                <button class="btn btn-success" id="g-operacion" type="submit"> Grabar </button>
                                                <button class="btn btn-info" id="n-operacion" type="button"> Nuevo </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
@section("scripts")
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
<script src="{{asset('jquery.js')}}"></script>
<script src="{{asset('dashboard/finanzas.js')}}"></script>
@endsection