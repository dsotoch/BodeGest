@extends('layouts.base')
@section('estilos')
<link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('articulos/articulo.css') }}">
@endsection
@section('contenido')
<div class="row g-3 mb-3">
    <div class="col-md-4 col-lg-2 col-xl-4 col-xxl-2">
        <div class="card h-md-100 ecommerce-card-min-width">
            <div class="card-header pb-0">
                <h6 class="mb-0 mt-2 d-flex align-items-center">Productos Con Stock

                </h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-end">
                <div class="row">
                    <div class="col">
                        <p class="font-sans-serif lh-1 mb-1 fs-4" id="stock">{{ $stock }}</p><span class="badge badge-soft-success rounded-pill fs--2">{{ $porcentaje }}%</span>
                    </div>
                    <div class="col-auto ps-0">

                        <img src="{{ asset('imagenes/articulos/conStock.png') }}" alt="" class="echart-bar-weekly-sales h-100" style="-webkit-tap-highlight-color: transparent; user-select: none; position: relative;" _echarts_instance_="ec_1680579470913">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2 col-xl-4 col-xxl-2">
        <div class="card h-md-100 ecommerce-card-min-width">
            <div class="card-header pb-0">
                <h6 class="mb-0 mt-2 d-flex align-items-center">Productos Sin Stock

                </h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-end">
                <div class="row">
                    <div class="col">
                        <p class="font-sans-serif lh-1 mb-1 fs-4" id="sin-stock">{{ $sin_stock }}</p><span class="badge badge-soft-success rounded-pill fs--2">{{ $porcentaje_sin_stock }}%</span>
                    </div>
                    <div class="col-auto ps-0">

                        <img src="{{ asset('imagenes/articulos/sinStock.png') }}" alt="" class="echart-bar-weekly-sales h-100" style="-webkit-tap-highlight-color: transparent; user-select: none; position: relative;" _echarts_instance_="ec_1680579470913">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2 col-xl-4 col-xxl-2">
        <div class="card h-md-100">
            <div class="card-header pb-0">
                <h6 class="mb-0 mt-2 d-flex align-items-center">Panel de Opciones

                </h6>
            </div>
            <div class="card-body">

                <div class="row h-100 justify-content-between g-0">
                    <div class="col-12 col-sm-12 col-xxl-12 pe-2 d-flex justify-content-center align-items-center">

                        <div class="btn-group-vertical" role="group" aria-label="Vertical button group" role="group">
                            <button class="btn btn-falcon-success me-1 mb-1 btn-icon-prepend" type="button" title="Click para Agregar un Nuevo Articulo" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-plus btn-icon-text"></i>
                                Agregar</button>
                            <button class="btn btn-falcon-success me-1 mb-1 btn-icon-prepend" type="button" id="btn-modificar" data-bs-toggle="modal" data-bs-target="#staticBackdrop2"><i class="fa fa-edit btn-icon-text"></i> Modificar</button>
                            <button class="btn btn-falcon-success me-1 mb-1 btn-icon-prepend" type="button" id="btn-borrar"><i class="fa fa-trash-alt btn-icon-text"></i> Eliminar</button>
                            <button class="btn btn-falcon-success me-1 mb-1 btn-icon-prepend" type="button" id="btn-borrar-todo"><i class="fa fa-trash-alt btn-icon-text"></i> BorrarTodo</button>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</div>
