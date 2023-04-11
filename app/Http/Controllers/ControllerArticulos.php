<?php

namespace App\Http\Controllers;

use App\Models\articulos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ControllerArticulos extends Controller
{
    public function index(Request $request)
    {
        $articulos = articulos::all();
        $numero_productos = $articulos->count();
        $columnas = array_slice(Schema::getColumnListing('articulos'), 0, -5);
        $productos_con_stock = $articulos->where('stock', '>', 0)->count();
        $productos_sin_stock = $articulos->where('stock', '<=', 0)->count();
        if ($numero_productos === 0) {
            $porcentaje_stock = 100;
            $porcentaje_sin_stock = 100;
        } else {
            $porcentaje_stock = ($productos_con_stock / $numero_productos) * 100;
            $porcentaje_sin_stock = ($productos_sin_stock / $numero_productos) * 100;
        }
        return view('articulos.index', ['porcentaje_sin_stock' => $porcentaje_sin_stock, 'porcentaje' => $porcentaje_stock, 'numero_productos' => $numero_productos, 'articulos' => $articulos, 'columnas' => $columnas, 'stock' => $productos_con_stock, 'sin_stock' => $productos_sin_stock]);
    }
    public function crear_articulo(Request $request)
    {
        $articulo = articulos::create([
            'descripcion' => $request->input('descripcion'),
            'marca' => $request->input('marca'),
            'medida' => $request->input('medida'),
            'presentacion' => $request->input('presentacion'),
            'stock' => $request->input('stock'),
            'precioCompra' => $request->input('precioCompra'),
            'precioVenta' => $request->input('precioVenta'),
            'lucro' => $request->input('lucro'),

        ]);
        return response()->json($articulo);
    }

    public function eliminar_todo(Request $request)
    {
        $articulos = new articulos();
        $articulos->truncate();

        return response()->json(true);
    }
}
