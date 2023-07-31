<?php

namespace App\Http\Controllers;

use App\Mail\EnviarCuenta;
use App\Models\clientes;
use App\Models\empresas;
use App\Models\saldos;
use App\Models\ventas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use TCPDF;

class ControllerCuenta extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $cuentas = ventas::where('user_id', $user->id)->where('estado', '!=', 'CANCELADO')->get();
        $saldos=saldos::where('user_id', $user->id)->where('estado', '!=', 'CANCELADO')->get();
        $cuentas_parcial = $cuentas->where('estado', 'PARCIAL');
        $cuentas_fiadas = $cuentas->where('estado', 'CREDITO');
        $n_pacrial = 0;
        $n_fiadas = 0;
        if ($cuentas_parcial) {
            $n_pacrial = $cuentas_parcial->count();
        }
        if ($cuentas_fiadas) {
            $n_fiadas = $cuentas_fiadas->count();
        }
        $total_sin_pagar = $n_pacrial + $n_fiadas;
        $fecha_actual = Carbon::now('America/Lima');
        $cliente = [];
        $ventas = ventas::where('user_id', $user->id)->where('estado', '!=', 'CANCELADO')->select(
            'cliente_id',
            \DB::raw('SUM(totalVenta) as total_venta'),
            \DB::raw('MIN(fecha) as fecha_minima'),
            \DB::raw('SUM(montoInicio) as monto_inicial')
        )
            ->groupBy('cliente_id')
            ->havingRaw(DB::raw('DATE_ADD(MIN(fecha), INTERVAL 15 DAY) > ?'), [$fecha_actual])
            ->get();
        $ventas_mayores_15 = $ventas->count();
        foreach ($ventas as $venta) {
            $venta->cliente = clientes::where('user_id', $user->id)->where('id', $venta->cliente_id)->first();
            $venta->monto_deuda = $venta->total_venta - $venta->monto_inicial;
        }
        $ventas2 = ventas::where('user_id', $user->id)
            ->where('estado', '!=', 'CANCELADO')
            ->select(
                'cliente_id',
                \DB::raw('SUM(totalVenta) as total_venta'),
                \DB::raw('MIN(fecha) as fecha_minima'),
                \DB::raw('SUM(montoInicio) as monto_inicial')
            )
            ->groupBy('cliente_id')
            ->havingRaw('total_venta - monto_inicial > 100')
            ->get();
        $ventas_mayores_100 = $ventas2->count();
        foreach ($ventas2 as $value) {
            $value->monto_deuda = $value->total_venta - $value->monto_inicial;
            $value->cliente = clientes::where('user_id', $user->id)->where('id', $value->cliente_id)->first();
        }

        $deudas = ventas::where('user_id', $user->id)->where('estado', '!=', 'CANCELADO')->select(
            'cliente_id',
            \DB::raw('SUM(totalVenta)as total_venta'),
            \DB::raw('MIN(fecha) as fecha_minima'),
            \DB::raw('SUM(montoInicio) as monto_inicial')
        )
            ->groupBy('cliente_id')
            ->get();
        foreach ($deudas as $key) {
            $key->monto_deuda = $key->total_venta - $key->monto_inicial;
            $key->cliente = clientes::where('user_id', $user->id)->where('id', $key->cliente_id)->first();
        }
        $todos = $deudas->count();

        return view('dashboard.cuenta', ['saldos'=>$saldos,'deudas' => $deudas, 'todos' => $todos, 'cliente' => $ventas, 'clientes' => $ventas2, 'total' => $total_sin_pagar, 'mayores15' => $ventas_mayores_15, 'mayores100' => $ventas_mayores_100]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function email(Request $request)
    {
        $user = Auth::user();
        $cliente = clientes::where('dni', $request->input('dni'))->where('user_id', $user->id)->first();
        $empresa = empresas::where('user_id', $user->id)->first();
        $ima = $request->input('imagen');
        $im = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $ima));
        $imagen_reconstruida = imagecreatefromstring($im);
        ob_start();
        imagepng($imagen_reconstruida);
        $contents = ob_get_contents();
        ob_end_clean();


        try {

            Mail::to($cliente->email)
                ->send((new EnviarCuenta($empresa))->attachData($contents, 'comprobante.png', ['mime' => 'image/png']));

            return redirect()->back()->with(['mensaje' => "Estado de Cuenta Enviado Correctamente al Correo" . " " . $cliente->email]);
        } catch (\Exception $th) {
            return redirect()->back()->with(['error' => "No se Pudo Enviar el Comprobante al Correo" . " " . $cliente->email . "porque" . $th->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // crear una nueva instancia de TCPDF
        $pdf = new TCPDF();

        // establecer las opciones del documento
        $pdf->SetCreator('Mi aplicación Laravel');
        $pdf->SetAuthor('Yo');
        $pdf->SetTitle('Mi documento PDF');
        $pdf->SetSubject('Demostración de TCPDF en Laravel');
        $pdf->SetKeywords('TCPDF, PDF, Laravel');

        // agregar una página
        $pdf->AddPage();
        $ima = $request->input('imagen');
        $im = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $ima));
        $imagen_reconstruida = imagecreatefromstring($im);
        ob_start();
        imagepng($imagen_reconstruida);
        $contents = ob_get_contents();
        ob_end_clean();
        // agregar contenido
        $pdf->Image($im, 10, 10, 100, 0, 'PNG');



        // generar el PDF y devolverlo como una respuesta
        return $pdf->Output('documento.pdf', 'I');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $cliente = clientes::where('user_id', $user->id)->where('dni', $id)->first();
        $ventas = ventas::where('user_id', $user->id)->where('cliente_id', $cliente->id)->where('estado', '!=', 'CANCELADO')->get();
        $datos_venta = [];
        $igv = 0.0;
        foreach ($ventas as $key => $value) {
            if ($value->iva == 'si') {
                $base = $value->totalVenta / (1.18);
                $igv = $value->totalVenta - $base;
            }
            array_push($datos_venta, ['montoInicio' => $value->montoInicio, 'fecha' => $value->fecha, 'articulos' => $value->articulos, 'total' => $value->totalVenta, 'igv' => $igv]);
        }
        return response()->json($datos_venta);
    }

    public function cancelar_saldo($dni,Request $request)
    {
        $user = Auth::user();
        $cliente = clientes::where('dni', $dni)->where('user_id', $user->id)->first();
        $cliente->saldos()->where('estado', '!=', 'CANCELADO')->update(['estado' => 'CANCELADO','fecha'=>$request->input('fecha')]);
        return response()->json($cliente);
    }
    public function cancelar_deuda($dni)
    {
        $user = Auth::user();
        $cliente = clientes::where('dni', $dni)->where('user_id', $user->id)->first();
        $cliente->ventas()->where('estado', '!=', 'CANCELADO')->update(['estado' => 'CANCELADO']);
        return response()->json($cliente);
    }
    public function guardar_restante(Request $request)
    {
        $user = Auth::user();
        $cliente = clientes::where('user_id', $user->id)->where('dni', $request->input('dni'))->first();
        $saldo = saldos::create([
            "monto_deuda" => $request->input('monto_deuda'),
            "monto_recibido" => $request->input('monto_recibido'),
            "monto_restante" => $request->input('monto_restante'),
            "fecha" => $request->input('fecha'),
            "estado" =>'PARCIAL',

        ]);
        $saldo->usuarios()->associate($user);
        $saldo->clientes()->associate($cliente);
        $saldo->save();
        $cliente->ventas()->where('estado', '!=', 'CANCELADO')->update(['estado' => 'CANCELADO']);
        return response()->json($cliente);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
