<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página acceso prohibido</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        html {
            height: 100%;
        }

        body {
            height: 100%;
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .error {
            width: 100%;
            max-width: 500px;
            padding: 15px;
            margin: auto;
        }
    </style>
</head>

<body>
    <div class="error">
        <h1 class="fw-bold">Error 403</h1>
        <p class="lead">Lo sentimos, La sesion se cerro y no tienes acceso.</p>
        <a href="{{ url('/') }}">Volver al inicio</a>
    </div>
</body>

</html>
