<?php

namespace App\Http\Controllers;

use App\Models\articulos;
use App\Models\compras;
use App\Models\empresas;
use App\Models\provedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TCPDF;

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
        $productos = articulos::where('user_id', $user->id)->where('estado','1')->get();
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
        $id_productos = $request->input('productos');
        $proveedor = provedores::where('user_id', $user->id)->where('id', $request->proveedor)->first();
        $compra = new compras();
        $compra->totalCompra = $request->total;
        $compra->metodoPago = $request->metodo;
        $compra->provedores()->associate($proveedor);
        $compra->usuarios()->associate($user);
        $compra->save();

        foreach ($id_productos as $key => $value) {
            $producto = articulos::where('user_id', $user->id)->find($value);
            $producto->compras()->associate($compra);
            $producto->save();
            $producto->provedores()->associate($proveedor);
            $producto->save();
        }
        $url = route('finalizar', ['id' => $compra->id]);
        return response()->json(['url' => $url]);
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
    public function show($id)
    {
        //
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
