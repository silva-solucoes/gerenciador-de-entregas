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
        // Validar dados do formulário de login
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Captura a opção "Lembrar-me", se presente
        $remember = $request->has('remember');

        // Tentar autenticar o usuário
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $remember)) {
            // Registrar o log de login
            $user = Auth::user();

            // Verificar se o usuário está ativo
            if ($user->status !== 'ativo') {
                // Registrar log de tentativa de acesso por usuário inativo
                //LogController::storeLog(Auth::id(), 'inactive_user', "Usuário {$user->name} tentou fazer login, mas está inativo.", $request->ip());

                Auth::logout(); // Desloga o usuário automaticamente
                return back()->withErrors(['email' => 'Sua conta está inativa. Entre em contato com o administrador.']);
            }

            // Verificar a role do usuário
            if ($user->role === 'admin') {
                // Registrar log de login com sucesso
                //LogController::storeLog(Auth::id(), 'login', "Usuário {$user->name} realizou login com sucesso.", $request->ip());

                return redirect()->route('admin.index')->with('success', 'Bem-vindo ao painel de administração!');
            }
        } else {
            // Registrar log de falha no login
            //LogController::storeLog(null, 'failed_login', "Tentativa de login falhou para o e-mail {$validated['email']}.", $request->ip());

            return back()->withErrors(['email' => 'Credenciais inválidas.']);
        }
    }

    /**
     * Retorna o usuário autenticado
     */
    public function me(Request $request) {}

    public function showEsqueceuSenha()
    {
        return view('auth.esqueceusenha');
    }

    /**
     * Logout do usuário
     */
    public function logout(Request $request) {}
}
