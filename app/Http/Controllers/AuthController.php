<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

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
            if ($user->role === 'admin' || $user->role === 'operador') {
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

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Este e-mail não está cadastrado em nosso sistema.',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Um link de recuperação foi enviado para seu e-mail.')
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm($token)
    {
        return view('auth.atualizasenha', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        // Valida os dados do formulário
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Tenta redefinir a senha do usuário
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Atualiza a senha do usuário
                $user->password = Hash::make($password);
                $user->save();

                // Autentica o usuário após a redefinição
                Auth::login($user);
            }
        );

        // Redireciona com mensagem baseada no status
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Logout do usuário
     */
    public function logout(Request $request) {
        // Realizar o logout do usuário
        Auth::logout();

        // Redirecionar para a página de login após o logout
        return redirect()->route('login');
    }
}
