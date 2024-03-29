<?php

namespace App\Http\Controllers;

use App\Models\pagos;
use App\Models\personas;
use App\Models\planes;
use App\Models\suscripcion;
use App\Models\suscripcions;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Openpay\Data\Openpay;
use Carbon\Carbon;

class ControllerPagos extends Controller
{
    private function instanciaopen()
    {
        $openpay = Openpay::getInstance(env('OPENPAY_MERCHANT_ID'), env('OPENPAY_PRIVATE_KEY'), 'PE');

        return $openpay;
    }
    public function crear_cargo_plan_basico(Request $request)
    {
        $user = User::where('email', $request->input('cliente-email'))->first();
        $persona = Personas::where('user_id', $user->id)->first();
        $openpay = $this->instanciaopen();
        $token_id = $request->input('token_id');
        $deviceIdHiddenFieldName = $request->input('deviceIdHiddenFieldName');
        $plan = $openpay->plans->get(env('PLAN_OPEN'));
        $cliente_basico = $this->crearClienteBasico($user, $persona, $openpay);
        $card = $this->agregar_tarjeta_a_cliente($token_id, $deviceIdHiddenFieldName, $cliente_basico);
        if (!is_string($card)) {
            $cargo = $this->cargo_de_prueba_basico($token_id, $deviceIdHiddenFieldName, $cliente_basico);
            if (!is_string($cargo)) {

                $subscription = $this->suscribir_a_cliente($cliente_basico, $card);
                if (!is_string($subscription)) {
                    $subscripcionid = $this->guardar_subscripcion_BD_basico($subscription, $user, $plan);
                    if (!is_string($subscripcionid)) {
                        $pago = $this->guardar_pago_BD_basico($subscripcionid->id);
                        if (!is_string($pago)) {
                            $persona->plan = 'PLAN BASICO';
                            $persona->save();
                            return redirect()->route('successbasico')->with([
                                'exito' => [
                                    'Cargo Actual' => '1 PEN',
                                    'Fecha Próximo cargo' => $subscription->charge_date,
                                    'Cargo Próximo' => $plan->amount . " " . $plan->currency,
                                    'Fecha de creación de la suscripción' => $subscription->creation_date,
                                    'Período actual' => $subscription->current_period_number,
                                    'Fecha de finalización del período actual' => $subscription->period_end_date,
                                    'Estado' => $subscription->status,
                                    'Fecha de finalización de la prueba gratuita' => $subscription->trial_end_date,
                                    'ID del plan de suscripción' => $subscription->plan_id,
                                ]
                            ]);
                        } else {
                            $card->delete();
                            $subscription->delete();
                            $subscripcionid->delete();
                            $persona->plan = 'SIN PLAN';
                            $persona->save();
                            return redirect()->route('errorbasico')->with(['error' => $pago]);
                            #error
                        }
                    } else {
                        $subscription->delete();
                        return redirect()->route('errorbasico')->with(['error' => $subscripcionid]);
                        #error
                    }
                } else {
                    $card->delete();
                    return redirect()->route('errorbasico')->with(['error' => $subscription]);

                    #error
                }
            } else {
                $card->delete();
                return redirect()->route('errorbasico')->with(['error' => $cargo]);


                #error
            }
        } else {
            return redirect()->route('errorbasico')->with(['error' => $card]);
            #error
        }
    }
    private function crearClienteBasico(User $user, personas $persona, $openpay)
    {
        try {
            $customerList = $openpay->customers->getList(['external_id' => $user->email]);
            if (empty($customerList)) {
                // Definir los datos del cliente
                $customerData = [
                    'name' => $user->name,
                    'last_name' => $persona->apellidos,
                    'email' => $user->email,
                    'external_id' => $user->email,
                ];
                // Verificar si el campo "telefono" está presente en la persona
                if ($persona->telefono) {
                    $customerData['phone_number'] = $persona->telefono;
                }
                // Agregar el cliente en OpenPay
                $customer = $openpay->customers->add($customerData);
                return $customer;
            } else {
                // Obtener el primer cliente de la lista
                $customer = $openpay->customers->get($customerList[0]->id);
                return $customer;
            }
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }
    private function agregar_tarjeta_a_cliente($token_id, $deviceIdHiddenFieldName, $cliente_basico)
    {
        try {

            //Agregar tarjeta al cliente
            $card = $cliente_basico->cards->add(array(
                'token_id' => $token_id,
                'device_session_id' => $deviceIdHiddenFieldName,
            ));
            return $card;
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }
    private function suscribir_a_cliente($cliente_basico, $card)
    {
        try {
            $planId = env('PLAN_OPEN');
            $subscription = $cliente_basico->subscriptions->add([
                'plan_id' => $planId,
                'card_id' => $card->id
            ]);
            return $subscription;
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }
    private function cargo_de_prueba_basico($token_id, $deviceIdHiddenFieldName, $cliente_basico)
    {
        try {
            $charge = $cliente_basico->charges->create(array(
                'source_id' => $token_id,
                'method' => 'card',
                'currency' => 'PEN',
                'amount' => 1,
                'description' => 'Cargo Inicial para Validez de Tarjeta',
                'device_session_id' => $deviceIdHiddenFieldName
            ));


            return $charge;
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    private function guardar_subscripcion_BD_basico($subscription, $user, $plan)
    {
        try {
            // Crear la instancia de la suscripción
            $newSubscription = new suscripcions();
            $newSubscription->suscripcion_id = $subscription->id;
            $newSubscription->card_id = $subscription->card->id;
            $newSubscription->cancelado_al_finalizar_periodo = $subscription->cancel_at_period_end;
            $newSubscription->fecha_cargo = $subscription->charge_date;
            $newSubscription->fecha_creacion = Carbon::parse($subscription->creation_date)->toDateTimeString();
            $newSubscription->numero_periodo_actual = $subscription->current_period_number;
            $newSubscription->fecha_fin_periodo = $subscription->period_end_date;
            $newSubscription->estado = $subscription->status;
            $newSubscription->fecha_fin_prueba = $subscription->trial_end_date;
            $newSubscription->cantidad_cargo_predeterminada = $plan->amount . " " . $plan->currency;
            $newSubscription->id_plan = $subscription->plan_id;
            $newSubscription->id_cliente = $subscription->customer_id;
            $newSubscription->user_id = $user->id;
            $newSubscription->save();
            return $newSubscription;
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }
    private function guardar_pago_BD_basico($subscripcionid)
    {
        try {
            $paguito = new pagos();
            $paguito->monto = 1;
            $paguito->descripcion = 'Pago para Validar Tarjeta';
            $paguito->suscripcion_id = $subscripcionid;
            $paguito->save();
            return $paguito;
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }
    function cancel()
    {
        return view('pagos/errorbasico');
    }
    function cancelaw()
    {
        return view('pagos/errorwebhookbasico');
    }
    function success()
    {
        return view('pagos/exitobasico');
    }
}
