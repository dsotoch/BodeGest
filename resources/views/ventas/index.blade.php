@extends("layouts.base")
@section("estilos")
<link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">

<link rel="stylesheet" href="{{asset('ventas/ventas.css')}}">
@endsection
@section("contenido")
<div class="card">
    <div class="row  m-1">

        <div class="col-lg-6 ">
            <h5>Generar Nueva Venta</h5>
        </div>
        <div class="col-lg-6 alt-derecha">
            <div class="search">
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal-productos" id="btn-productos"><i class="fas fa-search"></i>Buscar Productos </button>
            </div>
            <div class="search">
                <button disabled class="btn-dark"><i class="fas fa-coins"></i> </button>
                <select name="moneda" id="moneda" class="form-select">
                    <option value="soles" selected>Soles</option>
                    <option value="dolares">Dolares</option>

                </select>
            </div>



        </div>
    </div>
    <div class="row m-1">
        <div class="col-lg-3">
            <label for="documento" class="form-label">Documento N°</label>
            <input type="text" name="documento" id="" class="form-control" autocomplete="name" disabled>
        </div>
        <div class="col-lg-3">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" autocomplete="name">
        </div>
        <div class="col-lg-3">
            <label for="iva" class="form-label">Incluye IVA</label>
            <select name="iva" id="iva" class="form-select">
                <option value="si" selected> SI</option>
                <option value="no"> NO</option>

            </select>
            <input type="hidden" value="{{$igv}}" id="igv">
        </div>
        <div class="col-lg-3">
            <label for="remision" class="form-label">Nota de Remision</label>
            <input type="text" name="remision" id="remision" class="form-control" autocomplete="name">
        </div>
    </div>
    <div class="row m-1">
        <div class="col-lg-5">
            <label for="cliente" class="form-label">Cliente </label>
            <input type="text" name="cliente" id="cliente" class="form-control" autocomplete="name">
        </div>
        <div class="col-lg-4">
            <label for="pago" class="form-label">Forma de Pago </label>
            <select name="pago" id="pago" class="form-select">
                <option value="contado" selected> Contado</option>
                <option value="credito"> A Credito</option>
                <option value="parcial"> Parcial</option>

            </select>
        </div>
        <div class="col-lg-3">
            <label for="monto" class="form-label">Cuanto Cancelo?</label>
            <input type="number" name="monto" class="form-control" id="monto" autocomplete="name" step="0.01">
        </div>
    </div>
    <hr>
    <div class="row m-1">
        <div class="col-lg-9 ">
            <div class="table-responsive">
                <table class="table" id="tabla-ventas">
                    <thead class="btn-info">
                        <th id="th-id">Id</th>
                        <th>Producto</th>
                        <th id="th-precio">Precio</th>
                        <th id="th-cantidad">Cantidad</th>
                        <th id="th-total">Total</th>
                        <th id="th-accion">Accion</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-3 p-4">
            <label for="t-pagar" class="form-label">Total a Pagar</label>
            <input type="number" name="t-pagar" id="t-pagar" step="0.01" class="form-control">
            <label for="t-recibido" class="form-label">Total Recibido</label>
            <input type="number" name="t-recibido" id="t-recibido" step="0.01" class="form-control">
            <label for="t-cambio" class="form-label">Cambio</label>
            <input type="number" name="t-cambio" id="t-cambio" step="0.01" class="form-control" disabled>
            <hr>
            <button class="btn btn-success">Vender</button>
            <button class="btn btn-danger">Nuevo</button>
        </div>

        <div class="col-lg-9 pb-4">
            <div class="row">
                <div class="col-lg-4"><label for="">SubTotal</label><input type="text" disabled id="p-subtotal" class="form-control"></div>
                <div class="col-lg-4"><label for="">Impuesto %</label><input type="text" disabled id="p-igv" class="form-control"></div>
                <div class="col-lg-4"><label for="">Total</label><input type="text" disabled id="p-total" class="form-control"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-productos" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="staticBackdropLabel">Lista de Productos Registrados</h4>
                    <p class="fs--2 mb-0">Añadido por <a class="link-600 fw-semi-bold">Bodegest</a></p>
                </div>
                <div class="p-0">
                    <div class="p-2 mod-ca"><label for="cantidad" id="t-cant">CANTIDAD</label><input class="form-control" type="number" step="0.01" id="cantidad"></div>
                    <div class="card p-2">
                        <div class="table-responsive">

                            <table class="table" id="tabla-productos">
                                <thead class="btn-danger">
                                    <th>Id</th>
                                    <th>Producto</th>
                                    <th>Presentacion</th>
                                    <th>Stock</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Venta</th>
                                    <th>Accion</th>

                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section("scripts")
<script src="{{ asset('jquery.js') }}"></script>
<script src="{{ asset('DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
<script src="{{ asset('ventas/ventas.js') }}"></script>

@endsection