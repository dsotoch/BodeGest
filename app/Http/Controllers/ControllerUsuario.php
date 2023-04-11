<?php

namespace App\Http\Controllers;

use App\Mail\CorreoConfirmacion;
use App\Models\confirmacions;
use App\Models\personas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\Catch_;

class ControllerUsuario extends Controller
{
    public function login()
    {
        return view('welcome');
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
                    'password' => bcrypt($request->input('password'))
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
                $url = "http://localhost:8000/Login/validarToken/" . $token;
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
        $token_valido = confirmacions::where('token', $token)->first();
        if ($token_valido) {
            $user = User::where('email', $token_valido->email)->first();
            $user->email_verified_at = Carbon::now();
            $user->save();
            $persona=$user->personas;
            $persona->estado='verificado';
            $persona->save();

            return redirect()->route('login');
        }
    }
    public function IniciarSesion(Request $request)
    {
        try {
            $user = User::where('email', $request->input('email'))->first();
            if ($user->email_verified_at != null) {
                $credenciales = $request->validate([
                    'email' => ['required', 'email'],
                    'password' => ['required']
                ]);
                if (Auth::attempt($credenciales)) {
                    $request->session()->regenerate();
                    return response()->json(true);
                } else {
                    return response()->json(false);
                }
            } else {
                return response()->json('verificado');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->getMessage());
        }
    }
}
