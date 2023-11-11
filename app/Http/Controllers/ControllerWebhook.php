<?php

namespace App\Http\Controllers;

use App\Models\cancelarSuscripcions;
use App\Models\pagos;
use App\Models\personas;
use App\Models\suscripcions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Openpay\Data\Openpay;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use DateTimeZone;
use GuzzleHttp\Client;
use Throwable;

class ControllerWebhook extends Controller
{

    function cancel()
    {
        return view('pagos/errorbasico');
    }
    function success()
    {
        return view('pagos/exitobasico');
    }
    function datos_movimiento_cliente()
    {
        $user = Auth::user();
        $subscription = suscripcions::where('user_id', $user->id)->where(function ($query) {
            $query->where('estado', 'ACTIVO')
                ->orWhere('estado', 'ESPERANDO');
        })->first();
        $array = [];
        if ($subscription) {
            $can_sus = cancelarSuscripcions::where("suscripcion_id", $subscription->id)->where("estado", true)->first();
            $fecha = Carbon::now("America/Lima");
            if ($can_sus) {
                $fecha = $can_sus->fecha;
            }
            $array = [
                "id" => $subscription->id,
                "suscripcion_id" => $subscription->suscripcion_id,
                "cantidad_cargo_predeterminada" => $subscription->cantidad_cargo_predeterminada,
                "estado" => $subscription->estado,
                "fecha" => $fecha
            ];
        }
        return response()->json($array);
    }
    function datos_pago_cliente()
    {
        try {
            $user = Auth::user();
            $subscription = suscripcions::where('user_id', $user->id)->where(function ($query) {
                $query->where('estado', 'ACTIVO')
                    ->orWhere('estado', 'ESPERANDO');
            })->first();
            if ($subscription) {
                $paymentsData = pagos::where('suscripcion_id', $subscription->id)
                    ->where(function ($query) {
                        $query->where('estado', true)
                            ->orWhere('estado', false);
                    })
                    ->get();

                if ($paymentsData) {
                    $payments = [];
                    foreach ($paymentsData as $payment) {
                        $payments[] = [
                            'estado' => $payment->estado ? 'CANCELADO' : 'PENDIENTE',
                            'suscripcion_id' => $payment->suscripcion_id,
                            'monto' => $payment->monto,
                            'periodo' => $payment->periodo,
                            'fechaCargo' => $payment->fechaCargo,
                        ];
                    }

                    return response()->json($payments);
                } else {
                    throw new Throwable("NO TIENE NINGUN PAGO");
                }
            } else {
                return response()->json(false);
            }
        } catch (\Throwable $th) {
            return response()->json(false);
        }
    }
    function ChronogramGenerate($fecha)
    {
        $StartDate = new DateTime($fecha);
        $interval = new DateInterval("P1M");
        $array = [];
        $day = $StartDate->format('d');
        if ($day > 28) {
            for ($i = 0; $i < 36; $i++) {
                if ($i == 0) {
                    $LastDayOfMonth = clone $StartDate;
                    $array[] = $LastDayOfMonth->format('Y-m-d');
                    $StartDate->add($interval);
                } else {
                    $LastDayOfMonth = clone $StartDate;
                    $LastDayOfMonth->modify('last day of this month');
                    $array[] = $LastDayOfMonth->format('Y-m-d');
                    $StartDate->add($interval);
                }
            }
        } else {
            for ($i = 0; $i < 36; $i++) {
                $array[] = $StartDate->format('Y-m-d');
                $StartDate->add($interval);
            }
        }


        return $array;
    }
    function reanudar_subscripcion()
    {
        $user = Auth::user();
        $subscription = suscripcions::where('user_id', $user->id)->where(function ($query) {
            $query->where("estado", "ESPERANDO")
                ->orWhere("estado", "INACTIVO");
        })->first();
        if ($subscription) {
            $cancelSuscri = cancelarSuscripcions::where('suscripcion_id', $subscription->id)->where("estado", true)->first();
            $fechaTermino = Carbon::now("America/Lima");
            if ($cancelSuscri) {
                $state = $subscription->estado;
                $fechaTermino = Carbon::parse($cancelSuscri->fecha);
                $fechaTer = $fechaTermino->addDay();
                if ($state == "ESPERANDO") {
                    $response = $this->nuevaSuscripcion($subscription, $fechaTer);
                    if ($response != "error") {
                        $subscription->estado = "ACTIVO";
                        $subscription->suscripcion_id = $response;
                        $subscription->save();
                        $persona = personas::where('user_id', $user->id)->first();
                        $persona->plan = 'PLAN BASICO';
                        $persona->save();
                        $can_sus = cancelarSuscripcions::where("suscripcion_id", $subscription->id)->where("estado", true)->first();
                        $can_sus->estado = false;
                        $can_sus->save();
                        pagos::where("suscripcion_id", $subscription->id)->delete();
                        $arrayfechaspagos = $this->ChronogramGenerate($fechaTer);
                        $c = 1;
                        foreach ($arrayfechaspagos as $key) {

                            pagos::create([
                                "monto" => 22,
                                "descripcion" => "Plan Basico",
                                "suscripcion_id" => $subscription->id,
                                "fechaCargo" => $key,
                                "periodo" => $c++
                            ]);
                        }
                        return redirect()->route("reanudarSuscripcion");
                    }
                }
            } else {
                pagos::where("suscripcion_id", $subscription->id)->delete();
                $token = $this->nuevoPago();
                if ($token != null) {
                    return redirect()->route('reanudarSuscripcionFallida', ['token' => $token]);
                }
            }
        }
    }
    function nuevaSuscripcion(suscripcions $sus, $fechaTermino)
    {
        $fecha = Carbon::parse($fechaTermino);
        $fechaFormateada = $fecha->format("Y-m-d\TH:i:sP");
        $dia = $fecha->format("d");
        $url = "https://api.micuentaweb.pe/api-payment/V4/Charge/CreateSubscription";
        $client = new Client();
        $authHeader = base64_encode($_ENV["IZI_USER"] . ":" . $_ENV["IZI_PASS"]);
        $headers = [
            "headers" => [
                "Authorization" => "Basic " . $authHeader,
                "Content-Type" => "application/json"
            ]
        ];
        $rrule = "RRULE:FREQ=MONTHLY;BYMONTHDAY=$dia;INTERVAL=1";
        if ($rrule > 28) {
            $rrule = "RRULE:FREQ=MONTHLY;BYMONTHDAY=29,30,31;BYSETPOS=-1;INTERVAL=1";
        }
        $dataSubscription = [
            "amount" => 2200,
            "currency" => "PEN",
            "effectDate" => $fechaFormateada,
            "orderId" => "Order-" . random_int(100, 50000),
            "paymentMethodToken" => $sus->card_id,
            "rrule" => $rrule
        ];

        $optionsSubscription = array_merge($headers, ["json" => $dataSubscription]);
        //$optionsCancelSubscription = array_merge($headers, ["json" => $dataOrder]);
        $client = new Client();
        $responseSubs = $client->request("POST", $url, $optionsSubscription);
        $responseSubs = $responseSubs->getBody()->getContents();
        $respon = json_decode($responseSubs, true);
        if ($respon["status"] == "SUCCESS") {
            return $respon["answer"]["subscriptionId"];
        }
        return "error";
    }
    function falloRenovacion($token)

