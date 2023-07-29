@extends('layouts.base')
@section("estilos")
<style>
    .flex{
        display: flex;
        justify-content: flex-end;
    }
</style>
@endsection

@section("contenido")
<div class="card">
    <div class="p-4">
        <h5>Detalles de la Compra por Busqueda</h5>
        <hr>
    </div>
    <div class="row p-4">
        <div class="col-12">
            <label for="" class="form-label"> No sabes el Codigo de Compra?</label>
            <br>
            <button class="btn btn-info" data-bs-target="#modal" data-bs-toggle="modal">Ver Todos</button>


        </div>
        <hr>
        <div class="col-12 col-md-4 col-lg-4">
            <label for="c-venta" class="form-label">Ingrese el Codigo de la Compra </label>
            <div class="flex">
            <input type="text" id="c-compra" class="form-control">
            <button id="c-compras" class="btn btn-info"> <i class="fas fa-search"></i></button>
            </div>
           
        </div>
        <div class="col-6 col-md-4 col-lg-4">
            <label for="" class="form-label">Metodo de Pago</label>
            <label for="" class="form-control btn-success" id="metodo_pago">SIN BUSQUEDA </label>
            <hr>
            <label for="" class="form-label">Total Compra</label>
            <label for="" class="form-control btn-success" id="total_compra">SIN BUSQUEDA </label>
        </div>
        <div class="col-6 col-md-4 col-lg-4">
            <label for="" class="form-label">Fecha Compra</label>
            <label for="" class="form-control btn-success" id="fecha">SIN BUSQUEDA </label>
            <hr>
            <label for="" class="form-label">Proveedor</label>
            <label for="" class="form-control btn-success" id="proveedor">SIN BUSQUEDA </label>
        </div>
        <hr>
        <div class="col-12">
            <center>
                <h5>Comprobante</h5>
                <canvas id="imagen">

                </canvas>
            </center>




        </div>

    </div>
    <div class="modal fade" id="modal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg mt-6" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                        <h4 class="mb-1" id="staticBackdropLabel">Lista de Compras Registradas</h4>
                        <p class="fs--2 mb-0">Añadidos por <a class="link-600 fw-semi-bold">Bodegest</a></p>
                    </div>
                    <div class="p-0">
                        <div class="card p-4">
                            <div class="table-responsive">

                                <table class="table" id="tabla-compras">
                                    <thead style="background-color:blue;color:white">
                                        <th>Codigo</th>
                                        <th>Fecha</th>
                                        <th>Monto</th>
                                        <th>Pago</th>
                                        <th>Proveedor</th>


                                    </thead>
                                    <tbody>
                                        @foreach ($compras as $n)
                                        <tr>
                                            <td>{{$n->id}}</td>
                                            <td>{{$n->fecha}}</td>
                                            <td>{{$n->totalCompra}}</td>
                                            <td>{{$n->metodoPago}}</td>
                                            <td>{{$n->provedor}}</td>

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
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('jquery.js')}}"></script>
<script src="{{asset('DataTables/datatables.min.js')}}"></script>

<script src="{{asset('vendor/sweetalert/sweetalert.all.js')}}"></script>

<script src="{{asset('detalles/compra.js')}}"></script>

@endsection