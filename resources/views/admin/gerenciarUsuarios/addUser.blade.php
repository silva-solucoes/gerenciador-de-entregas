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
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control text-uppercase" id="nomeCompleto" name="name" placeholder="Nome Completo" required />
                                            <label for="nomeCompleto">Nome Completo</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- E-mail -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required />
                                            <label for="email">E-mail</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Função -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <select class="form-control" id="funcao" name="role" required>
                                                <option value="" disabled selected>Selecione a função</option>
                                                <option value="admin">Administrador</option>
                                                <option value="operador">Operador</option>
                                            </select>
                                            <label for="funcao">Função</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="ativo">Ativo</option>
                                                <option value="inativo">Inativo</option>
                                            </select>
                                            <label for="status">Status</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botões de Ação -->
                            <div class="card-action">
                                <button type="submit" class="btn btn-success btn-round">Cadastrar Usuário</button>
                                <button type="button" class="btn btn-danger btn-round" onclick="window.history.back();">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
