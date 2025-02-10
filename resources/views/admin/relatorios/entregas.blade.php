<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Entregas de Abadás</title>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Archivo', sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 120px;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .info {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            right: 10px;
            font-size: 12px;
        }

        @page {
            margin: 20px;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            right: 10px;
            font-size: 12px;
            content: "Página " counter(page) " de " counter(pages);
        }
    </style>
</head>

<body>

    <!-- Cabeçalho -->
    <div class="header">
        <img src="{{ public_path('img/logo-evento.png') }}" alt="Logo">
        <p><strong>Prefeitura Municipal de Lajes</strong></p>
        <p>Secretaria Municipal de Comunicação - SECOM</p>
        <p><strong>Carnaval de Todos 2025</strong></p>
    </div>

    <!-- Título -->
    <div class="title">
        RELATÓRIO DE ENTREGAS DE ABADÁS DO CARNAVAL 2025
    </div>

    <!-- Frase informativa -->
    <div class="info">
        Total de Entregas Realizadas: <strong>{{ $totalEntregas }}</strong>
    </div>

    <!-- Tabela de Entregas -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Folião</th>
                <th>CPF</th>
                <th>Qtd. Kits</th>
                <th>Operador</th>
                <th>Data/Hora</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entregas as $index => $entrega)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ strtoupper($entrega->foliao) }}</td>
                <td>{{ $entrega->cpf }}</td>
                <td>{{ $entrega->quantidade_kit }}</td>
                <td>{{ $entrega->operador }}</td>
                <td>{{ \Carbon\Carbon::parse($entrega->data_entrega)->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Rodapé -->
    <script type="text/php">
        if (isset($pdf)) {
        $pdf->page_text(500, 820, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
    }
</script>

</body>

</html>
