<?php

namespace App\Http\Controllers;

use App\Mail\EnviarComprobante;
use App\Models\articulos;
use App\Models\clientes;
use App\Models\empresas;
use App\Models\movimientos;
use App\Models\ventas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Mail;
use TCPDF;
use mikehaertl\wkhtmlto\Pdf;
use Knp\Snappy\Image;


class ControllerVentas extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $clientes = clientes::where('user_id', $user->id)->get();
        $empresa = empresas::where("user_id", $user->id)->first();
        $igv = 0;
        if ($empresa) {
            $igv = $empresa->igv;
        }
        $fecha = Carbon::now('America/Lima')->setTimezone('America/Lima')->format('Y-m-d');
        return view('ventas.index', ['igv' => $igv, 'clientes' => $clientes, 'fecha' => $fecha]);
    }
    public function numero_venta()
    {
        $user = Auth::user();
        $venta_actual = ventas::where('user_id', $user->id)->max('id');
        $codigo = "";
        if ($venta_actual != null) {
            $codigo = intval($venta_actual) + 1;
            switch (strlen($codigo)) {
                case 1:
                    $codigo = "NTV0000" . $codigo;
                    break;
                case 2:
                    $codigo = "NTV000" . $codigo;
                    break;
                case 3:
                    $codigo = "NTV00" . $codigo;
                    break;
                case 4:
                    $codigo = "NTV0" . $codigo;
                    break;
                default:
                    $codigo = "NTV" . $codigo;
                    break;
            }
        } else {
            $codigo = 'NTV00001';
        }
        return response()->json($codigo);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $documento = $request->input('documento');
        $fecha = $request->input('fecha');
        $iva = $request->input('iva');
        $nota = $request->input('remision');
        $formaPago = $request->input('pago');
        $montoInicio = $request->input('monto');
        $totalVenta = $request->input('t-pagar');
        $moneda = $request->input('moneda');
        $array_articulos = json_decode($request->input('array_productos'), true);
        $array_otros_articulos = json_decode($request->input('array_productos2'), true);
        $cliente = clientes::where('user_id', $user->id)->where('dni', $request->input('cliente_dni'))->first();
        if ($nota == null) {
            $nota = "SIN NOTA";
        }
        if ($montoInicio == null) {
            $montoInicio = "**";
        }
        $venta = ventas::create([
            'documento' => $documento,
            'fecha' => $fecha,
            'iva' => $iva,
            'nota' => $nota,
            'formaPago' => $formaPago,
            'montoInicio' => $montoInicio,
            'totalVenta' => $totalVenta,
            'moneda' => $moneda

        ]);
        switch ($formaPago) {
            case 'yape':
                $venta->estado = "YAPE";
                $venta->save();
                break;
            case 'parcial':
                $venta->estado = "PARCIAL";
                $venta->save();
                break;
            case 'credito':
                $venta->estado = "CREDITO";
                $venta->save();
                break;
            default:
                $venta->estado = "CANCELADO";
                $venta->save();
                break;
        }

        $venta->clientes()->associate($cliente);
        $venta->usuarios()->associate($user);
        $venta->save();
        if (!empty($array_articulos)) {
            foreach ($array_articulos as $array) {

                $articulos = articulos::where('user_id', $user->id)->where('id', $array['id'])->first();
                if ($articulos) {
                    $venta->articulos()->attach(
                        $articulos->id,
                        [
                            'cantidad' => $array['cantidad'],
                            'user_id' => $user->id
                        ]
                    );
                    $articulos->stock = $articulos->stock - intval($array['cantidad']);
                    $articulos->save();
                }
            }
        }

        if (!empty($array_otros_articulos)) {

            foreach ($array_otros_articulos as $key) {
                $articulo = articulos::create([
                    'descripcion' => $key['presentacion'],
                    'marca' => '*',
                    'presentacion' => '*',
                    'stock' => $key['cantidad'],
                    'precioCompra' => '*',
                    'precioVenta' => $key['precioVenta'],
                    'medida' => '*',
                    'lucro' => '0',
                    'estado' => '0',

                ]);
                $articulo->usuarios()->associate($user);
                $articulo->save();

                $venta->articulos()->attach(
                    $articulo->id,
                    [
                        'cantidad' => $articulo->stock,
                        'user_id' => $user->id
                    ]
                );
            }
        }
        movimientos::create(
            [
                'monto' => $venta->totalVenta,
                'fecha' => $venta->fecha,
                'operacion' => $venta->id,
                'user_id' => $user->id,
                'tipo' => "VENTA",
            ]
        );
        return redirect()->route('detalleVenta', ['id' => $venta->id])->with(['message' => "Venta Completada"]);
    }
    public function detalle($id)
    {
        $user = Auth::user();
        $venta = ventas::where('user_id', $user->id)->where('id', $id)->first();
        $numero_venta = $venta->documento;
        $fecha = explode('-', $venta->fecha);
        $año = $fecha[0];
        $mes = $fecha[1];
        $dia = $fecha[2];
        $cliente = $venta->clientes;
        $productos = $venta->articulos;
        $empresa = empresas::where('user_id', $user->id)->first();

        $iva = 0.0;
        if ($venta->iva == "si") {
            $iva = 0.18;
        }
        $total = $venta->totalVenta;
        $subtotal = number_format($total / (1 + $iva), 2);
        return view('ventas.detalle', ['subtotal' => $subtotal, 'total' => $total, 'iva' => $iva, 'empresa' => $empresa, 'productos' => $productos, 'numero_venta' => $numero_venta, 'año' => $año, 'mes' => $mes, 'dia' => $dia, 'cliente' => $cliente]);
    }
    public function generar_pdf(Request $request)
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

        // agregar contenido
        $pdf->SetFont('times', '', 12);
        $pdf->writeHTML($request->input('html'), true, false, true, false, '');


        // generar el PDF y devolverlo como una respuesta
        return $pdf->Output('documento.pdf', 'I');
    }
    public function enviar_comprobante(Request $request)
    {
        $user = Auth::user();
        $empresa = empresas::where('user_id', $user->id)->first();
        try {
            Mail::to($request->input('email'))->send(new EnviarComprobante($empresa, $request->input('imagen')));

            return redirect()->back()->with('mensaje', 'Comprobante Enviado al Correo' . ' ' . $request->input('email'));
        } catch (\Exception $th) {

            return redirect()->back()->with('error', "No se Pudo Enviar el comprobante por " . " " . $th->getMessage());
        }
    }
    public function imprimir(Request $request)
    {
    }
    public function detalleventas()
    {
        return view('ventas/dventas');
    }
    public function detalle_venta(Request $request)
    {
        $user = Auth::user();
        $venta = ventas::where('user_id', $user->id)->where('documento', $request->input('venta'))->first();
        $reponse = [];
        if ($venta) {
            $cliente = clientes::where('user_id', $user->id)->where('id', $venta->cliente_id)->first();
            $productos = $venta->articulos;
            array_push($reponse, [$venta, $cliente, $productos]);

            return response()->json($reponse);
        } else {
            return response()->json(500);
        }
    }
}
