<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Componentes de Equipos Informáticos</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Estilos para el encabezado con los logos */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .header-table td {
            text-align: center;  /* Alineación centrada horizontalmente */
            vertical-align: middle;  /* Alineación centrada verticalmente */
        }
        .header-table img {
            display: block;
            margin: auto;
        }
        .header-table h3 {
            margin: 0;
            font-size: 1.2em;
        }

        hr {
            border: 0;
            height: 1px;
            background-color: #ccc;
            margin: 0;
        }

        /* Estilos de la tabla */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }
        .data-table th, .data-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .data-table th {
            background-color: #f2f2f2;
            text-align: left;
        }

        /* Estilos del pie de página */
        .footer {
            background-color: #f5f5f5;
            padding: 20px;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: left;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td><img src="../public/images/logosalle1.png" width="100px" height="40px" alt="Logo La Salle"></td>
            <td>
                <h3>Instituto de Educación Superior Público La Salle</h3>
            </td>
            <td><img src="../public/vendor/adminlte/dist/img/sisgti.png" width="50px" height="50px" alt="Logo SisGTI"></td>
        </tr>
        <tr>
            <td colspan="3"><hr></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center;">
                Reporte de Componentes de Equipos Informáticos
            </td>
        </tr>
    </table>
    @foreach ($equipoinformatico as $equipoinformaticos)
        <h4>{{ $equipoinformaticos->marca }} {{ $equipoinformaticos->modelo }} - Laboratorio: {{ $equipoinformaticos->laboratorio->nombre }}</h4>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Serie</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($equipoinformaticos->componentes as $componente)
                    <tr>
                        <td>{{ $componente->tipo }}</td>
                        <td>{{ $componente->descripcion }}</td>
                        <td>{{ $componente->marca }}</td>
                        <td>{{ $componente->modelo }}</td>
                        <td>{{ $componente->numeroserie }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

</body>
</html>
