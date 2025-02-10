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
                    <a href="#">Cadastrar Entrega</a>
                </li>
            </ul>
        </div>
        <!-- Exibir mensagens de sucesso -->
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <!-- Exibir mensagens de erro individuais (flash messages) -->
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {!! session('error') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <!-- Exibir erros de validação -->
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li> {{-- Alterado para <li> para melhor formatação --}}
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
                        <div class="card-title">Formulário de Cadastro de Entrega de Abadá</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('entregas.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Nome Completo -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control" id="nomeCompleto" name="nome_completo" placeholder="Nome Completo" required readonly />
                                            <label for="nomeCompleto">Nome Completo</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- CPF -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" required maxlength="14" oninput="formatarCPF(this);" onblur="buscarNomePeloCPF();" />
                                            <label for="cpf">CPF</label>
                                            <small id="cpfErro" class="text-danger" style="display: none;">CPF inválido! Insira um CPF correto.</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quantidade de Abadás Entregues -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="number" class="form-control" id="quantidade" name="quantidade" value="1" readonly />
                                            <label for="quantidade">Quantidade de Abadás Entregues</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botões de Ação -->
                            <div class="card-action">
                                <button type="submit" class="btn btn-success" id="botaoEnviar" disabled>Registrar Entrega</button>
                                <button type="button" class="btn btn-danger" onclick="window.history.back();">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Erro -->
        <div class="modal fade" id="cpfModal" tabindex="-1" aria-labelledby="cpfModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cpfModalLabel">Atenção</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <p><b>Entrega não autorizada:</b> para o CPF <b id="cpfNumero"></b>.</p>
                        <b>Motivo:</b>
                        <p id="cpfModalMensagem"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<!-- Scripts para formatação e validação do CPF -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let campoCPF = document.getElementById("cpf");
        let campoNome = document.getElementById("nomeCompleto");
        let botaoCadastrar = document.getElementById("botaoEnviar");

        function validarCampos() {
            if (campoCPF.value.length === 14 && campoNome.value.trim() !== "") {
                botaoCadastrar.removeAttribute("disabled"); // Habilita o botão
            } else {
                botaoCadastrar.setAttribute("disabled", "true"); // Mantém desabilitado
            }
        }

        campoCPF.addEventListener("input", function() {
            let cursorPos = campoCPF.selectionStart;
            let cpf = campoCPF.value.replace(/\D/g, "");

            if (cpf.length > 11) {
                cpf = cpf.substring(0, 11);
            }

            let cpfFormatado = "";
            for (let i = 0; i < cpf.length; i++) {
                if (i === 3 || i === 6) {
                    cpfFormatado += ".";
                }
                if (i === 9) {
                    cpfFormatado += "-";
                }
                cpfFormatado += cpf[i];
            }

            let prevLength = campoCPF.value.length;
            campoCPF.value = cpfFormatado;
            let newLength = cpfFormatado.length;
            cursorPos += newLength - prevLength;
            campoCPF.setSelectionRange(cursorPos, cursorPos);

            if (cpf.length === 11) {
                buscarNomePeloCPF(cpf);
            } else {
                campoNome.value = "";
                validarCampos();
            }
        });

        function buscarNomePeloCPF(cpf) {
            fetch(`/buscar-nome/${cpf}`)
                .then(response => response.json())
                .then(data => {
                    if (data.nome) {
                        campoNome.value = data.nome;
                    } else {
                        campoNome.value = "";
                        mostrarModal('CPF informado não é válido.', cpf);
                        botaoCadastrar.disabled = true;
                    }
                    validarCampos();
                })
                .catch(error => {
                    console.error('Erro ao buscar CPF:', error);
                });
        }

        function mostrarModal(mensagem, cpf) {
            document.getElementById('cpfNumero').innerText = cpfFormatado(cpf);
            document.getElementById('cpfModalMensagem').innerText = mensagem;

            let modalElement = document.getElementById('cpfModal');
            let modal = new bootstrap.Modal(modalElement);
            modal.show();
        }

        function cpfFormatado(cpf) {
            return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
        }
    });
</script>

@endsection
