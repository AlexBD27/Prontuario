<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Centímetros Lineales</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        h1, h2 {
            text-align: center;
            color: #1a202c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #e2e8f0;
        }
        th {
            background-color: #edf2f7;
            text-align: left;
        }
        th, td {
            padding: 10px;
        }
        td {
            font-size: 12px;
        }
        p {
            margin: 10px 0;
        }
        #logo {
            position: absolute;
            top: 0;
            left: 0;
            width: 150px;
            height: auto;
        }
        .header-title {
            margin-top: 50px; 
        }
    </style>
    
</head>
<body>
    <img src="{{ public_path('images/logo.png') }}" alt="Logo de la Institución" id="logo">

    <h1 class="header-title">Reporte de Centímetros Lineales</h1>
    <p><strong>Rango de fechas:</strong> {{ $startDate }} - {{ $endDate }}</p>
    <table>
        <thead>
            <tr>
                <th>Tipo de Documento</th>
                <th>CM Lineales</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prontuarios as $report)
                <tr>
                    <td>{{ $report['doc_type'] }}</td>
                    <td>{{ number_format($report['cm_lineales'], 2) }} cm</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
