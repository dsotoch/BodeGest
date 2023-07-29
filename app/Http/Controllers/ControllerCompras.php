<?php

namespace App\Http\Controllers;

use App\Models\articulos;
use App\Models\compras;
use App\Models\empresas;
use App\Models\movimientos;
use App\Models\provedores;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TCPDF;
use Intervention\Image\Facades\Image;

class ControllerCompras extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('compras.index');
    }
    public function codigo()
    {
        $user = Auth::user();
        $codigo_actual = compras::where('user_id', $user->id)->max('id');
        $codigo = intval($codigo_actual) + 1;
        return response()->json(['codigo' => $codigo]);
    }
    public function proveedores(Request $request)
    {
        $user = Auth::user();
        $provedores = provedores::where('user_id', $user->id)->get();
        return response()->json($provedores);
    }
    public function productos(Request $request)
    {
        $user = Auth::user();
        $productos = articulos::where('user_id', $user->id)->where('estado', '1')->where('stock', '>', 0)->get();
        return response()->json($productos);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create(Request $request)
    {
        $user = Auth::user();
        $compra = new compras();
        $compra->totalCompra = $request->input('total-compra');
        $compra->metodoPago = $request->input('metodo');
        $compra->provedor = $request->input('proveedor');
        $compra->fecha = Carbon::parse($request->input("fecha"));
        $compra->usuarios()->associate($user);

        $imagencomprimida = Image::make($request->file('comprobante'))->encode('jpg', 80);
        $nombreunico = time() . $request->file('comprobante')->getClientOriginalName();
        $rutaImagenComprimida = 'imagenes/usuarios/' . $nombreunico;

        $imagencomprimida->save(public_path($rutaImagenComprimida));
        $compra->comprobante = $nombreunico;
        $compra->public_path = $rutaImagenComprimida;
        $compra->save();
        movimientos::create(
            [
                'monto' => $request->input('total-compra'),
                'fecha' => Carbon::parse($request->input("fecha")),
                'operacion' => $compra->id,
                'user_id' => $user->id,
                'tipo' => "COMPRA",
            ]
        );

        return redirect()->route('compras')->with(['mensaje' => "Compra Numero" . " "  . $compra->id . " Registrada Correctamente"]);
    }
    public function finalizar($id)
    {
        $user = Auth::user();
        $compra = compras::where('user_id', $user->id)->where('id', $id)->first();
        $empresa = empresas::where('user_id', $user->id)->first();
        if ($empresa && $empresa->exists()) {
            return  view('compras.finalizarcompra', ['compra' => $compra, 'empresa' => $empresa]);
        } else {
            $empresa = empresas::where('user_id', NULL)->first();
            return  view('compras.finalizarcompra', ['compra' => $compra, 'empresa' => $empresa]);
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
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detallecompras()
    {
        $user = Auth::user();
        $compras = compras::where('user_id', $user->id)->get();
        return view('compras/dcompras', ['compras' => $compras]);
    }
    public function detalle_compra(Request $request)
    {
        
        $user = Auth::user();
        $compras = compras::where('user_id', $user->id)->where('id', $request->input('compra'))->first();
       
        if ($compras) {
            return response()->json($compras);
        } else {
            return response()->json(500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function generarPdf(Request $request)
    {

        $pdf = new TCPDF();

        // Establece la configuración del PDF
        $pdf->SetMargins(20, 20, 20);
        $pdf->AddPage();
        $pdf->SetPageOrientation('L');

        // Agrega el contenido HTML al PDF
        $pdf->writeHTML($request->input('pdf'), true, false, true, false, '');
        $pdfContent = $pdf->Output('', 'S');
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="mi-pdf-generado-con-tcpdf.pdf"',
        ]);
    }
}
