<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('ventas/detalles.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script></head>

<body>

    <div id="pr">
        @if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
        @else
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <form action="/Ventas/Comprobante" method="post" id="form" enctype="multipart/form-data">
            <textarea type="text" name="imagen" id="imagen" hidden></textarea>
            <input type="text" name="email" id="email" hidden>

            @csrf
            <div class="contenedor pdf">

                <div class="cabecera">
                    <div class="cabecera-izquierda">
                        <table class="tabla-empresa">
                            <tr>
                                <td class="td-center f-w title" colspan="2"> "Distribuidora de abarrotes al por mayor y menor"</td>
                            </tr>
                            <tr>
                                <td class="td-center" colspan="2"> {{$empresa->nombre}}</td>
                            </tr>
                            <tr>
                                <td>{{$empresa->direccion}}</td>
                            </tr>
                            <tr>

                                @if($empresa->ruc ==null)
                                <td>RUC:#########</td>
                                @else
                                <td>RUC:{{$empresa->ruc}}</td>
                                @endif
                            </tr>
                        </table>
                    </div>
                    <div class="cabecera-derecha">
                        <table class="tb-cabecera">
                            <tr>
                                <td colspan="2" class="mr-2 " style="background-color: black;color:white;">
                                    NOTA DE VENTA
                                </td>

                            </tr>
                            <tr>
                                <td class="td-center" id="documento">{{$numero_venta}} </td>
                            </tr>


                        </table>
                        <table class="tb-fechas">
                            <tr>
                                <td colspan="3" class="td-center title">FECHA</td>
                            </tr>
                            <tr>
                                <td>DIA</td>
                                <td>MES</td>
                                <td>AÑO</td>
                            </tr>
                            <tr>
                                <td>{{$dia}}</td>
                                <td>{{$mes}}</td>
                                <td>{{$año}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="cliente">
                    <table class="tb-cliente">
                        <tr>
                            <td class="pad-2 title" colspan="2">Datos del Cliente</td>
                        </tr>
                        <tr>
                            <td class="w-10">Dni</td>
                            <td class="mr-2">{{$cliente->dni}}</td>
                        </tr>
                        <tr>
                            <td class="w-10">Nombre</td>
                            <td class="mr-2" id="cliente">{{$cliente->cliente}}</td>
                        </tr>
                        <tr>
                            <td class="w-10">Telefono</td>
                            <td class="mr-2" id="telefono">{{$cliente->telefono}}</td>
                        </tr>
                        <tr>
                            <td class="w-10">Email</td>
                            <td class="mr-2" id="correo">{{$cliente->email}}</td>
                        </tr>
                    </table>
                </div>

                <div class="producto">
                    <table class="tb-producto">
                        <thead>
                            <tr class="title">
                                <td class="td-10">Codigo</td>
                                <td>Descripcion</td>
                                <td class="td-10">Precio Unit.</td>
                                <td class="td-10">Cant.</td>
                                <td class="td-10">Total</td>
                            </tr>
                        </thead>
                        <tbody> @foreach($productos as $n)
                            <tr>
                                <td class="td-10">{{$n->id}}</td>
                                <td>{{$n->descripcion}} {{$n->marca}} {{$n->medida}} {{$n->presentacion}}</td>
                                <td class="td-10">{{$n->precioVenta}}</td>
                                <td class="td-10">{{$n->pivot->cantidad}}</td>
                                <td class="td-10">{{$n->pivot->cantidad * $n->precioVenta}}</td>
                            </tr>

                            @endforeach
                        </tbody>


                    </table>
                    <hr>
                    <table id="detalles">
                        <tr>
                            <td class="t-r mr" colspan="4">Sub Total: {{$subtotal}}</td>
                        </tr>
                        <tr>
                            <td class="t-r mr" colspan="4">IGV: {{$iva}}</td>
                        </tr>
                        <tr>
                            <td class="t-r mr" colspan="4">Total: {{$total}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <hr>
            <div class="contenedor opciones">

                <button class="btn btn-danger" type="button" id="btn-detalle-nueva-venta">Nueva Venta</button>
                <button class="btn btn-primary" type="button" id="btn-imprimir" title="Imprimir Comprobante"><i class="fas fa-print"></i> </button>
                <button id="btn-whatsapp" target="_blank" type="button" class="btn btn-success" title="Enviar Comprobante por Whatsapp">
                    <i class="fab fa-whatsapp"></i>
                </button>
                <button class="btn btn-info" type="submit" id="btn-email" title="Enviar Comprobante por Correo Electronico"> <i class="fas fa-envelope"></i></button>
            </div>
        </form>
    </div>



    <script src="{{ asset('html2.js') }}"></script>
    <script src="{{ asset('jquery.js') }}"></script>
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="{{asset('ventas/ventas.js')}}"></script>
    <script src="{{ asset('falcon/public/vendors/fontawesome/all.min.js') }}"></script>
</body>

</html>