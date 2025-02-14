<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Entregas de Abadás</title>
    <link rel="icon" href="{{asset('img/logo-evento.png')}}" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            max-width: 220px;
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

        .text-start {
            text-align: left;
        }

        @page {
            margin-left: 1.5cm;
            margin-right: 1.5cm;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            right: 10px;
            font-size: 12px;
            content: "Página " counter(page) " de " counter(pages);
        }

        .uppercase {
            text-transform: uppercase;
        }
    </style>
</head>

<body>

    <!-- Cabeçalho -->
    <div class="header">
        <img src="{{ public_path('img/logo-evento.png') }}" alt="Logo" class="logo">
        <h3 class="uppercase"><strong>Prefeitura Municipal de Lajes</strong><br>Secretaria Municipal de Comunicação - SECOM<br><strong>Carnaval de Todos 2025</strong></h3>
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
                <td class="text-start">{{ mb_strtoupper($entrega->foliao, 'UTF-8') }}</td>
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
        $pdf->page_text(500, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
    }
</script>

</body>

</html>
