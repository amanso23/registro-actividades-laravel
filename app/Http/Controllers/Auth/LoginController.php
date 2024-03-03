<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


class LoginController extends Controller{

    public function authAdmin(Request $request) {
        // Validar las credenciales del usuario
        $credentials = $request->only('email', 'password');
       
      

        if (Auth::attempt($credentials)) {
            // Las credenciales son válidas, obtener el usuario
            $user = Auth::user();
            // Generar el token de acceso con información adicional (rol del usuario)
            $token = $user->createToken('Token de acceso')->plainTextToken;
    
            return response()->json(['token' => $token], 200);
        }
    
        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }
    

    
}
