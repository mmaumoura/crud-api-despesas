<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    public function registrar(Request $request){
        $validarDados = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        $usuario = User::create([
            'name' => $validarDados['name'],
            'email' => $validarDados['email'],
            'password' => Hash::make($validarDados['password']),
        ]);
        $token = $usuario->createToken('registrar_token')->plainTextToken;
        return response()->json(['access_token' => $token]);
    }

    public function login(Request $request){
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['mensagem' => 'Usuário inválido',], 401,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        $usuario = User::where('email', $request['email'])->firstOrFail();
        $token = $usuario->createToken('login_token')->plainTextToken;
        return response()->json(['access_token' => $token]);
    }
}
