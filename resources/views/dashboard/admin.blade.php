@extends("layouts.base")
@section("estilos")
<link rel="stylesheet" href="{{asset('dashboard/analisis.css')}}">

@endsection

@section("contenido")

<div class="row">
    <div class="col-lg-12 p-2">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <div class="w-100">
                    <h6 class="mb-3 text-800">Clientes <strong class="text-dark">TOP</strong> en Compras</h6>
                    <div class="progress mb-3 rounded-3" style="height: 10px;">
                        <div class="progress-bar bg-progress-gradient border-end border-white border-2" role="progressbar" style="width: 43.72%" aria-valuenow="43.72" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-info border-end border-white border-2" role="progressbar" style="width: 18.76%" aria-valuenow="18.76" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-success border-end border-white border-2" role="progressbar" style="width: 9.38%" aria-valuenow="9.38" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="row row-progress fs--1 fw-semi-bold text-500 g-0">
                        <div class="col-auto d-flex align-items-center pe-3"><span class="dot bg-primary"></span><span>NULL</span><span class="d-none d-md-inline-block d-lg-none d-xxl-inline-block">(895MB)</span></div>
                        <div class="col-auto d-flex align-items-center pe-3"><span class="dot bg-info"></span><span>NULL</span><span class="d-none d-md-inline-block d-lg-none d-xxl-inline-block">(379MB)</span></div>
                        <div class="col-auto d-flex align-items-center pe-3"><span class="dot bg-success"></span><span>NULL</span><span class="d-none d-md-inline-block d-lg-none d-xxl-inline-block">(192MB)</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 col-xl-6 pe-lg-2 mb-3">
        <div class="card">
            <div class="card-body h-lg-100 overflow-hidden">

                <div class="table-responsive scrollbar">
                    <table class="table table-dashboard mb-0 table-borderless fs--1 border-200">
                        <thead class="bg-light">
                            <tr class="text-900 stock">
                                <th class="form-label">Productos con Stock menor a 4</th>

                                <th class="form-label" style="width: 8rem">Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $n)
                            <tr class="border-bottom border-200">
                                <td>
                                    <div class="flex-1 ms-3">
                                        <h6 class="mb-1 fw-semi-bold"><a class="text-dark stretched-link" href="#!">{{$n->descripcion}} {{$n->marca}}</a></h6>
                                        <p class="fw-semi-bold mb-0 text-500">{{$n->presentacion}} {{$n->medida}} </p>
                                    </div>

                                </td>

                                <td class="align-middle pe-card">
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-3 rounded-3 bg-100" style="height: 5px;width:80px">
                                            <div class="progress-bar rounded-pill" role="progressbar" style="width: 39%;" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="fw-semi-bold ms-2">{{$n->stock}}</div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="row">
            <div class="col-12 col-lg-12 col-xxl-12">
                <div class="card h-100">
                    <div class="card-header d-flex flex-between-center py-2">
                        <h6 class="mb-0 ">Ingresos vs Egresos</h6>

                    </div>
                    <canvas class="card-body" id="ingresos-vs-egresos">

                    </canvas>
                </div>
            </div>


            <div class="col-12 col-lg-12 col-xxl-12 mt-4">
                <div class="card h-100">
                    <div class="card-header d-flex flex-between-center py-2">
                        <h6 class="mb-0 ">Balance de Ventas de los Ultimos 4 Meses</h6>

                    </div>
                    <canvas class="card-body" id="ventas-mensual">

                    </canvas>
                </div>
            </div>


        </div>
    </div>

</div>

</div>
@endsection
@section("scripts")
<script src="{{asset('jquery.js')}}"></script>
<script src="{{asset('dashboard/analisis.js')}}"></script>
@endsection