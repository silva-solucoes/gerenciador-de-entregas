@extends('admin.layout')

@section('content')

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Relatório e Análises</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.index') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Relatório Personalizado</a>
                </li>
            </ul>
        </div>
        <!-- Exibir mensagens de sucesso ou erro -->
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="card-title">Gerar Relatório</div>
            </div>
            <div class="card-body">
                <form action="{{route('admin.relatorio.entregas')}}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de Relatório</label>
                                <select class="form-control" name="tipo_relatorio" required>
                                    <option value="completo">Relatório Completo</option>
                                    <option value="por_operador">Por Operador</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6" id="operadorSelect" style="display: none;">
                            <div class="form-group">
                                <label>Selecione o Operador</label>
                                <select class="form-control" name="operador_id">
                                    <option value="">Todos</option>
                                    @foreach($operadores as $operador)
                                    <option value="{{ $operador->id }}">{{ $operador->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-action">
                        <button type="submit" class="btn btn-primary">Gerar Relatório</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
