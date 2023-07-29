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
        <h5>Detalles de la Venta por Busqueda</h5>
        <hr>
    </div>
    <div class="row p-4">

        <div class="col-6">
            <label for="c-venta" class="form-label">Ingrese el Codigo de Venta </label>
            <div class="flex">
            <input type="text" id="c-venta" class="form-control">
            <button class="btn btn-info" id="c-ventas"> <i class="fas fa-search"></i></button>
            </div>
            
        </div>
        <div class="col-6">
            <label for="" class="form-label">Estado de la Venta</label>
            <label for="" class="form-control btn-success" id="estado_venta">SIN BUSQUEDA </label>
        </div>
        <div class="col-12 table-responsive">

            <table class="table">
                <thead>
                    <tr>
                        <td>Cliente : <span id="cliente">Sin Busqueda </span></td>
                        <td>Fecha : <span id="fecha">Sin Busqueda </span></td>
                        <td>Monto Venta : <span id="monto_venta">Sin Busqueda </span></td>
                        <td>Metodo de Pago : <span id="metodo_pago">Sin Busqueda </span></td>

                    </tr>
                </thead>
            </table>
            <table class="table" id="tabla_productos">
                <thead>
                    <tr>
                        <td>Producto</td>
                        <td>Precio</td>
                        <td>Cantidad</td>
                        <td>Total</td>
                    </tr>
                </thead>
                <tbody>

                </tbody>


            </table>




        </div>

    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('jquery.js')}}"></script>
<script src="{{asset('vendor/sweetalert/sweetalert.all.js')}}"></script>

<script src="{{asset('detalles/venta.js')}}"></script>

@endsection