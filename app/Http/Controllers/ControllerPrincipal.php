<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerPrincipal extends Controller
{
    public function dashboard(Request $request)
    { 

        $usuario=Auth::user()->name;
        return view('principal.dashboard',['usuario'=>$usuario]);
    }
}
