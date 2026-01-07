<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Números Generados</title>
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
            margin-top: 40px; 
        }
    </style>
    
</head>
<body>
    <img src="{{ public_path('images/logo.png') }}" alt="Logo de la Institución" id="logo">

    <h1 class="header-title">Historial de Números Generados</h1>
    {{-- <h2>Números Generados</h2> --}}
    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Trabajador</th>
                <th>Área</th>
                <th>Grupo</th>
                <th>Subgrupo</th>
                <th>E. Externa</th>
                <th>T. Público</th>
                <th>Giro</th>
                <th>Documento</th>
                <th>Número</th>
                <th>Folios</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @php $counter = 1; @endphp
            @forelse ($prontuario as $index => $item)
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{ $item->worker->name }}</td>
                    <td>{{ $item->area->abbreviation ?? 'N/A' }}</td>
                    <td>{{ $item->group->description ?? 'N/A' }}</td>
                    <td>{{ $item->subgroup->description ?? 'N/A' }}</td>
                    <td>{{ $item->entity->abbreviation ?? 'N/A' }}</td>
                    <td>{{ $item->publicType->description ?? 'N/A' }}</td>
                    <td>{{ $item->giroType->description ?? 'N/A' }}</td>
                    <td>{{ $item->docType->abbreviation ?? 'N/A' }}</td>
                    <td>{{ $item->number ?? 'N/A' }}</td>
                    <td>{{ $item->folios ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="text-align: center;">No hay números asociados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
