<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerVentas extends Controller
{
    public function index()
    {
        $igv=18;
        return view('ventas.index',['igv'=>$igv]);
    }
}