    {
        return view("pagos.renovacionfallida")->with('formToken', $token);
    }
    function exitoRenovacion(Request $request)
    {
        if ($request['kr-hash-algorithm']) {
            $answer = json_decode($request['kr-answer'], true);
            $token = $answer['transactions'][0]['paymentMethodToken'];

            if (!$this->checkHash($request, $_ENV["SHA_KEY_IZI"])) {
                response("er", 'Invalid signature.');
                die("HUBO UN ERROR");
            }
            $user = Auth::user();
            $subscription = suscripcions::where('user_id', $user->id)->where(function ($query) {
                $query->where("estado", "ESPERANDO")
                    ->orWhere("estado", "INACTIVO");
            })->first();
            $fecha = Carbon::now("America/Lima");
            $response = $this->nuevaSuscripcion($subscription, $fecha);
            $subscription->estado = "ACTIVO";
            $subscription->suscripcion_id = $response;
            $subscription->card_id = $token;
            $subscription->save();
            $persona = personas::where('user_id', $user->id)->first();
            $persona->plan = 'PLAN BASICO';
            $persona->save();
            $can_sus = cancelarSuscripcions::where("suscripcion_id", $subscription->id)->where("estado", true)->first();
            if ($can_sus) {
                $can_sus->estado = false;
                $can_sus->save();
            }

            $fecha = Carbon::now("America/Lima");
            $cro = $this->ChronogramGenerate($fecha);
            $c = 1;
            foreach ($cro as $key) {
                $estado = false;
                if ($c == 1) {
                    $estado = true;
                }
                pagos::create([
                    "monto" => 22,
                    "estado" => $estado,
                    "descripcion" => "Plan Basico",
                    "suscripcion_id" => $subscription->id,
                    "fechaCargo" => $key,
                    "periodo" => $c++
                ]);
            }
        }

        return view("pagos.renovacionexitosa");
    }
    function checkHash($data, $key)
    {
        $supported_sign_algos = array('sha256_hmac');
        if (!in_array($data['kr-hash-algorithm'], $supported_sign_algos)) {
            return false;
        }
        $kr_answer = str_replace('\/', '/', $data['kr-answer']);
        $hash = hash_hmac('sha256', $kr_answer, $key);
        return ($hash == $data['kr-hash']);
    }
    function nuevoPago()
    {
        $user = Auth::user();
        $store = array(
            "amount" => 2200,
            "currency" => "PEN",
            "formAction" => "REGISTER_PAY",
            "overridePaymentCinematic" => "IMMEDIATE_CAPTURE",
            "transactionOptions" => [
                "cardOptions" => [
                    "installmentNumber" => 1,
                ]
            ],
            "customer" => [
                "email" => $user->email
            ]
        );
        $credentials = base64_encode($_ENV["IZI_USER"] . ':' . $_ENV["IZI_PASS"]);
        $url = "https://api.micuentaweb.pe/api-payment/V4/Charge/CreatePayment";
        $curl = curl_init();
        $body = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true, // Para recibir la respuesta en lugar de imprimirla directamente
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic " . $credentials,
                "Content-Type: application/json"
            ),
            CURLOPT_POSTFIELDS => json_encode($store)
        );

        curl_setopt_array($curl, $body);
        $response = curl_exec($curl);

        $respon = json_decode($response);

        if ($respon->status == 'ERROR') {
            /* an error occurs, I throw an exception */
            $error = $respon->answer;
            return null;
        }
        curl_close($curl);
        return $respon->answer->formToken;
    }
    function cancelar_subscripcion()
    {
        try {
            $user = Auth::user();
            $subscription = suscripcions::where('user_id', $user->id)->where(function ($query) {
                $query->where('estado', 'ACTIVO')->orWhere('estado', 'ACTIVO');
            })->first();
            if ($subscription) {
                $lastTruePayment = pagos::where('suscripcion_id', $subscription->id)
                    ->where('estado', true)
                    ->orderBy('id', 'desc')
                    ->first();
                if ($lastTruePayment) {
                    $period = $lastTruePayment->periodo;
                } else {
                    $OnePayment = pagos::where('suscripcion_id', $subscription->id)
                        ->where('estado', false)
                        ->orderBy('id', 'asc')
                        ->first();
                    $period = ($OnePayment->periodo) - 1;
                }
                $nextPayment = pagos::where('suscripcion_id', $subscription->id)
                    ->where('estado', false)->where('periodo', $period + 1)
                    ->first();
                if ($nextPayment) {
                    $fechaFin = $nextPayment->fechaCargo;
                } else {
                    $n_fecha = date($lastTruePayment->fechaCargo);
                    $fechaFin = date('Y-m-d', strtotime($n_fecha . ' +1 month'));
                }
                $newSubscription = cancelarSuscripcions::create([
                    "estado" => true,
                    "fecha" => $fechaFin,
                    "suscripcion_id" => $subscription->id
                ]);
                $subscription->estado = "ESPERANDO";
                $subscription->save();
                $persona = personas::where('user_id', $user->id)->first();
                $persona->plan = 'CANCELADO';
                $persona->save();
                $this->CancelSuscriptionIzipay();
                return response()->json(["fecha" => $fechaFin]);
            } else {
                #no existe suscripcion
                return response()->json("Aun No Cuentas Con una Suscripción");
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
    function CancelSuscriptionIzipay()
    {
        $user = Auth::user();
        $subscription = suscripcions::where('user_id', $user->id)->where('estado', 'ACTIVO')->first();

        if ($subscription) {
            $urlSuscriptionCancel = "https://api.micuentaweb.pe/api-payment/V4/Subscription/Cancel";
            $authHeader = base64_encode($_ENV["IZI_USER"] . ":" . $_ENV["IZI_PASS"]);
            $headers = [
                "headers" => [
                    "Authorization" => "Basic " . $authHeader,
                    "Content-Type" => "application/json"
                ]
            ];
            $dataSubscription = [
                "paymentMethodToken" => $subscription->card_id,
                "subscriptionId" => $subscription->suscripcion_id
            ];

            $optionsSubscription = array_merge($headers, ["json" => $dataSubscription]);
            //$optionsCancelSubscription = array_merge($headers, ["json" => $dataOrder]);
            $client = new Client();
            $responseSubs = $client->request("POST", $urlSuscriptionCancel, $optionsSubscription);
            $responseSubs = $responseSubs->getBody()->getContents();
            return true;
        } else {
            return false;
        }
    }
    function CheckCancellationDate()
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $suscription = suscripcions::where("user_id", $user->id)->where("estado", "ESPERANDO")->first();
            if ($suscription) {
                // Buscar la cancelación relacionada con esta suscripción
                $cancelSuscri = cancelarSuscripcions::where("suscripcion_id", $suscription->id)->where("estado", true)->first();

                if ($cancelSuscri && $cancelSuscri->fecha === Carbon::now("America/Lima")->format("Y-m-d")) {
                    // Actualizar los estados y guardar los cambios
                    $suscription->estado = "INACTIVO";
                    $suscription->save();
                    $cancelSuscri->estado = false;
                    $cancelSuscri->save();
                    DB::commit();

                    return response()->json(true);
                }
            }
            DB::commit();
            return response()->json(false);
        } catch (\Throwable $th) {
            return response()->json(false);

            DB::rollBack();
        }
    }
}
