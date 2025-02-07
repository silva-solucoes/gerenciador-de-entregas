@extends('admin.layouts')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Painel de Controle</h3>
                <h6 class="op-7 mb-2">Leis Municipais de Lajes</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-label-info btn-round me-2">Gerenciar</a>
                <a href="{{route('admin.cadastrarUser')}}" class="btn btn-primary btn-round">Cadastrar Usuário</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Legislações</p>
                                    <h4 class="card-title">
                                        {{ $cont->count() === 0 ? 'Não há registros' : ($cont->count() === 1 ? '1 norma' : $cont->count() . ' normas') }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center esp-user bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Usuários</p>
                                    <h4 class="card-title">
                                        {{ $userCount->count() === 0 ? 'Não há registros' : ($userCount->count() === 1 ? '1 usuário' : $userCount->count() . ' usuários') }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Legislação Municipal</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                </div>
                            </div>
                            <canvas id="doughnutChart" style="width: 367px; height: 300px; display: block;" width="458" height="375" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Categorias/Tópicos de Legislação</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                </div>
                            </div>
                            <canvas id="categoriasChart" style="width: 367px; height: 300px; display: block;" width="458" height="375" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-round">
                    <div class="card-body">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">Novos Usuários</div>
                            <div class="card-tools">
                                <div class="dropdown">
                                    <button class="btn btn-icon btn-clean me-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Ação</a>
                                        <a class="dropdown-item" href="#">Outra ação</a>
                                        <a class="dropdown-item" href="#">Algo mais aqui</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-list py-4">
                            @foreach ($userCount as $user)
                            <div class="item-list">
                                <div class="avatar">
                                    @if ($user->photo)
                                    <img src="{{asset('storage/' . $user->photo)}}" alt="..." class="avatar-img rounded-circle" />
                                    @else
                                    @php
                                    // Divide o nome completo em partes
                                    $names = explode(' ', $user->name);
                                    $firstInitial = strtoupper(substr($names[0], 0, 1)); // Primeira letra do primeiro nome
                                    $secondInitial = isset($names[1]) ? strtoupper(substr($names[1], 0, 1)) : ''; // Primeira letra do segundo nome
                                    @endphp
                                    <span class="avatar-title rounded-circle border border-white bg-secondary">
                                        <?php echo $firstInitial . $secondInitial; ?>
                                    </span>
                                    @endif
                                </div>
                                <div class="info-user ms-3">
                                    <div class="username">{{ $user->name }}</div>
                                    <div class="status">{{ $user->role }}</div>
                                </div>
                                <button class="btn btn-icon btn-link btn-danger op-8">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Estatísticas Recentes das Legislações Municipais</div>
                            <div class="card-tools">
                                <a href="#" class="btn btn-label-success btn-round btn-sm me-2">
                                    <span class="btn-label">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                    Exportar
                                </a>
                                <a href="#" class="btn btn-label-info btn-round btn-sm">
                                    <span class="btn-label">
                                        <i class="fa fa-print"></i>
                                    </span>
                                    Imprimir
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="min-height: 375px">
                            <canvas id="statisticsChart"></canvas>
                        </div>
                        <div id="myChartLegend"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
    }

    .sidebar {
        height: 100vh;
    }

    .nav-link {
        font-size: 1.1rem;
    }

    .badge {
        font-size: 0.9rem;
    }

    #recent-logs ul {
        list-style-type: none;
        padding: 0;
    }

    #recent-logs li {
        padding: 5px 0;
        border-bottom: 1px solid #ddd;
    }
</style>

@section('scripts')
<script>
    $(document).ready(function() {
        // Função para buscar os logs mais recentes
        function fetchRecentLogs() {
            $.ajax({
                url: "{{ route('logs.recent') }}",
                method: 'GET',
                success: function(response) {
                    // Limpa a lista de logs existentes
                    var logsContainer = $('#log-list');
                    logsContainer.empty();

                    // Exibe os logs mais recentes
                    response.forEach(function(log) {
                        var logItem = '<li>' + new Date(log.created_at).toLocaleString() + ' - ' + log.user.name + ': ' + log.details + '</li>';
                        logsContainer.append(logItem);
                    });
                }
            });
        }

        // Chama a função fetchRecentLogs para buscar os logs
        fetchRecentLogs();

        // Atualiza os logs a cada 10 segundos
        setInterval(fetchRecentLogs, 10000);
    });
</script>

@endsection
