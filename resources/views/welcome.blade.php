<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Pessoa Física</title>
</head>
<body>

    <h1>Consulta de Pessoa Física - Portal da Transparência</h1>

    <form action="{{ route('portal.buscar') }}" method="POST">
        @csrf
        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" required maxlength="11">

        <button type="submit">Buscar</button>
    </form>

    @if(isset($dadosPessoa) && is_array($dadosPessoa))
        <h2>Resultado:</h2>
        <ul>
            <li><strong>Nome:</strong> {{ $dadosPessoa['nome'] ?? 'Não encontrado' }}</li>
            <li><strong>Data de Nascimento:</strong> {{ $dadosPessoa['dataNascimento'] ?? 'Não disponível' }}</li>
            <li><strong>Órgão:</strong> {{ $dadosPessoa['orgao'] ?? 'Não informado' }}</li>
            <li><strong>Função:</strong> {{ $dadosPessoa['funcao'] ?? 'Não informado' }}</li>
        </ul>
    @endif

</body>
</html>
