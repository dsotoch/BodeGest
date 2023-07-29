@extends("layouts.base")
@section("estilos")
<link rel="stylesheet" href="{{asset('dashboard/home.css')}}">
@endsection
@section("contenido")
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h5>Detalles de Caja  <span>{{$fecha}}</span> </h5> 
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-12 txtr">
                    <label for="" class="form-control">Saldo en Caja : <span class="s-caja">S/</span><span class="s-caja">{{$saldo}}</span></label>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label for="" class="form-control btn-info">Movimientos</label>
                </div>
            </div>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table">
                        <thead>
                            <th>Movimiento</th>
                            <th>Tipo</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                        </thead>
                        <tbody>
                            @foreach($movimientos as $n)
                            <tr>
                                <td>{{$n->operacion}}</td>
                                <td>{{$n->tipo}}</td>
                                <td>{{$n->monto}}</td>
                                <td>{{$n->fecha}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection