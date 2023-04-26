<?php

namespace App\Http\Controllers;

use App\Models\provedores;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerProvedores extends Controller
{
   public function index(Request $request)
   {
      $user = Auth::user();
      $provedores = provedores::where('user_id', $user->id)->get();
      return view('provedores.index', ['provedores' => $provedores]);
   }
   public function detalle_provedor(Request $request, $id)
   {
      $user = Auth::user();
      $provedores = provedores::where('user_id', $user->id)->where('id', $id)->first();
      return response()->json($provedores);
   }
   public function registrar_provedor(Request $request)
   {
      $user = Auth::user();
      $provedores = provedores::create([
         'nombre' => $request->input('nombre'),
         'direccion' => $request->input('direccion'),
         'pais' => $request->input('pais'),
         'telefono' => $request->input('telefono'),
         'servicio' => $request->input('servicio'),
         'correo' => $request->input('email'),
         
      ]);
      $provedores->usuarios()->associate($user);
      $provedores->save();
      return response()->json($provedores);
   }
   public function modificar_provedor(Request $request, $id)
   {
      $user = Auth::user();
      $provedores = provedores::where('user_id', $user->id)->where('id', $id)->first();
      $provedores->nombre = $request->input('nombre');
      $provedores->direccion = $request->input('direccion');
      $provedores->pais = $request->input('pais');
      $provedores->telefono = $request->input('telefono');
      $provedores->servicio = $request->input('servicio');
      $provedores->correo = $request->input('email');
      $provedores->save();
      return response()->json($provedores);
   }
   public function eliminar_provedor(Request $request, $id)
   {
      $user = Auth::user();
      provedores::where('user_id', $user->id)->where('id', $id)->delete();

      return response()->json(true);
   }
   public function generar_codigo(Request $request)
   {
      $user = Auth::user();
      $num = 0;
      $codigo = provedores::where('user_id', $user->id)->max('id');
      if ($codigo != null) {
         $num = $codigo;
      }

      return response()->json(['codigo' => $num]);
   }
}
