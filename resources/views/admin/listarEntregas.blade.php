@extends('admin.layout')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Gerenciar Entregas</h3>
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
                    <a href="#">Listar Entregas</a>
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Lista de Entregas</h4>
                        <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addRowModal">
                            <i class="fa fa-plus"></i>
                            Cadastrar Entrega
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="add-row_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="dataTables_length" id="add-row_length">
                                        <label>Mostrar
                                            <select name="add-row_length" aria-controls="add-row" class="form-control form-control-sm">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select> registros
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div id="add-row_filter" class="dataTables_filter">
                                        <label>Procurar:
                                            <input type="search" class="form-control form-control-sm" placeholder="Pesquisar" aria-controls="add-row">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="add-row" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="add-row_info">
                                        <thead>
                                            <tr role="row">
                                                <th>#</th>
                                                <th>Folião</th>
                                                <th>CPF</th> <!-- Nova Coluna -->
                                                <th>Entregador</th>
                                                <th>Data da Entrega</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($entregas as $entrega)
                                            <tr>
                                                <td>{{ $entrega->id }}</td>
                                                <td>{{ $entrega->foliao }}</td>
                                                <td>{{ preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", $entrega->cpf) }}</td> <!-- Formatação CPF -->
                                                <td>{{ $entrega->entregador }}</td>
                                                <td>{{ \Carbon\Carbon::parse($entrega->data_entrega)->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <button type="button" data-bs-toggle="tooltip" title="Editar" class="btn btn-link btn-primary btn-lg">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button type="button" data-bs-toggle="tooltip" title="Remover" class="btn btn-link btn-danger">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="add-row_info" role="status" aria-live="polite">
                                        Mostrando {{ $entregas->firstItem() }} a {{ $entregas->lastItem() }} de {{ $entregas->total() }} registros
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_simple_numbers">
                                        {{ $entregas->links() }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImagem() {
        const input = document.getElementById('fotoPerfil');
        const preview = document.getElementById('previewFoto');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
</script>

@endsection
