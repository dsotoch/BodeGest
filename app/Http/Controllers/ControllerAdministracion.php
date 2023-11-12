<?php

namespace App\Http\Controllers;

use App\Models\articulos;
use App\Models\clientes;
use App\Models\compras;
use App\Models\ventas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerAdministracion extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $productos = articulos::where('user_id', $user->id)->where('stock', '<=', 3)->where("estado",true)->get();
        return view('dashboard.admin', ['productos' => $productos]);
    }
    public function datos()
    {
        $user = Auth::user();
        $total_venta = ventas::where('user_id', $user->id)->select(\DB::raw('SUM(totalVenta)as monto_compras'))
            ->orderBy('monto_compras', 'DESC')
            ->limit(1)->first();
        $clientes_top = ventas::where('user_id', $user->id)->select('cliente_id', \DB::raw('SUM(totalVenta)as monto_compras'))
            ->groupBy('cliente_id')
            ->orderBy('monto_compras', 'DESC')
            ->limit(3)->get();
        $objects_clientes_top = [];
        foreach ($clientes_top as $key) {
            $porcentajes = ['cliente' => clientes::where('user_id', $user->id)->where('id', $key->cliente_id)->first(), 'porcentaje' => (($key->monto_compras * 100) / doubleval($total_venta->monto_compras))];
            array_push($objects_clientes_top, $porcentajes);
        }
        return response()->json($objects_clientes_top);
    }
    public function ingresos_vs_egresos()
    {
        $user = Auth::user();
        $fechas = [];
        $ingresos = [];
        $egresos = [];
        for ($i = 3; $i >= 1; $i--) {
            $fecha_inicio = now('America/Lima')->subWeeks($i)->startOfWeek();
           $fecha_fin = now('America/Lima')->subWeeks($i)->endOfWeek();
            array_push($fechas, ['inicio' => $fecha_inicio->format('d/m/Y'), 'fin' => $fecha_fin->format('d/m/Y')]);
            $ingresos_total = ventas::whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                ->where('user_id', $user->id)
                ->sum('totalVenta');
            array_push($ingresos, ['ingresos' => $ingresos_total]);
            $egresos_total = compras::whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                ->where('user_id', $user->id)
                ->sum('totalCompra');
            array_push($egresos, ['egresos' => $egresos_total]);
        }

        $resultados = [];
        array_push($resultados, ['ingresos' => $ingresos, 'egresos' => $egresos, 'fechas' => $fechas]);
        return response()->json($resultados);
    }
    public function ventas_6_meses()
    {
        $user = Auth::user();
        $meses = array(
            'January' => 'Enero',
            'February' => 'Febrero',
            'March' => 'Marzo',
            'April' => 'Abril',
            'May' => 'Mayo',
            'June' => 'Junio',
            'July' => 'Julio',
            'August' => 'Agosto',
            'September' => 'Septiembre',
            'October' => 'Octubre',
            'November' => 'Noviembre',
            'December' => 'Diciembre'
        );
        $meses_anteriores_nombres=[];

        $fecha_actual = Carbon::now('America/Lima');
        $meses_anteriores = [];
        for ($i = 1; $i < 5; $i++) {
            $fecha_anterior = $fecha_actual->subMonth();
            $mes_anterior = $fecha_anterior->month;
            $anio_anterior = $fecha_actual->year;
            $meses_anteriores[] = [
                'mes' => $mes_anterior,
                'anio'=>$anio_anterior,
            ];
           
            array_push($meses_anteriores_nombres,$meses[$fecha_anterior->format('F')].'-'.$anio_anterior);

        }
        $array_ventas = [];
        foreach ($meses_anteriores as $key) {
            $fecha_mes=$key['mes'];
            $anio=$key['anio'];
            $ventas = ventas::where('user_id', $user->id)
                ->whereYear('fecha',$anio)
                ->whereMonth('fecha', $fecha_mes)
                ->select(\DB::raw('MONTH(fecha) as mes'),\DB::raw('SUM(totalVenta) as monto_venta'))
                ->groupBy('mes')
                ->first();
            
            array_push($array_ventas, $ventas->monto_venta ?? 0);
            
        }
        $respuesta[] = ['meses'=>$meses_anteriores_nombres,'montos'=> $array_ventas];

        return response()->json($respuesta);
    }
}
