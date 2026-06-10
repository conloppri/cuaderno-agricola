<?php
include '../controllers/comprobarSesion.php';
?>

<!-- Cabecera específica para la pantalla principal de explotaciones -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de usuario</title>
    <!--  He puesto el enlace a global.css para que se apliquen los estilos generales -->
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/estilos_pruebas.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel=stylesheet href="../css/explotaciones.css">     <!-- Enlace al archivo CSS específico para esta vista -->
</head>

<body>
    <div class="cabecera_exp">
        <div style="display: flex; align-items: center;">
            <img src="../assets/logo.png" alt="Logo" style="width: 50px; height: 50px;">
            <h3>Cuaderno de Campo</h3>
        </div>
        <div>
            <button type="button" id="btnVolver" class="user_button">Volver</button>
            <button type="button" id="btnCerrarSesion" class="user_button"><?php echo "(" . $_SESSION['username'] . ")"; ?></br>Cerrar sesión</button>
        </div>
    </div>

    <script>
        document.getElementById('btnCerrarSesion').addEventListener('click', function() {
            window.location.href = '../controllers/logout.php';
        });

        document.getElementById('btnVolver').addEventListener('click', function() {
            window.location.href = '../views/explotacionesView.php';
        });
    </script>