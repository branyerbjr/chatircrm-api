<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'dni' => 'required|digits:8|unique:users',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'nombreUsuario' => 'required|string|unique:users',
            'rol' => 'required|string|in:Usuario,Administrador',
            'perteneceA' => 'required|exists:departamentos,_id',
            'celular' => 'string|nullable|unique:users,celular,'
        ]);

        $user = User::create([
            'dni' => $request->dni,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nombreUsuario' => $request->nombreUsuario,
            'rol' => $request->rol,
            'perteneceA' => $request->perteneceA,
            'celular' => $request->celular,
        ]);

        return response()->json(['user' => $user], 201);
    }

    /**
     * Log the user in.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = Auth::user();
        $token = Str::random(60); // Genera un token aleatorio, puedes ajustar esto según tus necesidades

        $user->update(['api_token' => $token]); // Almacena el token en el usuario

        return response()->json(['token' => $token, 'user' => $user], 200);
    } else {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}

    /**
     * Get the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        $user = Auth::user();
        return response()->json(['user' => $user], 200);
    }

    /**
     * Log the user out.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Sanctum::logout(Auth::user());

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
    
    public function checkAuth()
    {
        return response()->json(['authenticated' => true]);
    }
}
