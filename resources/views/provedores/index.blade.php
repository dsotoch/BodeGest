@extends("layouts.base")
@section("estilos")
<link rel="stylesheet" href="{{asset('provedores/provedor.css')}}">
<link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">

@endsection
@section("contenido")

<div class="row g-3  m-3 card" id="superior">
    <h3 class="titulos">Mis Proveedores</h3>
    <hr>
    <div class="col-lg-12">
        <div class="pd-3 div-buttons">
            <button class="btn btn-primary btn-icon-text" data-bs-toggle="modal" data-bs-target="#modal-crear-provedor" id="btn-agregar"><i class="fas fa-user-plus btn-icon-prepend"></i>Agregar </button>
            <button class="btn btn-warning btn-icon-text" data-bs-toggle="modal" data-bs-target="#modal-ayuda-provedor"><i class="fas fa-question btn-icon-prepend"></i>Ayuda </button>
        </div>

    </div>

</div>
<div class="row g-3 m-3 card " id="superior">
    <div class="table-responsive">
        <div class="car-body">
            <table class="table" id="tabla-provedores">
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
                    @foreach($provedores as $n)
                    <tr>
                        <td>{{$n->id}}</td>
                        <td>{{$n->nombre}}</td>
                        <td>{{$n->telefono}}</td>
                        <td>{{$n->pais}}</td>
                        <td>
                            <div class="row" id="div-opciones">
                                <button title="Editar" class="btn-warning btn-editar" data-bs-toggle="modal" data-bs-target="#modal-editar-provedor"> <i class="fas fa-edit"></i> </button>
                                <button title="Eliminar" class="btn-danger btn-eliminar"> <i class="fas fa-trash"></i> </button>
                                <button title="Detalles" class="btn-primary btn-detalles" data-bs-toggle="modal" data-bs-target="#mymodal"> <i class="fas fa-eye"></i> </button>

                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>
