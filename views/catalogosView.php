<?php include '../templates/cabecera_explotacion.php'; ?>

<?php
include "../controllers/globalController.php";

$explotacion_id = $_GET['explotacion_id'];
$nombre_explotacion = obtenerNombreExplotacion($explotacion_id);

$catalogo = $_GET['catalogo'] ?? 'cultivos'; // Por defecto se muestra el catálogo de cultivos
?>

<div class="main_content">
    <div class="cabecera_main">
        <h1><?php echo $nombre_explotacion ?></h1>
        <i class="ti ti-building-cottage"></i>
        <h2 class="titulo_principal">Catálogos</h2>
    </div>
    <div class="main_catalogos">
        <nav class="nav_catalogos">
            <li><a class="<?php echo ($catalogo == 'cultivos') ? 'active' : ''; ?>" href="../views/catalogosView.php?explotacion_id=<?php echo $explotacion_id; ?>&catalogo=cultivos"><i class="ti ti-plant"></i><span>Cultivos</span></a></li>
            <li><a class="<?php echo ($catalogo == 'ecorregimenes') ? 'active' : ''; ?>" href="../views/catalogosView.php?explotacion_id=<?php echo $explotacion_id; ?>&catalogo=ecorregimenes"><i class="ti ti-world"></i><span>Ecorregímenes</span></a></li>
            <li><a class="<?php echo ($catalogo == 'fertilizantes') ? 'active' : ''; ?>" href="../views/catalogosView.php?explotacion_id=<?php echo $explotacion_id; ?>&catalogo=fertilizantes"><i class="ti ti-plant"></i><span>Fertilizantes</span></a></li>
            <li><a class="<?php echo ($catalogo == 'fitosanitarios') ? 'active' : ''; ?>" href="../views/catalogosView.php?explotacion_id=<?php echo $explotacion_id; ?>&catalogo=fitosanitarios"><i class="ti ti-ambulance"></i><span>Fitosanitarios</span></a></li>
        </nav>

        <div class="catalogo_info">
            <?php if($catalogo == 'cultivos'): ?>
                <h3>Catálogo de cultivos</h3>
                <p>En este catálogo se pueden consultar los diferentes cultivos registrados en la aplicación, con información sobre su ciclo de cultivo, necesidades de riego y fertilización, entre otros datos relevantes para su manejo.</p>
            <?php elseif($catalogo == 'ecorregimenes'): ?>
                <h3>Catálogo de ecorregímenes</h3>
                <p>En este catálogo se pueden consultar los diferentes ecorregímenes definidos en la aplicación, con información sobre las características climáticas y edáficas de cada uno.</p>
            <?php elseif($catalogo == 'fertilizantes'): ?>
                <h3>Catálogo de fertilizantes</h3>
                <p>En este catálogo se pueden consultar los diferentes fertilizantes registrados en la aplicación, con información sobre su composición, dosis recomendada, etc.</p>
            <?php elseif($catalogo == 'fitosanitarios'): ?>
                <h3>Catálogo de productos fitosanitarios</h3>
                <p>En este catálogo se pueden consultar los diferentes productos fitosanitarios registrados en la aplicación, con información sobre su composición, dosis recomendada, etc.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
       


<?php include '../templates/footer.php'; ?>