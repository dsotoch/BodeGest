@extends('layouts.base')
@section('contenido')
<div class="row g-3 mb-3">
    <div class="col-xxl-6 col-xl-12">
        <div class="row g-3">
            <div class="col-12">
                <div class="card bg-transparent-50 overflow-hidden">
                    <div class="card-header position-relative">
                    </div>
                    <!--/.bg-holder-->

                    <div class="position-relative z-index-2">
                        <div>
                            <h3 class="text-primary mb-1">Bienvenido, {{$usuario}}!</h3>
                            <p>Esto es lo que sucede con su tienda hoy </p>
                        </div>
                        <div class="d-flex py-3">
                            <div class="pe-3">
                                <p class="text-600 fs--1 fw-medium">Today's visit </p>
                                <h4 class="text-800 mb-0">14,209</h4>
                            </div>
                            <div class="ps-3">
                                <p class="text-600 fs--1">Today’s total sales </p>
                                <h4 class="text-800 mb-0">$21,349.29 </h4>
                            </div>
                        </div>
                    </div>
                </div>
              
            </div>
        </div>
      
    </div>
</div>
@endsection