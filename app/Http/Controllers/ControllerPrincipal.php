<?php

namespace App\Http\Controllers;

use App\Models\clientes;
use App\Models\compras;
use App\Models\ventas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerPrincipal extends Controller
{
    public function dashboard(Request $request)
    {

        $usuario = Auth::user()->name;
        return view('principal.dashboard', ['usuario' => $usuario]);
    }
    public function compras_ventas(Request $request)
    {
        $user = Auth::user();
        $ventas = ventas::where('user_id', $user->id)
            ->whereDate('fecha', Carbon::now())
            ->select(\DB::raw('SUM(totalVenta) as monto_venta'))
            ->first();
        $compras = compras::where('user_id', $user->id)
            ->whereDate('fecha', Carbon::now())
            ->select(\DB::raw('SUM(totalCompra) as monto_compra'))
            ->first();
        $respuesta = [$compras->monto_compra ?? 0.0, $ventas->monto_venta ?? 0.0];
        return response()->json($respuesta);
    }

    public function ventas_mayores(Request $request){
        $user=Auth::user();
        $ventas = ventas::where('user_id', $user->id)
        ->whereDate('fecha', Carbon::now())
        ->select('cliente_id','totalVenta as monto_venta')
        ->orderBy('monto_venta', 'DESC')
        ->limit(3)
        ->get();
        $respuesta=[];
        foreach ($ventas as $key) {
            $cli=clientes::where('user_id',$user->id)->where('id',$key->cliente_id)->first();
            array_push($respuesta,['cliente'=>$cli->cliente,'monto'=>$key->monto_venta]);
        }
        return response()->json($respuesta);
    }
}