<div class="row g-3 mb-3">
    <div class="card h-md-100">

        <div class="card-header pb-0">
            <center>
                <h5 class="mb-0 mt-2 d-flex justify-content-center">Todos mis Productos</h5>
            </center>

        </div>
        <div class="dropdown-divider"></div>

        <div class="table-responsive">
            <table class="table" id="tabla-productos">
                <thead>
                    <tr>
                        @foreach ($columnas as $item)
                        <th>{{ strtoupper($item) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articulos as $a)
                    <tr>
                        <td>{{ $a->id }}</td>
                        <td>{{ $a->descripcion }}</td>
                        <td>{{ $a->marca }}</td>
                        <td>{{ $a->presentacion }} {{ $a->medida }}</td>

                        <td>{{ $a->stock }}</td>
                        <td>{{ $a->precioCompra }}</td>
                        <td>{{ $a->precioVenta }}</td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</div>
<div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="staticBackdropLabel">Agregar un nuevo articulo al Inventario</h4>
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
                                                <input class="form-control" id="descripcion" name="descripcion" type="text" autocomplete="name" required="" />
                                                <div class="invalid-tooltip">Por favor, ingrese una descripción valida.
                                                </div>
                                            </div>
                                            <div class="col-md-6 position-relative">
                                                <label class="form-label" for="marca">Marca</label>
                                                <input class="form-control" id="marca" name="marca" type="text" autocomplete="name" required="" />
                                                <div class="invalid-tooltip">Por favor, ingrese una marca valida.
                                                </div>
                                            </div>


                                            <div class="col-md-4 position-relative">
                                                <label class="form-label" for="stock-form">Stock</label>
                                                <input class="form-control" id="stock-form" type="number" step="0.01" required="" />
                                                <div class="invalid-tooltip">Por favor, ingrese un stock valido.
                                                </div>
                                            </div>
                                            <div class="col-md-4 position-relative">
                                                <label class="form-label" for="precioCompra">Precio Compra</label>
                                                <input class="form-control" id="precioCompra" type="number" step="0.01" required="" />
                                                <div class="invalid-tooltip">Por favor, ingrese un Precio Compra
                                                    valido.
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

                                            <div class="col-md-5 position-relative">
                                                <label class="form-label" for="validationTooltipUsername">Unidad
                                                    Medida</label>

                                                <select id="unidad_medida_form" name="unidad_medida_form" class="form-select" required>
                                                    <option value="0">Seleccione una Unidad de Medida</option>

                                                    <option value="unidad">Unidad</option>
                                                    <option value="litro">Litro</option>
                                                    <option value="mililitro">MiliLitro</option>

                                                    <option value="kilogramo">Kilogramo</option>
                                                    <option value="gramo">Gramos</option>

                                                    <option value="metro">Metros</option>

                                                </select>
                                                <div class="invalid-tooltip">Por favor, seleccione una Unidad de Medida
                                                    valida.
                                                </div>

                                            </div>
                                            <div class="col-md-5 position-relative">
                                                <label class="form-label" for="validationTooltipUsername">Presentación</label>

                                                <select id="presentacion" name="presentacion" class="form-select" required>


                                                </select>
                                                <div class="invalid-tooltip">Por favor, seleccione una Presentación
                                                    valida.
                                                </div>

                                            </div>
                                            <div class="col-md-2 position-relative">
                                                <label class="form-label" for="validationTooltipUsername">Lucro
                                                    %</label>
                                                <input class="form-control" type="number" name="ganancia" id="ganancia" required="">
                                                <div class="invalid-tooltip">Por favor,ingrese una Ganancia
                                                    valida.
                                                </div>

                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-primary" type="submit" id="btn-registrar-articulo">Registrar</button>
                                                <button class="btn btn-danger" type="reset">Nuevo</button>
                                            </div>
                                        </form>
                                        <div class="dropdown dropend">
                                            <button style="background-color: green !important;" class="btn btn-sm btn-secondary px-2 fsp-75 bg-400 border-400 dropdown-toggle dropdown-caret-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Click para Calcular Precios por Presentación" id="btn-precio-minorista"><span class="fas fa-plus"></span></button>
                                            <div class="dropdown-menu">
                                                <h6 class="dropdown-header py-0 px-3 mb-0" style="background-color:orangered;color: white;">Precios por
                                                    Presentación</h6>
                                                <div class="dropdown-divider"></div>
                                                <div class="px-3">
                                                    <label class="badge-soft-danger dropdown-item rounded-1 mb-2" type="button" id="unidad"></label>
                                                    <label class="badge-soft-primary dropdown-item rounded-1 mb-2" type="button" id="precio"></label>

                                                </div>
                                                <div class="dropdown-divider"></div>
                                                <div class="px-3">
                                                    <h6 class="dropdown-header py-0 px-3 mb-0">Cuanto Cuesta ?</h6>
                                                    <button class="badge-soft-success dropdown-item rounded-1 mb-2" type="button" id="forma-presentacion"></button><label class="badge-soft-success dropdown-item rounded-1 mb-2" style="font-weight: bold;" for="forma-presentacion" id="medida-presentacion"></label>
                                                </div>
                                                <div class="dropdown-divider"></div>
                                                <div class="px-3">
                                                    <button class="btn btn-sm d-block w-100 btn-outline-primary border-400" id="btn-calcular-precios">Calcular
                                                        Precios</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                </div>
                            </div>
                            <div class="d-flex"><span class="fa-stack ms-n1 me-3"><i class="fas fa-circle fa-stack-2x text-200"></i><i class="fa-inverse fa-stack-1x text-primary fas fa-align-left" data-fa-transform="shrink-2"></i></span>
                                <div class="flex-1">
                                    <h5 class="mb-1 fs-0">NOTA</h5>

                                    <p class="text-word-break fs--1">El Precio de Compra y Venta <br>
                                        en General se calculan en el
                                        panel de Calcular Precio de Compra, Venta del Articulo </p>
                                    <p class="text-word-break fs--1">Unidad de Medida: Kilogramo/ Cantidad:3/
                                        Costo:30
                                        Traducción: 3 Kilos de Azucar Costaron 30 /y ASI sucesivamente con las otras
                                        unidades de Medida</p>
                                    <h6 class="mb-1 fs-0">Formulas</h6>
                                    <p class="text-word-break fs--1"> # CG =CT / CA * % ganancia <br>
                                        # PC =CT / CA <br>
                                        # PV =CT / CA + CG</p>

                                    <p class="text-word-break fs--1"> Donde: PC=PrecioCompra / PV=PrecioVenta /
                                        CT=CostoTotalDelArticulo / CA=CantidadDeArticulos / CG=CantidadDeGanancia
                                    </p>
                                </div>
                                <div class="flex-1">
                                    <h5 class="mb-1 fs-0"></h5>
                                    <p class="text-word-break fs--1"> El Precio de Compra y Venta en base a la
                                        Presentacion del Articulo se calculan en el
                                        panel de Calcular Precios por presentación (SIMBOLO +)</p>
                                    <h6 class="mb-1 fs-0">Importante</h6>
                                    <p class="text-word-break fs--1">Para Poder hacer la Operación se necesita haber
                                        calculado el
                                        precio de
                                        compra venta en General y las Unidades de Medida deben ser las Mismas</p>
                                    <p class="text-word-break fs--1"> Unidad de medida del Formulario: kilogramo /
                                        Presentación: 0.5 / PrecioCompra: 10 / PrecioVenta: 10.1
                                        /% Lucro O Ganancia: 10 <br> Traducción : 1 kg de Azucar cuesta 10 y se vende a
                                        10.1 con un porcentaje de Ganancia del 10% <br>
                                        Cuanto es su precio Compra Venta de 0.5 kg con un porcentaje de Ganancia del 10%
                                        ? </p>
                                    <p class="text-word-break fs--1"> PC = PC * Presentación <br> PV = PV *Presentacion
                                        / 1</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <h6 class="mt-5 mt-lg-0">Calcular Precio de Compra, Venta del Articulo</h6>
                            <ul class="nav flex-lg-column fs--1">
                                <li class="form-control me-2 me-lg-0"><span class="fas fa-user me-2"></span>Unidad de
                                    Medida<select id="unidad_medida" name="unidad_medida" class=" form-select card-details">
                                        <option value="unidad">Unidad</option>
                                        <option value="litro">Litro</option>
                                        <option value="kilogramo">Kilogramo</option>
                                        <option value="metro">Metros</option>

                                    </select></li>
                                <li class="form-control me-2 me-lg-0"><span class="fas fa-ring me-2"></span>Cantidad<input class="form-control card-details" type="number" step="0.01" id="cantidad_articulos" placeholder="N articulos" title=" cantidad de artículos que vienen en una cierta cantidad de la unidad de medida">
                                </li>
                                <li class="form-control me-2 me-lg-0"><span class="fas fa-money-bill-alt me-2"></span>Costo<input class=" form-control card-details" type="number" step="0.01" id="costo_articulo" placeholder="total de la compra" title="total de la compra del articulo"></li>
                                <center>
                                    <li class="nav-item me-2 me-lg-0"><button class="btn-warning " step="0.01" id="btn-calcular">Calcular</button> </li>
                                </center>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="staticBackdrop2" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="staticBackdropLabel"> Modificar Datos de Articulo del Inventario</h4>
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
                                                <label class="form-label" for="descripcion2">Descripcion</label>
                                                <input class="form-control" id="descripcion2" name="descripcion2" type="text" autocomplete="name" required="" />
                                                <div class="invalid-tooltip">Por favor, ingrese una descripción valida.
                                                </div>
                                            </div>
                                            <div class="col-md-6 position-relative">
                                                <label class="form-label" for="marca2">Marca</label>
                                                <input class="form-control" id="marca2" name="marca2" type="text" autocomplete="name" required="" />
                                                <div class="invalid-tooltip">Por favor, ingrese una marca valida.
                                                </div>
                                            </div>


                                            <div class="col-md-4 position-relative">
                                                <label class="form-label" for="stock-form2">Stock</label>
                                                <input class="form-control" id="stock-form2" type="number" step="0.01" required="" />
                                                <div class="invalid-tooltip">Por favor, ingrese un stock valido.
                                                </div>
                                            </div>
                                            <div class="col-md-4 position-relative">
                                                <label class="form-label" for="precioCompra2">Precio Compra</label>
                                                <input class="form-control" id="precioCompra2" type="number" step="0.01" required="" title="No se Puede modificar" disabled />
                                                <div class="invalid-tooltip">Por favor, ingrese un Precio Compra
                                                    valido.
                                                </div>
                                            </div>
                                            <div class="col-md-4 position-relative">
                                                <label class="form-label" for="validationTooltipUsername">Precio
                                                    Venta</label>

                                                <input class="form-control" id="precioVenta2" type="number" step="0.01" aria-describedby="precioVenta" required="" />
                                                <div class="invalid-tooltip">Por favor, ingrese un Precio Venta
                                                    valido.
                                                </div>

                                            </div>                                          
                                            <div class="col-md-4 position-relative">
                                                <label class="form-label" for="validationTooltipUsername">Lucro
                                                    %</label>
                                                <input class="form-control" type="number" name="ganancia2" id="ganancia2" required="">
                                                <div class="invalid-tooltip">Por favor,ingrese una Ganancia
                                                    valida.
                                                </div>

                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-primary" type="submit" id="btn-modificar-articulo" disabled>Modificar</button>
                                            </div>
                                        </form>
                                       
                                    </div>
                                   
                                </div>
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
<script src="{{ asset('jquery.js') }}"></script>
<script src="{{ asset('DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

<script src="{{asset('articulos/articulo.js')}}"></script>
@endsection