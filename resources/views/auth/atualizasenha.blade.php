@extends('auth.layouts')

@section('content')
<main class="form-signin w-100 m-auto">
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="d-flex justify-content-center">
            <img class="mb-4" src="{{ asset('img/logo-evento.png') }}" alt="" height="120">
        </div>

        <h1 class="h3 mb-3 fw-normal text-white"><b>Redefinir Senha</b></h1>
        <p class="text-white">Crie uma nova senha para sua conta.</p>

        <!-- Campo de E-mail (preenchido automaticamente) -->
        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control" id="floatingEmail" value="{{ request()->email }}" readonly required>
            <label for="floatingEmail">E-mail</label>
        </div>

        <!-- Campo de Nova Senha -->
        <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Nova Senha" required>
            <label for="floatingPassword">Nova Senha</label>
        </div>

        <!-- Campo de Confirmação de Senha -->
        <div class="form-floating mb-3">
            <input type="password" name="password_confirmation" class="form-control" id="floatingConfirmPassword" placeholder="Confirme a Senha" required>
            <label for="floatingConfirmPassword">Confirme a Senha</label>
        </div>

        <button class="btn cta-btn w-100 py-2 mt-3" type="submit">Redefinir Senha</button>
        <p class="mt-3 mb-3 text-white">Lembrou a senha? <a href="{{ route('login') }}">Faça login</a></p>

        <div class="d-flex justify-content-center">
            <p class="mt-5 mb-3 text-body-secondary">&copy; {{ date('Y') }} Prefeitura Municipal de Lajes.</p>
        </div>
    </form>
</main>
@endsection

@section('styles')
<style>
    html, body {
        height: 100%;
        background-color: #121212; /* Fundo escuro para contraste */
    }

    .form-signin {
        max-width: 330px;
        padding: 1rem;
        /*background: rgba(255, 255, 255, 0.1);  Fundo semi-transparente */
        border-radius: 10px;
    }

    .form-signin .form-floating:focus-within {
        z-index: 2;
    }

    input:focus, textarea:focus, select:focus {
        outline: 2px solid #BB35E7;
        border-color: #BB35E7;
    }

    .form-signin input[type="email"],
    .form-signin input[type="password"] {
        border-radius: 5px;
    }

    .btn-primary {
        background-color: #712cf9;
        border-color: #712cf9;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #5a23c8;
        border-color: #5a23c8;
    }

    .text-white {
        color: #fff;
    }

    a.text-white {
        text-decoration: none;
    }

    a.text-white:hover {
        text-decoration: underline;
    }
</style>
@endsection
