<?php

namespace App\Http\Controllers;

use App\Models\articulos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class ControllerArticulos extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $articulos = articulos::where('user_id', $user->id)->get();
        $numero_productos = $articulos->count();
        $columnas = array_slice(Schema::getColumnListing('articulos'), 0, -6);
        $productos_con_stock = $articulos->where('stock', '>', 0)->count();
        $productos_sin_stock = $articulos->where('stock', '<=', 0)->count();
        if ($numero_productos === 0) {
            $porcentaje_stock = 100;
            $porcentaje_sin_stock = 100;
        } else {
            $porcentaje_stock = round(($productos_con_stock / $numero_productos) * 100, 2);
            $porcentaje_sin_stock = round(($productos_sin_stock / $numero_productos) * 100, 2);
        }
        return view('articulos.index', ['porcentaje_sin_stock' => $porcentaje_sin_stock, 'porcentaje' => $porcentaje_stock, 'numero_productos' => $numero_productos, 'articulos' => $articulos, 'columnas' => $columnas, 'stock' => $productos_con_stock, 'sin_stock' => $productos_sin_stock]);
    }
    public function crear_articulo(Request $request)
    {
        $user = Auth::user();
        $articulo = articulos::create([
            'descripcion' => $request->input('descripcion'),
            'marca' => $request->input('marca'),
            'medida' => $request->input('medida'),
            'presentacion' => $request->input('presentacion'),
            'stock' => $request->input('stock'),
            'precioCompra' => $request->input('precioCompra'),
            'precioVenta' => $request->input('precioVenta'),
            'lucro' => $request->input('lucro')
        ]);
        $articulo->usuarios()->associate($user);
        $articulo->save();
        return response()->json($articulo);
    }

    public function eliminar_todo(Request $request)
    {
        $user = Auth::user();
        $articulos = new articulos();
        $articulos->where('user_id', $user->id)->truncate();

        return response()->json(true);
    }
    public function eliminar(Request $request, $id)
    {
        $user = Auth::user();
        articulos::where('id', $id)->where('user_id', $user->id)->delete();

        return response()->json(true);
    }
    public function buscar_articulo(Request $request, $id)
    {
        $user = Auth::user();
        $articulo = articulos::where('user_id', $user->id)->where('id', $id)->get();
        return response()->json($articulo);
    }
    public function modificar_articulo(Request $request, $id)
    {
        $user = Auth::user();
        $articulo = articulos::where('user_id', $user->id)->where('id', $id)->first();
        $articulo->descripcion = $request->input('descripcion');
        $articulo->stock = $request->input('stock');
        $articulo->marca = $request->input('marca');
        $articulo->precioVenta = $request->input('precioVenta');
        $articulo->lucro = $request->input('lucro');
        $articulo->save();
        return response()->json($articulo);
    }
}
