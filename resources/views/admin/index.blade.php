@extends('admin.layout')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Painel de Controle</h3>
                <h6 class="op-7 mb-2">Gerenciador de Entregas</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="{{route('admin.listaEntregas')}}" class="btn btn-label-info btn-round me-2">Gerenciar</a>
                <a href="{{route('admin.cadastrarEntrega')}}" class="btn btn-primary btn-round">Cadastrar Entrega</a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-6">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-people-carry"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Kits Entregues por <b>{{$user->name}}</b></p>
                                    <h4 class="card-title">
                                        {{ $kitsEntregues === 0 ? '0 entrega' : ($kitsEntregues === 1 ? '1 entrega' : "$kitsEntregues entregas") }}
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
                                    <i class="fas fa-box"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total de Kits Entregues</p>
                                    <h4 class="card-title">
                                        {{ $totalKitsEntregues === 0 ? '0 entrega' : ($totalKitsEntregues === 1 ? '1 entrega' : "$totalKitsEntregues entregas") }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12">
                <div id="grafico-entregas" data-entregas="{{ json_encode($entregasPorDia) }}"></div>

                <canvas id="graficoEntregas"></canvas>
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
    document.addEventListener("DOMContentLoaded", function() {
        const elemento = document.getElementById('grafico-entregas');
        const entregas = JSON.parse(elemento.dataset.entregas);

        const labels = entregas.map(e => {
            const [year, month, day] = e.data.split('-'); // Converte de YYYY-MM-DD para DD/MM/YYYY
            return `${day}/${month}/${year}`;
        });

        const data = entregas.map(e => e.total);

        if (labels.length === 0) {
            document.getElementById('graficoEntregas').parentElement.innerHTML = "<p>Sem dados de entrega para exibir.</p>";
            return;
        }

        const ctx = document.getElementById('graficoEntregas').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Entregas por Dia',
                    data: data,
                    backgroundColor: 'rgba(232, 255, 0, 0.6)',
                    borderColor: 'rgba(232, 255, 0, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

@endsection
