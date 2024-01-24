@extends("layouts.base")
@section("estilos")
<link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">

<link rel="stylesheet" href="{{asset('compras/compras.css')}}">
@endsection

@section("contenido")
<div class="row m-1">
    @if(session('mensaje'))
    <div class="alert alert-success">
        {{ session('mensaje') }}
    </div>
    @endif

    <div class="card p-0 col-lg-12">
        <h3 class="m-4">Mis Compras</h3>
        <hr>
        <div class="boton-ayuda"><button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-ayuda">Ayuda <i class="fas fa-question"></i></button></div>
    </div>

</div>
<form id="form-compra" method="post" enctype="multipart/form-data" action="/Compras/CrearCompra">
    @csrf
    <div class="row m-1">
        <div class="card p-0 col-lg-12">

            <div class="row p-3">
                <div class="col-lg-3">
                    <label for="codigo" class="form label">Compra N°</label>
                    <input type="text" name="codigo" id="codigo" autocomplete="name" class="form-control" disabled>

                </div>
                <div class="col-lg-6">
                    <label for="proveedor" class="form label">Proveedor</label>
                    <div id="div-proveedor">
                        <input type="text" readonly name="proveedor" id="proveedor" autocomplete="name" class="form-control">
                        <button class="btn btn-info" id="btn-proveedor" data-bs-toggle="modal" data-bs-target="#modal-proveedores"><i class="fas fa-search"></i></button>
                    </div>

                </div>
                <div class="col-lg-3">
                    <label for="metodo" class="form label">Metodo de Pago</label>
                    <input type="text" name="metodo" id="metodo" autocomplete="name" class="form-control" onkeyup="this.value=this.value.toUpperCase();">

                </div>
            </div>

        </div>

    </div>
    <div class="row m-1">
        <div class=" card col-lg-6 p-2">
            <label for="" class="form-label">Comprobante</label>
            <br>
            <input type="file" name="comprobante" id="comprobante" class="form-control" accept="image/*">
            <div class="table-responsive" hidden>
                <table class="table" id="tabla-compra">
                    <thead>
                        <th id="compra-id">Id</th>
                        <th>Descripcion</th>
                        <th id="compra-precio">Precio</th>
                        <th id="compra-cantidad">Cantidad</th>
                        <th id="compra-total">Total</th>

                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="card col-lg-3 p-2">
            <label for="fecha" class="form-label">Fecha de la Compra</label>
            <input type="date" name="fecha" id="fecha" class="form-control">
            <hr>
            <label for="total-compra" class="form-label">Total Compra</label>
            <input type="text" name="total-compra" id="total-compra" class="form-control">
        </div>
        <div class="card col-lg-3">
            <div id="div-opcion-botones" class="p-2">
                <label for="" class="form-label">Panel de Opciones</label>
                <br>
                <button class="btn btn-success" id="registrar-compra" type="submit">Registrar Compra</button>
            </div>
        </div>
    </div>
</form>
<div class="modal fade" id="modal-ayuda" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="staticBackdropLabel">Todo lo Que Necesitas Saber</h4>
                    <p class="fs--2 mb-0">Añadido por <a class="link-600 fw-semi-bold">Bodegest</a></p>
                </div>
                <div class="row p-4">
                    <div class="card col-lg-6">
                        <h5 class="titulos">Compras</h5>
                        <hr>
                        <p>Para registrar una compra debes de completar todos los Campos.</p>
                    </div>
                    <div class="card col-lg-6">
                        <h5 class="titulos">Proveedores</h5>
                        <hr>
                        <p>Es Necesario que Primero los Proveedores esten Registrados en el Sistema <br>Al registrar a los proveedores en el sistema, se pueden llevar un seguimiento de las compras o servicios que ofrecen, los precios y las condiciones de compra. De esta manera, cuando se necesita adquirir un producto o servicio de un proveedor en particular, se puede acceder a su información de manera rápida y sencilla.

                        </p>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-proveedores" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="staticBackdropLabel">Lista de Proveedores Registrados</h4>
                    <p class="fs--2 mb-0">Añadido por <a class="link-600 fw-semi-bold">Bodegest</a></p>
                </div>
                <div class="p-0">
                    <div class="card p-2">
                        <div class="table-responsive">

                            <table class="table" id="tabla-proveedores">
                                <thead class="thead-light">
                                    <tr>
                                        <th id="th-id">Id</th>
                                        <th>Proveedor</th>
                                        <th id="th-telefono">Telefono</th>
                                        <th id="th-pais">Pais</th>
                                        <th id="th-opciones">Opciones</th>
                                    </tr>
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
                    <div class="card p-2">
                        <div class="table-responsive">

                            <table class="table" id="tabla-productos">
                                <thead>
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
<script src="{{ asset('compras/compras.js') }}"></script>

@endsection