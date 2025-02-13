@extends('auth.layouts')

@section('content')
<main class="form-signin w-100 m-auto">
    <form id="loginForm" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="d-flex justify-content-center">
            <img class="mb-4" src="{{ asset('img/logo-evento.png') }}" alt="Logo do Evento" height="120">
        </div>

        <h1 class="h3 mb-3 fw-normal text-white"><b>Login</b></h1>
        <p class="text-white">Faça login e insira seus dados de acesso no campo abaixo.</p>

        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Campo de e-mail -->
        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" required>
            <label for="floatingInput">E-mail</label>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Campo de senha -->
        <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" placeholder="Password" required>
            <label for="floatingPassword">Senha</label>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Checkbox "Lembre de mim" -->
        <div class="form-check text-start my-3">
            <input class="form-check-input" name="remember" type="checkbox" value="remember-me" id="flexCheckDefault">
            <label class="form-check-label text-white" for="flexCheckDefault">
                Lembre de mim
            </label>
        </div>

        <!-- Botão de login -->
        <button class="btn cta-btn w-100 py-2 mt-3" type="submit">Entrar</button>

        <!-- Link "Esqueci minha senha" -->
        <div class="text-center mt-3">
            <a class="text-white" href="{{ route('esqueceuSenha.show') }}">Esqueci minha senha</a>
        </div>

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
