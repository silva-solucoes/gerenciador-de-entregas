@extends('auth.layouts')

@section('content')
<main class="form-signin w-100 m-auto">
    <form id="loginForm" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="d-flex justify-content-center"><img class="mb-4" src="{{asset('img/logo-evento.png')}}" alt="" height="120"></div>
        <h1 class="h3 mb-3 fw-normal text-white"><b>Login</b></h1>
        <p class="text-white">Faça login e insira seus dados de acesso no campo abaixo.</p>

        <div class="form-floating">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
            <label for="floatingInput">E-mail</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
            <label for="floatingPassword">Senha</label>
        </div>

        <div class="form-check text-start my-3">
            <input class="form-check-input" name="remember" type="checkbox" value="remember-me" id="flexCheckDefault">
            <label class="form-check-label text-white" for="flexCheckDefault">
                Lembre de mim
            </label>
        </div>
        <button class="btn cta-btn w-100 py-2" type="submit">Entrar</button>
        <div class="text-center mt-3">
            <a href="{{ route('esqueceuSenha.show') }}">Esqueci minha senha</a>
        </div>
        <div class="d-flex justify-content-center">
            <p class="mt-5 mb-3 text-body-secondary">&copy; {{ date('Y') }} Prefeitura Municipal de Lajes.</p>
        </div>
    </form>
</main>
@endsection

@section('styles')
<style>
    html,
    body {
        height: 100%;
    }

    .form-signin {
        max-width: 330px;
        padding: 1rem;
    }

    .form-signin .form-floating:focus-within {
        z-index: 2;
    }

    input:focus,
    textarea:focus,
    select:focus {
        outline: 2px solid #BB35E7;
        /* Define a cor da borda ao focar */
        border-color: #BB35E7;
        /* Muda a cor da borda padrão */
    }

    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }

    .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
    }

    .bi {
        vertical-align: -.125em;
        fill: currentColor;
    }

    .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
    }

    .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
        z-index: 1500;
    }

    .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
    }
</style>
@endsection
