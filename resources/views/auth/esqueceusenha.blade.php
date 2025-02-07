@extends('auth.layouts')

@section('content')
<main class="form-signin w-100 m-auto">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="d-flex justify-content-center"><img class="mb-4" src="{{asset('img/logo-evento.png')}}" alt="" height="120"></div>
        <h1 class="h3 mb-3 fw-normal"><b>Recuperação de Senha</b></h1>
        <p class="text-muted">Informe seu e-mail cadastrado para receber um link de redefinição de senha.</p>

        <div class="form-floating">
            <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="name@example.com" required>
            <label for="floatingEmail">E-mail</label>
        </div>

        <button class="btn cta-btn w-100 py-2 mt-3" type="submit">Enviar Link de Recuperação</button>
        <p class="mt-3 mb-3 text-body-secondary">Lembrou a senha? <a href="{{ route('login') }}">Faça login</a></p>
    </form>
</main>
@endsection

@section('styles')
<style>
    html, body {
        height: 100%;
    }

    .form-signin {
        max-width: 330px;
        padding: 1rem;
    }
</style>
@endsection
