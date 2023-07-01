<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerWebhook extends Controller
{
    public function handle(Request $request)
    {
        // Procesa los datos del webhook
        $payload = $request->input('type');
        switch ($payload) {
            case 'charge.failed':
                dd($request);
                break;
            case 'charge.cancelled':
                dd($request);
                break;
            case 'subscription.charge.failed':
                dd($request);
                break;

            default:
                DB::table('tabla')->insert([
                    'codigo' => $request->input('verification_code')
                ]);
                return response()->json(['message' => 'Webhook received'], 200);
                break;
        }
        // Realiza acciones adicionales según los datos recibidos
        // ...

        // Devuelve una respuesta
        return response()->json(['message' => 'Webhook received'], 200);
    }
}
