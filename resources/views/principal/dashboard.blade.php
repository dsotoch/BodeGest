@extends('layouts.base')
@section("estilos")
<link rel="stylesheet" href="{{asset('dashboard/dashboard.css')}}">

@endsection
@section('contenido')
<div class="row g-3 mb-3">
    <div class="col-xxl-6 col-xl-12">
        <div class="row g-3">
            <div class="col-12">
                <div class="card bg-transparent-50 overflow-hidden">
                    <div class="card-header position-relative">
                    </div>
                    <!--/.bg-holder-->

                    <div class="position-relative z-index-2 p-2">
                        <div>
                            <h3 class="text-primary mb-1">Bienvenido, {{$usuario}}!</h3>
                            <p>Esto es lo que sucede con su tienda hoy </p>
                        </div>
                        <div class="row py-3">
                            <div class="card col-12 col-md-6 col-lg-6 pe-3">
                                <canvas class="card-body" id="grafico"></canvas>
                            </div>
                            <div class="card col-12 col-md-6 col-lg-6 pe-3 ml-2">
                                <canvas class="card-body" id="maxima_venta"></canvas>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-3 col-md-3 col-lg-3 pe-3">
                                <p class="text-600 fs--1 fw-medium center">Monto de las Ventas de Hoy </p>
                                <h4 class="text-800 mb-0 center" id="m-ventas">14,209</h4>
                            </div>
                            <div class="col-3 col-md-3 col-lg-3 pe-3">
                                <p class="text-600 fs--1 center">Monto de las Compras de Hoy </p>
                                <h4 class="text-800 mb-0 center" id="m-compras">$21,349.29 </h4>
                            </div>
                            <div class="col-6 col-md-6 col-lg-6 pe-3">
                                <p class="text-600 fs--1 center">Mayor Venta de Hoy </p>
                                <h4 class="text-800 mb-0 center" id="m-ventas-hoy">$21,349.29 </h4>
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

<script src="{{asset('jquery.js')}}"></script>
<script src="{{asset('dashboard/dashboard.js')}}"></script>
<script src="{{asset('pagos/webhoot.js')}}"></script>

@endsection