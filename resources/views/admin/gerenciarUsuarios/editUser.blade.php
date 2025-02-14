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
                        <form method="POST" action="{{ route('admin.updateUser', $user->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                            <label for="name">Nome Completo</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                                            <label for="email">E-mail</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <select class="form-control" id="role" name="role" required>
                                                <option value="operador" {{ $user->role == 'operador' ? 'selected' : '' }}>Operador</option>
                                                <option value="administrador" {{ $user->role == 'administrador' ? 'selected' : '' }}>Administrador</option>
                                            </select>
                                            <label for="role">Função</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="ativo" {{ $user->status == 'ativo' ? 'selected' : '' }}>Ativo</option>
                                                <option value="inativo" {{ $user->status == 'inativo' ? 'selected' : '' }}>Inativo</option>
                                            </select>
                                            <label for="status">Status</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="password" class="form-control" id="password" name="password">
                                            <label for="password">Nova Senha (deixe em branco para manter)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-round">Atualizar Usuário</button>
                            <button type="button" class="btn btn-danger btn-round" onclick="window.history.back();">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
