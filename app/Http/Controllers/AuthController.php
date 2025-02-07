<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Mostrar a página de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
    /**
     * Autenticação de usuários
     */
    public function login(Request $request)
    {

    }

    /**
     * Retorna o usuário autenticado
     */
    public function me(Request $request)
    {

    }

    public function showEsqueceuSenha(){
        return view('auth.esqueceusenha');
    }

    /**
     * Logout do usuário
     */
    public function logout(Request $request)
    {

    }
}
