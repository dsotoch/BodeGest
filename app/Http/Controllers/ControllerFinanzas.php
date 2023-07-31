<?php

namespace App\Http\Controllers;

use App\Models\compras;
use App\Models\finanzas;
use App\Models\ventas;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class ControllerFinanzas extends Controller
{
   public function index()
   {
      $user = Auth::user();
      $ultimo_balance = finanzas::where('user_id', $user->id)->max('fechaTermino');
      $anterior = Carbon::now('America/Lima');
      if ($ultimo_balance == null) {
         $anterior->subDays(2);
      } else {
         $anterior = Carbon::parse($ultimo_balance);
      }
      $ultimo_reporte = $anterior->copy()->addDay();
      $saldo = finanzas::where('user_id', $user->id)->value('saldo');
      if ($saldo == null) {
         $saldo = 0.0;
      }
      return view('dashboard/finanzas', ['ultimo' => $ultimo_reporte, 'anterior' => $anterior, 'saldo' => $saldo]);
   }
   public function balance(Request $request)
   {
      $user = Auth::user();

      $fechaString = $request->input('fecha');
      $timestamp = strtotime($fechaString);
      $req_fecha = $request->input('fecha_termino');

      $fecha_termino = "";
      switch ($req_fecha) {
         case 'semanal':
            $fecha_termino = date('Y-m-d', strtotime("+7 days", $timestamp)); // Sumar los días y obtener la nueva fecha

            break;
         case 'quincenal':
            $fecha_termino = date('Y-m-d', strtotime("+15 days", $timestamp)); // Sumar los días y obtener la nueva fecha
            break;
         case 'mensual':
            $fecha_termino = date('Y-m-d', strtotime("+1 month", $timestamp));
            break;
         case 'trimestral':
            $fecha_termino = date('Y-m-d', strtotime("+3 month", $timestamp));
            break;


         default:
            $fecha_termino = date('Y-m-d', strtotime("+1 year", $timestamp));
            break;
      }
      $compras_por_fecha = compras::where('user_id', $user->id)->whereDate('fecha', '>=', date('Y-m-d', $timestamp))->whereDate('fecha', '<=', $fecha_termino)->get();
      $ventas_por_fecha = ventas::where('user_id', $user->id)
         ->whereDate('fecha', '>=', date('Y-m-d', $timestamp))
         ->whereDate('fecha', '<=', $fecha_termino)
         ->get();

      $response = [];
      $m_compra = $compras_por_fecha->sum('totalCompra');
      $m_venta = $ventas_por_fecha->sum('totalVenta');
      array_push($response, [['m_compra' => $m_compra], ['m_venta' => $m_venta], ['fecha' => date('d-m-Y', strtotime($fecha_termino))], ['compras' => $compras_por_fecha], ['ventas' => $ventas_por_fecha]]);
      return response()->json($response);
   }

   public function guardarbalance(Request $request)
   {
      $user = Auth::user();
      $ultimo_balance = finanzas::where('user_id', $user->id)->max('fechaTermino');
      $anterior = Carbon::now('America/Lima');
      if ($ultimo_balance == null) {
         $anterior->subDays(2);
      } else {
         $anterior = Carbon::parse($ultimo_balance);
      }
      $ultimo_reporte = $anterior->copy()->addDay();
      $saldocaja = finanzas::where('user_id', $user->id)->value('saldo');
      if ($saldocaja == null) {
         $saldocaja = 0.0;
      }
      $fechaString = $ultimo_reporte;
      $timestamp = strtotime($fechaString);
      $req_fecha = $request->input('periodo');

      $fecha_termino = "";
      switch ($req_fecha) {
         case 'semanal':
            $fecha_termino = date('Y-m-d', strtotime("+7 days", $timestamp)); // Sumar los días y obtener la nueva fecha

            break;
         case 'quincenal':
            $fecha_termino = date('Y-m-d', strtotime("+15 days", $timestamp)); // Sumar los días y obtener la nueva fecha
            break;
         case 'mensual':
            $fecha_termino = date('Y-m-d', strtotime("+1 month", $timestamp));
            break;
         case 'trimestral':
            $fecha_termino = date('Y-m-d', strtotime("+3 month", $timestamp));
            break;


         default:
            $fecha_termino = date('Y-m-d', strtotime("+1 year", $timestamp));
            break;
      }
      $compras_por_fecha = compras::where('user_id', $user->id)->whereDate('fecha', '>=', date('Y-m-d', $timestamp))->whereDate('fecha', '<=', $fecha_termino)->get();
      $ventas_por_fecha = ventas::where('user_id', $user->id)
         ->whereDate('fecha', '>=', date('Y-m-d', $timestamp))
         ->whereDate('fecha', '<=', $fecha_termino)
         ->get();
      $m_compra = $compras_por_fecha->sum('totalCompra');
      $m_venta = $ventas_por_fecha->sum('totalVenta');
      $m_retiro = floatval($request->input('m-retiro'));
      $m_totalBalance = number_format(($m_venta - $m_compra), 2);
      $saldo = number_format((($m_totalBalance - $m_retiro)+$saldocaja),2);
      finanzas::create([
         'fechaInicio' => $ultimo_reporte,
         'fechaTermino' => $fecha_termino,
         'periodo' => $request->input('periodo'),
         'totalCompras' => $m_compra,
         'totalVentas' => $m_venta,
         'totalBalance' => $m_totalBalance,
         'retiro' => $m_retiro,
         'saldo' => $saldo,
         'user_id' => $user->id
      ]);
      return redirect()->back()->with(['message'=>"Balance Registrado Correctamente, su nuevo Saldo en caja es de:" ." ".$saldo]);
   }
}
