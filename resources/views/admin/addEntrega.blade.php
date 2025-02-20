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

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {!! session('error') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
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
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control" id="nomeCompleto" name="nome_completo" placeholder="Nome Completo" required readonly />
                                            <label for="nomeCompleto">Nome Completo</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" required maxlength="14" oninput="formatarCPF(this);" onblur="buscarNomePeloCPF();" />
                                            <label for="cpf">CPF</label>
                                            <small id="cpfErro" class="text-danger" style="display: none;">CPF inválido! Insira um CPF correto.</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-lg-2">
                                    <div class="form-group">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="number" class="form-control" id="quantidade" name="quantidade" value="1" readonly />
                                            <label for="quantidade">Quantidade de Abadás
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <select class="form-control" id="tamanhoAbada" name="tamanho_abada" required>
                                                <option value="">Selecione o Tamanho</option>
                                            </select>
                                            <label for="tamanhoAbada">Tamanho do Abadá</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-action">
                                <button type="submit" class="btn btn-success btn-round" id="botaoEnviar" disabled>Registrar Entrega</button>
                                <button type="button" class="btn btn-danger btn-round" onclick="window.history.back();">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
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
                <p id="cpfModalMensagem"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

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
            let cpf = campoCPF.value.replace(/\D/g, ""); // Remove caracteres não numéricos

            if (cpf.length > 11) {
                cpf = cpf.substring(0, 11);
            }

            let cpfFormatado = formatarCPF(cpf);
            let prevLength = campoCPF.value.length;
            campoCPF.value = cpfFormatado;
            let newLength = cpfFormatado.length;
            cursorPos += newLength - prevLength;
            campoCPF.setSelectionRange(cursorPos, cursorPos);

            if (cpf.length === 11) {
                buscarNomePeloCPF(cpf);
            } else {
                campoNome.value = "";
                campoNome.removeAttribute("readonly"); // Libera para edição caso o CPF seja incompleto
                validarCampos();
            }
        });

        function buscarNomePeloCPF(cpf) {
            fetch(`/buscar-nome/${cpf}`)
                .then(response => response.json())
                .then(data => {
                    if (data.nome) {
                        campoNome.value = data.nome;
                        campoNome.setAttribute("readonly", "true"); // Bloqueia edição se a API encontrar
                    } else {
                        campoNome.value = ""; // Mantém vazio para o usuário preencher manualmente
                        campoNome.removeAttribute("readonly"); // Habilita para edição manual
                        mostrarModal('CPF não encontrado na base de dados. Insira o nome manualmente.', cpf);
                    }
                    validarCampos();
                })
                .catch(error => {
                    console.error('Erro ao buscar CPF:', error);
                    campoNome.removeAttribute("readonly"); // Permite edição manual em caso de erro
                    validarCampos();
                });
        }

        function mostrarModal(mensagem, cpf) {
            document.getElementById('cpfNumero').innerText = formatarCPF(cpf);
            document.getElementById('cpfModalMensagem').innerText = mensagem;

            let modalElement = document.getElementById('cpfModal');
            let modal = new bootstrap.Modal(modalElement);
            modal.show();
        }

        function formatarCPF(cpf) {
            return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
        }

        campoNome.addEventListener("input", validarCampos);
    });
    document.getElementById("nomeCompleto").addEventListener("input", function() {
        this.value = this.value.toUpperCase();
    });

    document.addEventListener("DOMContentLoaded", function() {
        function atualizarTamanhos() {
            fetch('/estoque/tamanhos')
                .then(response => response.json())
                .then(data => {
                    let selectTamanho = document.getElementById("tamanhoAbada");
                    selectTamanho.innerHTML = '<option value="">Selecione o Tamanho</option>'; // Limpa e adiciona o padrão

                    data.forEach(tamanho => {
                        let option = document.createElement("option");
                        option.value = tamanho.tamanho;
                        option.textContent = `${tamanho.tamanho} (${tamanho.quantidade} disponíveis)`;
                        selectTamanho.appendChild(option);
                    });
                })
                .catch(error => console.error("Erro ao buscar tamanhos:", error));
        }

        atualizarTamanhos(); // Chama ao carregar a página
        setInterval(atualizarTamanhos, 5000); // Atualiza a cada 5 segundos
    });
</script>
@endsection
