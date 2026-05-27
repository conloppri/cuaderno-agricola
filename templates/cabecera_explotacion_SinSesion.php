<!-- Cabecera específica para la pantalla de creación de nuevo usuario -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuaderno agrícola</title>
    <!--  He puesto el enlace a global.css para que se apliquen los estilos generales -->
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/estilos_pruebas.css">
    <link rel=stylesheet href="../css/explotaciones.css">     <!-- Enlace al archivo CSS específico para esta vista -->
</head>

<body>
    <div class="cabecera_exp">
        <div style="display: flex; align-items: center;">
            <img src="../assets/logo.png" alt="Logo" style="width: 50px; height: 50px;">
            <h3>Cuaderno de Campo</h3>
        </div>
        <div>
            <button type="button" id="btnVolverInicio" class="user_button">Volver</button>
        </div>
    </div>

    <script>
        document.getElementById('btnVolverInicio').addEventListener('click', function() {
            window.location.href = '../index.php';
        });
    </script>