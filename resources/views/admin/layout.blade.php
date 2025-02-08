@php
$user = auth()->user(); // Obtém o usuário logado

// Divide o nome completo em partes
$names = explode(' ', $user->name);
$firstInitial = strtoupper(substr($names[0], 0, 1)); // Primeira letra do primeiro nome
$secondInitial = isset($names[1]) ? strtoupper(substr($names[1], 0, 1)) : ''; // Primeira letra do segundo nome
@endphp
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Carnaval 2025 - Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{asset('img/favicon.ico')}}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400&display=swap" rel="stylesheet">
    <!-- Font Awesome 5 (Solid, Regular, Brands) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Simple Line Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{asset('css/admin/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/admin/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/admin/kaiadmin.min.css')}}" />

    <link rel="stylesheet" href="{{asset('css/admin/demo.css')}}" />

</head>

<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
                <a href="{{route('admin.index')}}" class="logo">
                    <img src="{{asset('img/logotipo-prefeitura-branco.png')}}" alt="navbar brand" class="navbar-brand" height="50" />
                </a>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="gg-menu-right"></i>
                    </button>
                    <button class="btn btn-toggle sidenav-toggler">
                        <i class="gg-menu-left"></i>
                    </button>
                </div>
                <button class="topbar-toggler more">
                    <i class="gg-more-vertical-alt"></i>
                </button>
            </div>
            <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <ul class="nav nav-secondary">
                    <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
                        <a href="{{ route('admin.index') }}" class="nav-link {{ Request::is('admin') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            <p>Painel de Controle</p>
                        </a>
                    </li>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Funcionalidades</h4>
                    </li>
                    <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#base" aria-expanded="{{ Request::is('admin/users*') ? 'true' : 'false' }}">
                            <i class="fas fa-users"></i>
                            <p>Gerenciar Usuários</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ Request::is('admin/users*') ? 'show' : '' }}" id="base">
                            <ul class="nav nav-collapse">
                                <li class="{{ Request::is('admin/users/visualizar*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.listaUsers') }}">
                                        <span class="sub-item">Listar Usuários</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('admin/users/cadastrar*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.cadastrarUser') }}">
                                        <span class="sub-item">Cadastrar Usuário</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('admin/users/logs*') ? 'active' : '' }}">
                                    <a href="#">
                                        <span class="sub-item">Logs de Atividade de Usuários</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarLayouts">
                            <i class="fas fa-file-alt"></i>
                            <p>Gerenciar Legislações</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayouts">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{route('admin.listLaws')}}">
                                        <span class="sub-item">Listar Legislações</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('admin.cadastrarLegislacao')}}">
                                        <span class="sub-item">Cadastrar Legislação</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#forms">
                            <i class="fas fa-chart-line"></i>
                            <p>Relatórios e Análises</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="forms">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="#">
                                        <span class="sub-item">Relatórios Personalizáveis</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="sub-item">Exportação de Dados</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="sub-item">Análises Gráficas</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#tables">
                            <i class="fas fa-cog"></i>
                            <p>Configurações</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="tables">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="#">
                                        <span class="sub-item">Configurações Gerais</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="sub-item">Gerenciamento de Permissões</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#seguranca">
                            <i class="fas fa-shield-alt"></i>
                            <p>Segurança</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="seguranca">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="#">
                                        <span class="sub-item">Logs de Acesso e Atividades</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="sub-item">Autenticação em Dois Fatores</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="sub-item">Gerenciamento de Sessões</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#">
                            <i class="fas fa-sign-out-alt"></i>
                            <p>Sair</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">
        <div class="main-header">
            <div class="main-header-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="{{route('admin.index')}}" class="logo">
                        <img src="{{asset('img/logo-prefeitura2.png')}}" alt="navbar brand" class="navbar-brand" height="50" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                <div class="container-fluid">
                    <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                    </nav>
                    <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                        <li class="nav-item topbar-icon dropdown hidden-caret">
                            <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell"></i>
                                <span class="notification">4</span>
                            </a>
                            <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                                <li>
                                    <div class="dropdown-title">
                                        Você tem 4 novas notificações
                                    </div>
                                </li>
                                <li>
                                    <div class="notif-scroll scrollbar-outer">
                                        <div class="notif-center">
                                            <a href="#">
                                                <div class="notif-icon notif-primary">
                                                    <i class="fa fa-user-plus"></i>
                                                </div>
                                                <div class="notif-content">
                                                    <span class="block"> New user registered </span>
                                                    <span class="time">5 minutes ago</span>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="notif-icon notif-success">
                                                    <i class="fa fa-comment"></i>
                                                </div>
                                                <div class="notif-content">
                                                    <span class="block">
                                                        Rahmad commented on Admin
                                                    </span>
                                                    <span class="time">12 minutes ago</span>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="notif-img">
                                                    <img
                                                        src="assets/img/profile2.jpg"
                                                        alt="Img Profile" />
                                                </div>
                                                <div class="notif-content">
                                                    <span class="block">
                                                        Reza send messages to you
                                                    </span>
                                                    <span class="time">12 minutes ago</span>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="notif-icon notif-danger">
                                                    <i class="fa fa-heart"></i>
                                                </div>
                                                <div class="notif-content">
                                                    <span class="block"> Farrah liked Admin </span>
                                                    <span class="time">17 minutes ago</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a class="see-all" href="javascript:void(0);">Ver todas as notificações<i class="fa fa-angle-right"></i></a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item topbar-user dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown"
                                href="#" aria-expanded="false">
                                <div class="avatar-sm">
                                    @if ($user->photo)
                                    <img src="{{asset('img/user/')}}" alt="..." class="avatar-img rounded-circle" />
                                    @else
                                    <span class="avatar-title rounded-circle border border-white bg-secondary">
                                        <?php echo $firstInitial . $secondInitial; ?>
                                    </span>
                                    @endif

                                </div>
                                <span class="profile-username">
                                    <span class="op-7">Oi,</span>
                                    <span class="fw-bold">{{ $user->name }}</span>
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg">
                                                @if ($user->photo)
                                                <img src="{{asset('img/user/')}}" alt="image profile" class="avatar-img rounded" />
                                                @else
                                                <span class="avatar-title rounded-circle border border-white bg-secondary">
                                                    <?php echo $firstInitial . $secondInitial; ?>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="u-text">
                                                <h4>{{ $user->name }}</h4>
                                                <p class="text-muted">{{ $user->email }}</p>
                                                <a
                                                    href="profile.html"
                                                    class="btn btn-xs btn-secondary btn-sm">Ver perfil</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Meu perfil</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Configuração de conta</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{route('logout')}}">Sair</a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>

        <!-- Main Content -->
        <div class="container">
            @yield('content')
        </div>

        <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
                <nav class="pull-left">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Prefeitura Municipal de Lajes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"> Ajuda </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"> Licenças </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright">
                    &copy; {{date('Y')}}, desenvolvido por <a href="#">Pedro Henrique da Silva</a>
                </div>
                <div>
                    Distribuído por
                    <a target="_blank" href="#">Silva Soluções Tech</a>.
                </div>
            </div>
        </footer>
    </div>

    <!-- Custom template | don't include it in your project! -->
    <div class="custom-template">
        <div class="title">Configuração de cores</div>
        <div class="custom-content">
            <div class="switcher">
                <div class="switch-block">
                    <h4>Cabeçalho do logotipo</h4>
                    <div class="btnSwitch">
                        <button
                            type="button"
                            class="selected changeLogoHeaderColor"
                            data-color="dark"></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="blue"></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="purple"></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="light-blue"></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="green"></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="orange"></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="red"></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="white"></button>
                        <br />
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="dark2"></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="blue2"></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="purple2"></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="light-blue2"></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="green2"></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="orange2"></button>
                        <button
                            type="button"
                            class="changeLogoHeaderColor"
                            data-color="red2"></button>
                    </div>
                </div>
                <div class="switch-block">
                    <h4>Cabeçalho da barra de navegação</h4>
                    <div class="btnSwitch">
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="dark"></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="blue"></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="purple"></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="light-blue"></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="green"></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="orange"></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="red"></button>
                        <button
                            type="button"
                            class="selected changeTopBarColor"
                            data-color="white"></button>
                        <br />
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="dark2"></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="blue2"></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="purple2"></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="light-blue2"></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="green2"></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="orange2"></button>
                        <button
                            type="button"
                            class="changeTopBarColor"
                            data-color="red2"></button>
                    </div>
                </div>
                <div class="switch-block">
                    <h4>Barra lateral</h4>
                    <div class="btnSwitch">
                        <button
                            type="button"
                            class="changeSideBarColor"
                            data-color="white"></button>
                        <button
                            type="button"
                            class="selected changeSideBarColor"
                            data-color="dark"></button>
                        <button
                            type="button"
                            class="changeSideBarColor"
                            data-color="dark2"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="custom-toggle">
            <i class="icon-settings"></i>
        </div>
    </div>

    <!--   Core JS Files   -->
    <script src="{{asset('js/admin/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/admin/popper.min.js')}}"></script>
    <script src="{{asset('js/admin/bootstrap.min.js')}}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{asset('js/admin/jquery.scrollbar.min.js')}}"></script>

    <!-- Chart JS -->
    <script src="{{asset('js/admin/chart.min.js')}}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{asset('js/admin/jquery.sparkline.min.js')}}"></script>

    <!-- Chart Circle -->
    <script src="{{asset('js/admin/circles.min.js')}}"></script>

    <!-- Datatables -->
    <script src="{{asset('js/admin/datatables.min.js')}}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{asset('js/admin/bootstrap-notify.min.js')}}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{asset('js/admin/jsvectormap.min.js')}}"></script>
    <script src="{{asset('js/admin/world.js')}}"></script>

    <!-- Sweet Alert -->
    <script src="{{asset('js/admin/sweetalert.min.js')}}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{asset('js/admin/kaiadmin.min.js')}}"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="{{asset('js/admin/setting-demo.js')}}"></script>
    <script src="{{asset('js/admin/demo.js')}}"></script>
    <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });

        var myDoughnutChart = new Chart(doughnutChart, {
            type: "doughnut",
            data: {
                datasets: [{
                    data: [10, 20, 30],
                    backgroundColor: ["#28a745", "#dc3545", "#ffc107"],
                }, ],
                labels: ["leis vigentes", "revogadas", "em tramitação"],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: "bottom",
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20,
                    },
                },
            },
        });

        // Seleciona o canvas do gráfico
        var categoriasChart = document.getElementById("categoriasChart").getContext("2d");

        // Cria o gráfico Doughnut
        var myCategoriasChart = new Chart(categoriasChart, {
            type: "doughnut",
            data: {
                datasets: [{
                    data: [10, 20, 30],
                    backgroundColor: ["#28a745", "#dc3545", "#ffc107"],
                }, ],
                labels: ["leis vigentes", "revogadas", "em tramitação"],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: "bottom",
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20,
                    },
                },
            },
        });
    </script>

    @yield('scripts')
    </body>

</html>
