<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class AuthController extends Controller
{

 public function showRegistrationForm()
    {
        return view('auth.register');
    }


    public function register(Request $request)
    {
        $validated = $request->validate([
    'name'     => 'required|string|max:255',
    'email'    => 'required|string|email|unique:users',
    'password' => [
        'required',
        'string',
        'min:8',
        'confirmed',
        'regex:/[a-z]/',
        'regex:/[A-Z]/',
        'regex:/[0-9]/',
        'regex:/[@$!%*#?&]/',
    ],
], [
    'email.unique'     => 'Email já cadastrado. Utilize outro email ou faça login por gentileza.',
    'email.email'      => 'Por favor, insira um e-mail válido.',
    'password.required'=> 'A senha é obrigatória.',
    'password.min'      => 'A senha deve ter no mínimo 8 caracteres.',
    'password.confirmed'=> 'As senhas não coincidem.',
    'password.regex'    => 'A senha deve conter pelo menos: 1 letra maiúscula, 1 minúscula, 1 número e 1 caractere especial.',
]);


        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        session(['jwt_token' => $token]);

        return redirect()->route('dashboard')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);

        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
        return back()->withErrors([
            'login_error' => 'E-mail ou senha inválidos. Tente novamente.',
        ])->withInput();
        }

        response()->json([
            'data' => [
                'token_type' => 'bearer',
                'token' => $token,
                'expires_in' => Carbon::now('America/Sao_Paulo')->addHours(2)->toDateTimeString()
            ]
        ]);

        // Armazenar token na sessão 
        session(['jwt_token' => $token]);

        // Redirecionar para a área logada
        return redirect()->route('dashboard')->with('success', 'Cadastro realizado com sucesso!');
        
    }
}
