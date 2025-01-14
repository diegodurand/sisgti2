<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de PCs</title>
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
            background-color: #ffff;
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
    <!-- Encabezado con logos -->
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
                Reporte de PCs
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center;">
                Fecha de creación: {{ date('d/m/Y') }}
            </td>
        </tr>
    </table>
    
    <!-- Sección con la tabla de datos -->
    <section>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Estado</th>
                    <th>Laboratorio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($equipos as $equipoinformaticos)
                    <tr>
                        <td>{{ $equipoinformaticos->marca }}</td>
                        <td>{{ $equipoinformaticos->modelo }}</td>
                        <td>{{ $equipoinformaticos->estado }}</td>
                        <td>{{ $equipoinformaticos->laboratorio->nombre ?? 'No asignado' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <!-- Pie de página -->
    <div class="footer">
        <p>Responsable de sistema de gestión de inventarios SISGTI &copy; Hebert Illa Quispe, 2024</p>
    </div>
</body>
</html>
