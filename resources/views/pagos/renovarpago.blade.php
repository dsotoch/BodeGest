<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renovar Subscripción</title>
    <link rel="stylesheet" href="{{asset('pagos/webhoot.css')}}">
    <link href="{{ asset('falcon/public/assets/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('falcon/public/assets/css/theme.min.css') }}" rel="stylesheet" id="style-default">

</head>

<body>
    <div class="principal">

        <div class="card">
            <div class="cabecera">
                <div class="p-4" id="logos"> <img src="{{asset('imagenes/logo.png')}}" alt="" class="logo"><span class="font-sans-serif title">BodeGest</span>
                </div>
                <div class="p-4">
                    <h4 id="sus">Subscripción Cancelada por falta de Pago</h4><br>
                    
                </div>
            </div>
            <hr>
            <div class="card-body form">
                <form action="/Webhook/renew" method="POST" id="payment-form">
                    @csrf
                    <input type="hidden" name="token_id" id="token_id">
                    <div class="pymnt-itm card active">
                        <h2 class="titulo-tarjetas">Registrar Tarjeta</h2>
                        <div class="row">
                            <div class="col-6 ">
                                <div class="credit">
                                    <h4>Tarjetas de crédito</h4>
                                    <br>
                                    <img src="{{asset('imagenes/cards1.png')}}" alt="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="debit">
                                    <h4>Tarjetas de débito</h4>
                                    <br>
                                    <img src="{{asset('imagenes/cards2.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">

                            <div class="col-5">
                                <label class="form-label">Nombre del titular</label>
                                <input class="form-control" type="text" placeholder="Como aparece en la tarjeta" autocomplete="off" data-openpay-card="holder_name">
                            </div>
                            <div class="col-3">
                                <label class="form-label">Correo Electronico</label>
                                <input class="form-control" type="text" id="cliente-email" name="cliente-email" value="{{$email}}" readonly required>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Número de tarjeta</label>
                                <input class="form-control" type="text" autocomplete="off" data-openpay-card="card_number">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <label class="form-label">Fecha de expiración</label>
                                    <div class="col-6">
                                        <input class="form-control" type="text" placeholder="Mes" data-openpay-card="expiration_month">
                                    </div>
                                    <div class="col-6">
                                        <input class="form-control" type="text" placeholder="Año" data-openpay-card="expiration_year">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Código de seguridad</label>
                                <div class="row">
                                    <div class="col-4">
                                        <input class="form-control" type="text" placeholder="3 dígitos" autocomplete="off" data-openpay-card="cvv2">
                                    </div>
                                    <div class="col-8">
                                        <img src="{{asset('imagenes/cvv.png')}}" alt="">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-4 col-md-4 col-lg-4 bt">
                                <div><Label class="form-label">Total A Pagar Mensualmente</Label>
                                    <div class="flex">
                                        <input class="form-control cpago" type="text" name="amount" id="amount" value="{{$monto_plan}} PEN" readonly required>
                                    </div>
                                </div>

                            </div>
                            <div class="col-8 col-md-8 col-lg-8">
                                <div class="row">
                                    <div class="col-6 br">
                                        <p class="texto">Transacciones realizadas vía:</p>
                                        <img src="{{asset('imagenes/openpay.png')}}" alt="">
                                    </div>
                                    <div class="col-6">
                                        <p class="texto">Tus pagos se realizan de forma segura con encriptación de 256 bits</p>
                                        <img src="{{asset('imagenes/security.png')}}" alt="">
                                    </div>
                                </div>

                            </div>
                            
                            <div class="sctn-row">
                                <br>
                                <button type="submit" class=" btn btn-success" id="pay-button">Renovar Suscripción</button>
                            </div>



                        </div>
                </form>
            </div>


        </div>







    </div>



    <script src="{{asset('vendor/sweetalert/sweetalert.all.js')}}"></script>

    <script type="text/javascript" src="https://js.openpay.pe/openpay.v1.min.js"></script>
        <script type='text/javascript' src="https://js.openpay.pe/openpay-data.v1.min.js">
        </script>
    <script src="{{asset('jquery.js')}}"></script>
    <script src="{{asset('pagos/pagos.js')}}"></script>

</body>

</html>