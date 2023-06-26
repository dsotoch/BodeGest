<?php

namespace App\Http\Controllers;

use App\Models\compras;
use App\Models\movimientos;
use App\Models\ventas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerHome extends Controller
{
   public function index()

   {
    $user=Auth::user();
    $compras=compras::where('user_id',$user->id)->whereDate('fecha',Carbon::now('America/Lima')->format('Y-m-d'))->sum('totalCompra');

    $ventas=ventas::where('user_id',$user->id)->whereDate('fecha',Carbon::now('America/Lima')->format('Y-m-d'))->sum('totalVenta');
    $saldo=number_format((doubleval($ventas)-doubleval($compras)),2);
    $movimientos=movimientos::where('user_id',$user->id)->whereDate('fecha',Carbon::now('America/Lima'))->get();
    return view('dashboard/home',['saldo'=>$saldo,'movimientos'=>$movimientos,'fecha'=>Carbon::now('America/Lima')->format('d-m-Y')]);
   }
}
