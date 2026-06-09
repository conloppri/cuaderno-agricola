<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../controllers/comprobarSesion.php';
include '../controllers/globalController.php';

$explotacion_id = $_GET['explotacion_id'];
$rolUsuario = obtenerRolUsuario($_SESSION['usuario_id'], $explotacion_id);

$paginaActual = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuaderno de Campo</title>
    <link rel="stylesheet" href="../css/estilos_pruebas.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
</head>

<body>
    <div class="cabecera_exp">
        <div style="display: flex; align-items: center;">
            <img src="../assets/logo.png" alt="Logo" style="width: 50px; height: 50px;">
            <h3>Cuaderno de Campo</h3>
        </div>
        <nav class="nav-explotacion">
            <?php if ($rolUsuario === 'administrador' || $rolUsuario === 'propietario' || $rolUsuario === 'trabajador'): ?>
                <li><a class="<?php echo $paginaActual=='parcelasView.php' ? 'active': ''?>" href="../views/parcelasView.php?explotacion_id=<?php echo $explotacion_id; ?>"> <i class="ti ti-fence"></i> <span>Cosechas</span></a></li>
            <?php endif; ?>
            <?php if ($rolUsuario === 'administrador' || $rolUsuario === 'propietario' || $rolUsuario === 'trabajador'): ?>
                <li><a class="<?php echo $paginaActual=='campanaView.php' ? 'active': ''?>" href="../views/campanaView.php?explotacion_id=<?php echo $explotacion_id; ?>"><i class="ti ti-calendar-smile"></i><span>Fitosanitarios</span></a></li>
            <?php endif; ?>
            <?php if ($rolUsuario === 'administrador' || $rolUsuario === 'propietario' || $rolUsuario === 'tecnico'): ?>
                <li><a class="<?php echo $paginaActual=='personalView.php' ? 'active': ''?>" href="../views/personalView.php?explotacion_id=<?php echo $explotacion_id; ?>"><i class="ti ti-users"></i> <span>Analíticas</span></a></li>
            <?php endif; ?>
            <?php if ($rolUsuario === 'administrador' || $rolUsuario === 'propietario' || $rolUsuario === 'trabajador'): ?>
                <li><a class="<?php echo $paginaActual=='maquinariaView.php' ? 'active': ''?>" href="../views/maquinariaView.php?explotacion_id=<?php echo $explotacion_id; ?>"><i class="ti ti-tractor"></i><span>Fertilizantes</span></a></li>
            <?php endif; ?>
            <?php if ($rolUsuario === 'administrador' || $rolUsuario === 'propietario' || $rolUsuario === 'trabajador' || $rolUsuario === 'mecanico'): ?>
                <li><a class="<?php echo $paginaActual=='instalacionesView.php' ? 'active': ''?>" href="../views/instalacionesView.php?explotacion_id=<?php echo $explotacion_id; ?>"><i class="ti ti-building-cottage"></i><span>Labores</span></a></li>
            <?php endif; ?>
            <?php if ($rolUsuario === 'administrador' || $rolUsuario === 'propietario' || $rolUsuario === 'administrativo'): ?>
                <li><a class="<?php echo $paginaActual=='catalogosView.php' ? 'active': ''?>" href="../views/catalogosView.php?explotacion_id=<?php echo $explotacion_id; ?>&catalogo=cultivos"><i class="ti ti-library"></i><span>Comerciales</span></a></li>
            <?php endif; ?>
        </nav>
        <div>
            <button id="btnVolverInicio" class="user_button">Campañas</button>
            <button type="button" id="btnCerrarSesion" class="user_button"><?php echo "(" . $_SESSION['username'] . ")"; ?></br>Cerrar sesión</button>
        </div>
    </div>

    <script>
        document.getElementById('btnCerrarSesion').addEventListener('click', function() {
            window.location.href = '../controllers/logout.php';
        });

        document.getElementById('btnVolverInicio').addEventListener('click', function() {
            window.location.href = '../views/campanaView.php?explotacion_id=<?php echo $explotacion_id; ?>';
        });
    </script>