<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Request::is('/') || Request::is('/login') ? 'Login' : '' }} | {{ config('app.name', 'Carnaval 2025') }}</title>
    <link rel="icon" href="{{asset('img/logo-evento.png')}}" type="image/x-icon" />

    <!-- Estilos do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">

    <meta name="theme-color" content="#712cf9">

    <!-- Estilos customizados -->
    @yield('styles')

</head>

<body class="d-flex align-items-center py-4 bg-color-body">

    <!-- Conteúdo principal -->
    <div class="container mt-5">
        @yield('content')
    </div>

    <!-- Scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts customizados -->
    @yield('scripts')

</body>

</html>
