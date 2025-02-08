@extends('admin.layout')

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
                <a href="#" class="btn btn-primary btn-round">Cadastrar Usuário</a>
            </div>
        </div>
        <div class="row">

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
                url: "#",
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