</div>
<div id="mymodal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <div class="modal-content border-0">
            <div class="modal-body p-0">
                <div class="m-3">
                    <h4 class="mb-1" id="staticBackdropLabel"> Detalles del Proveedor</h4>
                </div>
                <hr>
                <div class="card">
                    <div class="card-header bg-light" id="div-titulo-provedor">
                        <center>
                            <h5 class="mb-0">
                                <p for="" id="detalle-nombres">sdsd</p>
                            </h5>
                        </center>
                    </div>
                    <div class="card-body fs--1 p-0">
                        <a class="border-bottom-0 notification rounded-0 border-x-0 border border-300" href="#!">
                            <div class="notification-avatar">
                                <div class="avatar avatar-xl me-3">
                                    <div class="avatar-emoji rounded-circle "><span role="img" aria-label="Emoji">🚚</span></div>
                                </div>
                            </div>
                            <div class="notification-body">
                                <p class="mb-1" id="detalle-servicio"><strong>Anthony Hopkins</strong> Followed <strong>Massachusetts Institute of Technology</strong></p>
                                <span class="notification-time">Producto/Servicio</span>

                            </div>
                        </a>
                        <a class="border-bottom-0 notification rounded-0 border-x-0 border border-300" href="#!">
                            <div class="notification-avatar">
                                <div class="avatar avatar-xl me-3">
                                    <div class="avatar-emoji rounded-circle "><span role="img" aria-label="Emoji">🚩</span></div>
                                </div>
                            </div>
                            <div class="notification-body">
                                <p class="mb-1" id="detalle-pais"><strong>Anthony Hopkins</strong> Followed <strong>Massachusetts Institute of Technology</strong></p>
                                <span class="notification-time">Nacionalidad</span>

                            </div>
                        </a>

                        <a class="border-bottom-0 notification rounded-0 border-x-0 border border-300" href="#!">
                            <div class="notification-avatar">
                                <div class="avatar avatar-xl me-3">
                                    <div class="avatar-emoji rounded-circle "><span role="img" aria-label="Emoji"> 🏯</span></div>
                                </div>
                            </div>
                            <div class="notification-body">
                                <p class="mb-1" id="detalle-direccion"><strong>Anthony Hopkins</strong> Save a <strong>Life Event</strong></p>
                                <span class="notification-time">Direccion</span>

                            </div>
                        </a>

                        <a class="border-bottom-0 notification rounded-0 border-x-0 border border-300" href="#!">
                            <div class="notification-avatar">
                                <div class="avatar avatar-xl me-3">
                                    <div class="avatar-emoji rounded-circle "><span role="img" aria-label="Emoji">📱</span></div>
                                </div>
                            </div>
                            <div class="notification-body">
                                <p class="mb-1" id="detalle-telefono"><strong>Rowan Atkinson</strong> Tagged <strong>Anthony Hopkins</strong> in a live video</p>
                                <span class="notification-time">Telefono</span>

                            </div>
                        </a>

                        <a class="border-bottom-0 notification rounded-0 border-x-0 border border-300" href="#!">
                            <div class="notification-avatar">
                                <div class="avatar avatar-xl me-3">
                                    <div class="avatar-emoji rounded-circle "><span role="img" aria-label="Emoji">📬</span></div>
                                </div>
                            </div>
                            <div class="notification-body">
                                <p class="mb-1" id="detalle-email"><strong>Robert Downey</strong> mention <strong>Anthony Hopkins</strong> in a comment</p>
                                <span class="notification-time">Correo Electronico</span>

                            </div>
                        </a>





                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-editar-provedor" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="staticBackdropLabel"> Modificar Proveedor</h4>
                    <p class="fs--2 mb-0">Añadido por <a class="link-600 fw-semi-bold">Bodegest</a></p>
                </div>
                <form action="" id="form-editar">
                    @csrf

                    <div class="p-4">
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="editar-codigo" class="form-label">Codigo</label>
                                <input type="text" class="form-control" name="" id="editar-codigo" disabled>
                            </div>
                            <div class="col-lg-4">
                                <label for="editar-nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" id="editar-nombre" autocomplete="name" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                            <div class="col-lg-4">
                                <label for="editar-direccion" class="form-label">Direccion</label>
                                <input type="text" class="form-control" name="direccion" autocomplete="name" id="editar-direccion" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-3">
                                <label for="editar-servicio" class="form-label">Producto/Servicio</label>
                                <input type="text" class="form-control" name="servicio" autocomplete="name" id="editar-servicio" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                            <div class="col-lg-3">
                                <label for="editar-telefono" class="form-label">Telefono</label>
                                <input type="number" class="form-control" name="telefono" autocomplete="name" id="editar-telefono" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                            <div class="col-lg-3">
                                <label for="editar-pais" class="form-label">Pais</label>
                                <input type="text" class="form-control" name="pais" autocomplete="name" id="editar-pais" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                            <div class="col-lg-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control"  required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" name="email" autocomplete="name" id="editar-email" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="row mt-3" id="div-buttons-editar">
                            <button class="btn btn-success" id="btn-editar-provedor">Modificar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal-crear-provedor" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="staticBackdropLabel"> Registrar Nuevo Proveedor</h4>
                    <p class="fs--2 mb-0">Añadido por <a class="link-600 fw-semi-bold">Bodegest</a></p>
                </div>
                <form action="" id="form-crear">
                    @csrf
                    <div class="p-4">
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="codigo" class="form-label">Codigo</label>
                                <input type="text" class="form-control" name="" id="codigo" disabled>
                            </div>
                            <div class="col-lg-4">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" autocomplete="name" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                            <div class="col-lg-4">
                                <label for="direccion" class="form-label">Direccion</label>
                                <input type="text" class="form-control" name="direccion" autocomplete="name" id="direccion" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-3">
                                <label for="servicio" class="form-label">Producto/Servicio</label>
                                <input type="text" class="form-control" name="servicio" autocomplete="name" id="servicio" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                            <div class="col-lg-3">
                                <label for="telefono" class="form-label">Telefono</label>
                                <input type="number" class="form-control" name="telefono" autocomplete="name" id="telefono" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                            <div class="col-lg-3">
                                <label for="correo" class="form-label">Email</label>
                                <input type="email" class="form-control" name="correo" autocomplete="name" id="correo" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                            <div class="col-lg-3">
                                <label for="pais" class="form-label">Pais</label>
                                <input type="text" class="form-control" name="pais" autocomplete="name" id="pais" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="row mt-3" id="div-buttons-crear">
                            <button class="btn btn-success" id="save-provedor">Guardar</button>
                            <button class="btn btn-danger" type="reset">Nuevo</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-ayuda-provedor" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="staticBackdropLabel"> Todo lo que Necesitas Saber</h4>
                    <p class="fs--2 mb-0">Añadido por <a class="link-600 fw-semi-bold">Bodegest</a></p>
                </div>

            </div>
            <div class="p-4">
                <div class="row m-3">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <p>Un proveedor es una empresa o individuo que suministra bienes o servicios a otra empresa o individuo. En el contexto de compras, los proveedores son esenciales ya que proporcionan los productos que una empresa necesita para llevar a cabo sus operaciones.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <p>Para registrar una compra, es importante que primero se tenga registrado al proveedor que proporcionará los bienes o servicios. Esto se debe a que el registro del proveedor permite tener un registro completo de los datos necesarios para realizar la compra, como el nombre del proveedor, su dirección, teléfono, correo electrónico y cualquier otro detalle importante que pueda ser requerido en el futuro.</p>
                            </div>
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

<script src="{{asset('provedores/provedor.js')}}"></script>
@endsection