@extends('layouts.base')
@section('estilos')
<link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">

<link rel="stylesheet" href="{{ asset('ventas/ventas.css') }}">
@endsection
@section('contenido')

<div class="card">
    <form action="{{route('crearVenta')}}" method="post" id="miform">
        @csrf
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
                    <select name="moneda" id="moneda" class="form-select" required>
                        <option value="soles" selected>Soles</option>
                        <option value="dolares">Dolares</option>

                    </select>
                </div>



            </div>
        </div>
        <div class="row m-1">
            <div class="col-lg-3">
                <label for="documento" class="form-label">Documento N°</label>
                <input type="text" name="documento" id="documento" class="form-control" autocomplete="name" readonly required>
            </div>
            <div class="col-lg-3">
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" autocomplete="name" value="{{$fecha}}" required>
            </div>
            <div class="col-lg-3">
                <label for="iva" class="form-label">Incluye IVA</label>
                <select name="iva" id="iva" class="form-select" required>
                    <option value="si" selected> SI</option>
                    <option value="no"> NO</option>

                </select>
                <input type="hidden" value="{{ $igv }}" id="igv">
            </div>
            <div class="col-lg-3">
                <label for="remision" class="form-label">Nota de Remision</label>
                <input type="text" name="remision" id="remision" class="form-control" autocomplete="name">
            </div>
        </div>
        <div class="row m-1">
            <div class="col-lg-5">

                <label for="cliente" class="form-label">Cliente </label>
                <div class="buscador"> <input type="text" id="buscador-cliente" placeholder="Buscar opción..." class="form-control">
                    <span type="button" class="ml-2 btn btn-primary" title="Nuevo Cliente" data-bs-toggle="modal" data-bs-target="#modal-cliente"><i class="fas fa-plus-circle"></i> </span>
                </div>
                <select id="seleccion" class="form-select" name="cliente_dni" required>
                    <option value="" selected>Seleccione una Opción</option>
                    @foreach ($clientes as $n)
                    <option value="{{$n->dni}}" >{{$n->cliente}} -- {{$n->dni}}</option>

                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                <label for="pago" class="form-label">Forma de Pago </label>
                <select name="pago" id="pago" class="form-select" required>
                    <option value="contado" selected> Contado</option>
                    <option value="credito"> A Credito</option>
                    <option value="parcial"> Parcial</option>
                    <option value="yape"> Yape</option>


                </select>
            </div>
            <div class="col-lg-3">
                <label for="monto" class="form-label">Cuanto Canceló?</label>
                <input type="number" name="monto" class="form-control" id="monto" autocomplete="name" step="0.01" readonly>
            </div>
        </div>
        <hr>
        <div class="row m-1">
            <div class="col-lg-9 ">
                <div class="table-responsive">
                    <table class="table" id="tabla-ventas" name="tabla-ventas">
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
            <input type="[]" name="array_productos" id="array_productos" hidden>
            <input type="[]" name="array_productos2" id="array_productos2" hidden>
            <div class="col-lg-3 p-4">
                <label for="t-pagar" class="form-label">Total a Pagar</label>
                <input type="number" name="t-pagar" id="t-pagar" step="0.01" class="form-control" required readonly>
                <label for="t-recibido" class="form-label">Total Recibido</label>
                <input type="number" name="t-recibido" id="t-recibido" step="0.01" class="form-control" required>
                
                <hr>
                <button class="btn btn-success" id="btn-vender" type="submit">Vender</button>
                <button class="btn btn-danger" type="reset">Nuevo</button>
            </div>

            <div class="col-lg-9 pb-4">
                <div class="row">
                    <div class="col-lg-4"><label for="">SubTotal</label><input type="text" disabled id="p-subtotal" class="form-control"></div>
                    <div class="col-lg-4"><label for="">Impuesto %</label><input type="text" disabled id="p-igv" class="form-control"></div>
                    <div class="col-lg-4"><label for="">Total</label><input type="text" disabled id="p-total" class="form-control"></div>
                </div>
            </div>
        </div>
    </form>
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
                    <div class="p-2 mod-ca"><label for="cantidad" id="t-cant">CANTIDAD</label><input class="form-control btn-danger" type="number" step="0.01" id="cantidad"></div>
                    <div class="p-2 mod-ca "><button class="btn btn-info btn-icon-text" data-bs-toggle="modal" data-bs-target="#nuevo-producto"><i class="fas fa-cart-arrow-down btn-icon-prepend" id="t-cant"></i>Otro Producto</button></div>

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
<div class="modal fade" id="nuevo-producto" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="staticBackdropLabel">Otro Producto</h4>
                    <p class="fs--2 mb-0">Añadido por <a class="link-600 fw-semi-bold">Bodegest</a></p>
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="d-flex"><span class="fa-stack ms-n1 me-3"><i class="fas fa-circle fa-stack-2x text-200"></i><i class="fa-inverse fa-stack-1x text-primary fas fa-tag" data-fa-transform="shrink-2"></i></span>
                                <div class="flex-1">

                                    <div class="d-flex">
                                        <form class="row g-3 needs-validation" novalidate="">
                                            <div class="col-md-6 position-relative">
                                                <label class="form-label" for="descripcion">Descripcion</label>
                                                <input class="form-control" id="o-presentacion" name="o-presentacion" type="text" autocomplete="name" required="" />
                                                <div class="invalid-tooltip">Por favor, ingrese una descripción valida.
                                                </div>
                                            </div>

                                            <div class="col-md-4 position-relative">
                                                <label class="form-label" for="stock-form">Cantidad</label>
                                                <input class="form-control" id="o-cantidad" value="1" type="number" step="0.01" required="" />
                                                <div class="invalid-tooltip">Por favor, ingrese una cantidad valida.
                                                </div>
                                            </div>

                                            <div class="col-md-4 position-relative">
                                                <label class="form-label" for="validationTooltipUsername">Precio
                                                    Venta</label>

                                                <input class="form-control" id="precioVenta" type="number" step="0.01" aria-describedby="precioVenta" required="" />
                                                <div class="invalid-tooltip">Por favor, ingrese un Precio Venta
                                                    valido.
                                                </div>

                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-primary" type="submit" id="btn-otro-articulo"><i class="fas fa-cart-arrow-down " id="t-cant"></i>Agregar</button>
                                            </div>
                                        </form>

                                    </div>
                                    <hr class="my-4" />
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-cliente" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="staticBackdropLabel">Nuevo Cliente</h4>
                    <p class="fs--2 mb-0">Añadido por <a class="link-600 fw-semi-bold">Bodegest</a></p>
                </div>

                <div class="card p-2">
                    <form action="" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mt-1">
                                <label for="cliente-n" class="form-label">Cliente</label>
                                <input type="text" name="cliente-n" id="cliente-n" class="form-control" onkeyup="this.value=value.toUpperCase();">
                            </div>
                            <div class="col-lg-6 mt-1">
                                <label for="correo-n" class="form-label">Correo Electronico</label>
                                <input type="email" name="correo-n" id="correo-n" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-1"> <label for="dni-n" class="form-label">Dni</label>
                                <input type="number" name="dni-n" id="dni-n" class="form-control">
                            </div>

                            <div class="col-lg-6 mt-1 mb-1"> <label for="telefono-n" class="form-label">Telefono</label>
                                <input type="number" name="telefono-n" id="telefono-n" class="form-control">
                            </div>
                            <hr>
                            <div class="col-lg-12 mt-1  elementos-derecha"><button type="submit" class="btn btn-success" id="btn-guardar-cliente"><i class="fas fa-plus"> </i>Agregar</button></div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('jquery.js') }}"></script>
<script src="{{ asset('DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
<script src="{{ asset('ventas/ventas.js') }}"></script>
@endsection