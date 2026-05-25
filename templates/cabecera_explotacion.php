<?php 
include '../controllers/comprobarSesion.php';

$explotacion_id = $_GET['explotacion_id']; //Como aun no esta implementado el paso de información, se asigna un id por defecto para mostrar las parcelas de la explotación con id 1.
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuaderno agrícola</title>
    <!--  He puesto el enlace a global.css para que se apliquen los estilos generales -->
    <!-- <link rel="stylesheet" href="../css/global.css"> -->
    <link rel="stylesheet" href="../css/estilos_pruebas.css">
</head>

<body>
    <div class="cabecera_exp">
        <div style="display: flex; align-items: center;">
            <img src="../assets/logo.png" alt="Logo" style="width: 50px; height: 50px;">
            <h3>Cuaderno de Campo</h3>
        </div>
        <nav>
            <li><a href="../views/parcelasView.php?explotacion_id=<?php echo $explotacion_id; ?>">Parcelas</a></li>
            <li><a href="#">Campañas</a></li>
            <li><a href="../views/personalView.php?explotacion_id=<?php echo $explotacion_id; ?>">Personal</a></li>
            <li><a href="../views/maquinariaView.php?explotacion_id=<?php echo $explotacion_id; ?>">Maquinaria</a></li>
            <li><a href="#">Instalaciones</a></li>
            <li><a href="#">Fertilizantes</a></li>
        </nav>
        <div>
            <button id="btnVolverInicio" class="user_button">Explotaciones</button>
            <button type="button" id="btnCerrarSesion" class="user_button"><?php echo "(" . $_SESSION['username'] . ")"; ?></br>Cerrar sesión</button>
        </div>
    </div>

    <script>
        document.getElementById('btnCerrarSesion').addEventListener('click', function() {
            window.location.href = '../controllers/logout.php';
        });

        document.getElementById('btnVolverInicio').addEventListener('click', function() {
            window.location.href = '../views/explotacionesView.php';
        });
    </script>