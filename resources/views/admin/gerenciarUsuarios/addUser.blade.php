@extends('admin.layout')

@section('content')

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Formulário de Cadastro</h3>
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
                    <a href="#">Formulário de Cadastro</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Usuários</a>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Formulário de Cadastro de Usuário</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.novoUser') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Nome Completo -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" placeholder="Nome Completo" required />
                                    </div>
                                </div>

                                <!-- E-mail -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" placeholder="E-mail" required />
                                    </div>
                                </div>

                                <input type="hidden" name="password" value="Carnaval@2025" />

                                <!-- Função -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <select class="form-select" name="role" required>
                                            <option value="operador" selected>Operador</option>
                                            <option value="administrador">Administrador</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <select class="form-select" name="status" required>
                                            <option value="inativo" selected>Inativo</option>
                                            <option value="ativo">Ativo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Botões de Ação -->
                            <div class="card-action">
                                <button type="submit" class="btn btn-success">Cadastrar Usuário</button>
                                <button type="button" class="btn btn-danger" onclick="window.history.back();">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
