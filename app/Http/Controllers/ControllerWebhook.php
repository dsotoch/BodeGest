<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerWebhook extends Controller
{
    public function handle(Request $request)
    {
        // Procesa los datos del webhook
        $payload = $request->all();
        $verificationCode = $request->input('verification_code');
        DB::table('webhook')->insert([
            'codigo' => $verificationCode,
        ]);
        // Realiza acciones adicionales según los datos recibidos
        // ...

        // Devuelve una respuesta
        return response()->json(['message' => 'Webhook received'],200);
    }
}
