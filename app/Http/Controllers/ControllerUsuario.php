<?php

namespace App\Http\Controllers;

use App\Mail\CorreoConfirmacion;
use App\Models\confirmacions;
use App\Models\empresas;
use App\Models\personas;
use App\Models\planes;
use App\Models\suscripcions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\Catch_;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class ControllerUsuario extends Controller
{
    public function login()
    {
        $precioPlanBasico = Planes::where('nombre', 'PLAN BASICO')->value('precio');
        $precioPlanFacturador = Planes::where('nombre', 'PLAN FACTURADOR')->value('precio');


        return view('layouts/login', ['planbasico' => $precioPlanBasico, 'planfacturador' => $precioPlanFacturador]);
    }
    public function crearUsuario(Request $request)
    {
        try {


            if (User::where('email', $request->input('email'))->exists()) {
                return response()->json('EXISTE');
            } else {
                $user = User::create([
                    'name' => $request->input('nombres'),
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                    'pass' => $request->input('password'),
                    'dni' => $request->input('dni')
                ]);
                $persona = personas::create([
                    'apellidos' => $request->input('apellidos'),
                    'estado' => 'sin-verificar',
                ]);
                $persona->usuarios()->associate($user);
                $persona->save();

                $token = Str::random(40);
                confirmacions::create([
                    'email' => $request->input('email'),
                    'token' => $token
                ]);
                $url = getenv("URL_CONFIRMACION_EMAIL") . $token;
                try {
                    Mail::to($request->input('email'))->send(new CorreoConfirmacion($url));

                    return response()->json($user);
                } catch (\Exception $th) {

                    return response()->json($th->getMessage());
                }
            }
        } catch (\Exception $th) {

            return response()->json($th->getMessage());
        }
    }

    public function validarToken($token)
    {
        try {
            $token_valido = confirmacions::where('token', $token)->first();
            if ($token_valido) {
                $user = User::where('email', $token_valido->email)->first();
                $user->email_verified_at = Carbon::now('America/Lima');
                $user->save();
                $persona = $user->personas;
                $persona->estado = 'verificado';
                $persona->save();

                return redirect()->route('login')->with(['success' => 'Cuenta Verificada Correctamente,ya puedes Iniciar Sesion']);
            } else {
                return redirect()->route('login')->with(['error' => 'El token no coincide con el generado']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('login')->with(['error' => 'El token no coincide con el generado']);
        }
    }
    public function IniciarSesion(Request $request)
    {
        try {
            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                return response()->json('correo');
            }

            $isVerificate = confirmacions::where('email', $request->input('email'))->first();

            if ($user->email_verified_at == null) {
                if ($isVerificate) {
                    return response()->json('verificado');
                } else {
                    $token = Str::random(40);

                    $url = env("URL_CONFIRMACION_EMAIL") . $token;
                    try {
                        Mail::to($request->input('email'))->send(new CorreoConfirmacion($url));
                        confirmacions::create([
                            'email' => $request->input('email'),
                            'token' => $token
                        ]);
                        return response()->json('verificado');
                    } catch (\Exception $th) {

                        return response()->json($th->getMessage());
                    }
                }
            } else {
                $persona = personas::where('user_id', $user->id)->first();
                if ($persona) {
                    $credenciales = $request->validate([
                        'email' => ['required', 'email'],
                        'password' => ['required']
                    ]);
                    if (Auth::attempt($credenciales)) {
                        $request->session()->regenerate();
                        $subscription = suscripcions::where('user_id', $user->id)->where('estado', 'INACTIVO')->first();
                        if ($subscription && $persona->plan == "CANCELADO") {
                            return response()->json('licencia');
                        } else {
                            return response()->json(true);
                        }
                    } else {
                        return response()->json(false);
                    }
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->getMessage());
        }
    }
    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/");
    }
    public function cuenta()
    {
        $user = Auth::user();
        $persona = personas::where('user_id', $user->id)->first();
        $empresa = empresas::where('user_id', $user->id)->first();
        $subscription = suscripcions::where('user_id', $user->id)->where(function ($query) {
            $query->where('estado', 'ESPERANDO')
                ->orWhere('estado', 'INACTIVO');
        })->first();
        $estado = "CANCELADO";
        if ($subscription) {
            $estado = $subscription->estado;
        }
        return view('layouts/cuenta', ['user' => $user, 'persona' => $persona, 'empresa' => $empresa, "estado" => $estado]);
    }
    public function modificar_cuenta(Request $request)
    {

        $user = Auth::user();
        $persona = personas::where('user_id', $user->id)->first();
        $empresa = empresas::where('user_id', $user->id)->first();
        if ($empresa == null) {
            return redirect()->route('micuenta')->with(['error' => 'Ingresa primero los datos de tu empresa desde el panel de Personalizar de la parte derecha']);
        } else {
            if (File::exists(public_path($empresa->logo))) {
                File::delete(public_path($empresa->logo));
            }
            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                $nombre_imagen = time() . $request->file('foto')->getClientOriginalName();
                $request->file('foto')->move(public_path('imagenes/personas/'), $nombre_imagen);
                $empresa->logo = $nombre_imagen;
                $empresa->save();
                $persona->telefono = $request->input('telefono');
                $persona->save();
                return redirect()->route('micuenta')->with(['mensaje' => 'Tu Operación Fue Exitosa']);
            } else {
                return redirect()->route('micuenta')->with(['mensaje' => 'Error La Imagen esta dañada o es un archivo invalido']);
            }
        }
    }


    public function empresa(Request $request)
    {
        $user = Auth::user();
        $empresa = empresas::where('user_id', $user->id)->first();
        if ($empresa) {
            $empresa->ruc = $request->input("ruc");
            $empresa->nombre = $request->input("nombre");
            $empresa->direccion = $request->input("direccion");
            $empresa->telefono = $request->input('telefono');
            $empresa->igv = $request->input("igv");
            $empresa->dinerocaja = $request->input("dinerocaja");
            $empresa->save();
            return response()->json("Datos de tu Empresa Modificados Correctamente");
        } else {
            empresas::create([
                'ruc' => $request->input("ruc"),
                'nombre' => $request->input("nombre"),
                'direccion' => $request->input("direccion"),
                'telefono' => $request->input('telefono'),
                'igv' => $request->input("igv"),
                'dinerocaja' => $request->input("dinerocaja"),
                'user_id' => $user->id
            ]);
            return response()->json("Datos de tu Empresa Registrados Correctamente");
        }
    }
    public function verempresa(Request $request)
    {
        $user = Auth::user();
        $empresa = empresas::where('user_id', $user->id)->first();
        if ($empresa) {
            return response()->json($empresa);
        } else {
            return response()->json(500);
        }
    }
}
