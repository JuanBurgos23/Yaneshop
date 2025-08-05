<html>

<head>
    <title>Reporte de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2,
        h4 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Reporte de Productos</h2>
    @foreach($categorias as $categoria)
    <h4>{{ $categoria->nombre }} - {{ $categoria->descripcion }}</h4>
    <table width="100%" border="1" cellspacing="0" cellpadding="4">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categoria->productos as $prod)
            <tr>
                <td>{{ $prod->nombre }}</td>
                <td>{{ $prod->precio }}</td>
                <td>{{ $prod->descripcion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endforeach
</body>

</html>