<DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/global.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        h1 {
            color: #333;
        }
        p {
            color: #666;
        }
        #botones {
            display: flex;
            margin-top: 20px;
            gap: 20px;
            justify-content: center;
            align-items: center;
        }
        #botones button {
            min-width: 200px;
        }
    </style>

    <title>Sin Permiso</title>
</head>
<body>
    <div>
        <h1>No tienes permiso para acceder a esta página.</h1>
        <p>Por favor, contacta con el administrador si crees que esto es un error.</p>
    </div>
    <div id="botones">
        <button type="button" class="volver">Volver</button>
        <button type="button" class="cerrarSesion">Cerrar sesión</button>
    </div>
</body>

<script>
    document.querySelector('.volver').addEventListener('click', function() {
        if(history.length > 1) {
            history.back(); // Vuelve a la página anterior
        } else {
            window.location.href = '../index.php'; // Redirige a una página predeterminada si no hay historial
        }
    });

    document.querySelector('.cerrarSesion').addEventListener('click', function() {
        window.location.href = '../controllers/logout.php'; // Redirige a cerrar sesión
    });
</script>
</html>