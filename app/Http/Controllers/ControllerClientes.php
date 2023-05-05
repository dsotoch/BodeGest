<?php

namespace App\Http\Controllers;

use App\Models\clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerClientes extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $existe = clientes::where('user_id', $user->id)->where('dni', $request->input('dni'))->first();
        if ($existe) {
            return response()->json(false);
        } else {
            $cliente = clientes::create([
                'dni' => $request->input('dni'),
                'telefono' => $request->input('telefono'),
                'email' => $request->input('email'),
                'cliente' => $request->input('cliente'),

            ]);
            $cliente->usuarios()->associate($user);
            $cliente->save();
            return response()->json($cliente);
        }
    }
}
