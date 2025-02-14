@extends('admin.layout')

@section('content')

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Formulário de Edição</h3>
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
                    <a href="#">Formulário de Edição</a>
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
                        <div class="card-title">Formulário de Edição de Usuário</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.updateUser', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <!-- Nome Completo -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required />
                                    </div>
                                </div>

                                <!-- E-mail -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required />
                                    </div>
                                </div>

                                <!-- Senha -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" value="{{ $user->password }}" placeholder="Digite uma nova senha" required />
                                    </div>
                                </div>

                                <!-- Função -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <select class="form-select" name="role" required>
                                            <option value="operador" {{ $user->role == 'operador' ? 'selected' : '' }}>Operador</option>
                                            <option value="administrador" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <select class="form-select" name="status" required>
                                            <option value="inativo" {{ $user->status == 'inativo' ? 'selected' : '' }}>Inativo</option>
                                            <option value="ativo" {{ $user->status == 'ativo' ? 'selected' : '' }}>Ativo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Botões de Ação -->
                            <div class="card-action">
                                <button type="submit" class="btn btn-success btn-round">Atualizar Usuário</button>
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
