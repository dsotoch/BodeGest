<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerWebhook extends Controller
{
    public function handle(Request $request)
    {
        // Procesa los datos del webhook
        $payload = $request->all();

        // Realiza acciones adicionales según los datos recibidos
        // ...

        // Devuelve una respuesta
        return response()->json(['message' => 'Webhook received']);
    }
}
