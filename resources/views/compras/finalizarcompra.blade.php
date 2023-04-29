@extends("layouts.base")
@section("estilos")
 <link rel="stylesheet" href="{{asset('compras/compras.css')}}">
@endsection
@section("contenido")
<div class="card-body" id="factura">
  <div class="row align-items-center text-center mb-3">
    <div class="col-sm-6 text-sm-start"><img src="{{asset('falcon/public/assets/img/logos/logo-invoice.png')}}" alt="invoice" width="150"></div>
    <div class="col text-sm-end mt-3 mt-sm-0">
      <h2 class="mb-3">Factura</h2>
      <h5>{{$empresa->nombre}}</h5>
      <p class="fs--1 mb-0">{{$empresa->direccion}}</p>
    </div>
    <div class="col-12">
      <hr>
    </div>
  </div>
  <div class="row align-items-center">
    <div class="col">
      <h6 class="text-500">Factura de</h6>
      <h5>{{$compra->provedores->nombre}}</h5>
      <p class="fs--1">{{$compra->provedores->direccion}}<br>{{$compra->provedores->pais}}</p>
      <p class="fs--1">{{$compra->provedores->correo}}<br>{{$compra->provedores->telefono}}mpdf</p>
    </div>
    <div class="col-sm-auto ms-auto">
      <div class="table-responsive">
        <table class="table table-sm table-borderless fs--1">
          <tbody>
            <tr>
              <th class="text-sm-end">Factura N°:</th>
              <td>{{$compra->id}}</td>
            </tr>
            <tr>
              <th class="text-sm-end">Compra Numero:</th>
              <td>{{$compra->id}}</td>
            </tr>
            <tr>
              <th class="text-sm-end">Fecha de Compra:</th>
              <td>2018-09-25</td>
            </tr>
            <tr>
              <th class="text-sm-end">Metodo de Pago:</th>
              <td>{{$compra->metodoPago}}</td>
            </tr>
            <tr class="alert-success fw-bold">
              <th class="text-sm-end">Monto Compra:</th>
              <td>{{$compra->totalCompra}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="table-responsive scrollbar mt-4 fs--1">
    <table class="table table-striped border-bottom" id="tabla-finalizar">
      <thead class="light">
        <tr class="bg-primary text-white dark__bg-1000">
          <th class="border-0">Productos</th>
          <th class="border-0 text-center">Cantidad</th>
          <th class="border-0 text-end">Precio</th>
          <th class="border-0 text-end">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($compra->articulos as $n)
        <tr>
          <td class="align-middle">
            <h6 class="mb-0 text-nowrap">{{$n->descripcion}} {{$n->marca}}</h6>
            <p class="mb-0">{{$n->presentacion}} {{$n->medida}}</p>
          </td>
          <td class="align-middle text-center">{{$n->stock}}</td>
          <td class="align-middle text-end">{{$n->precioCompra}}</td>
          <td class="align-middle text-end">{{$n->stock * $n->precioCompra}}</td>
        </tr>
        @endforeach


      </tbody>
    </table>
  </div>
  <div class="row justify-content-end">
    <div class="col-auto">
      <table class="table table-sm table-borderless fs--1 text-end">
        <tbody>
          <tr>
            <th class="text-900">Subtotal:</th>
            <td class="fw-semi-bold">{{$compra->totalCompra}} </td>
          </tr>
          <tr>
            <th class="text-900">IGV%:</th>
            <td class="fw-semi-bold">0</td>
          </tr>
          <tr class="border-top">
            <th class="text-900">Total:</th>
            <td class="fw-semi-bold">{{$compra->totalCompra}} </td>
          </tr>
          <tr class="border-top border-top-2 fw-bolder text-900">
            <th>Cantidad Adeudad:</th>
            <td>{{$compra->totalCompra}}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="card col-lg-12">
  <div class="button-finalizar">
    <button class="btn btn-danger"><a style="text-decoration: none; color: white;" href="{{url()->previous()}}">Regresar</a></button>
  </div>
</div>


@endsection
@section("scripts")
<script src="{{ asset('jquery.js') }}"></script>

<script src="{{ asset('compras/finalizar.js') }}"></script>

@endsection