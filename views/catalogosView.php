<?php include '../templates/cabecera_explotacion.php'; ?>

<?php
include "../controllers/globalController.php";
include_once "../controllers/catalogosController.php";

$explotacion_id = $_GET['explotacion_id'];
$nombre_explotacion = obtenerNombreExplotacion($explotacion_id);

$catalogo = $_GET['catalogo'] ?? 'cultivos'; // Por defecto se muestra el catálogo de cultivos

$cultivos = obtenerCatalogoDeCultivos();
$ecorregimenes = obtenerCatalogoEcorregimenes();
$fertilizantes = obtenerCatalogoFertilizantes();
$fitosanitarios = obtenerCatalogoFitosanitarios();
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
                <h2>Catálogo de cultivos</h2>
                <ul class="lista-columna">
                    <?php foreach($cultivos as $cultivo): ?>
                        <li>
                            <strong><?php echo $cultivo['id'] . ' ' . ucfirst($cultivo['nombre']); ?></strong> <br>
                            Tipo: <?php echo $cultivo['tipo']; ?> - 
                            Ciclo: <?php echo $cultivo['ciclo']; ?><br>
                            Descripción: <?php echo $cultivo['descripcion']== null ? 'No disponible' : $cultivo['descripcion']; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

            <?php elseif($catalogo == 'ecorregimenes'): ?>
                <h2>Catálogo de ecorregímenes</h2>
                <ul class="lista-catalogo">
                    <?php foreach($ecorregimenes as $ecorregimen): ?>
                        <li>
                            <strong><?php echo $ecorregimen['id'] . ' ' . $ecorregimen['nombre']; ?></strong><br>
                            Descripción: <?php echo $ecorregimen['descripcion']== null ? 'No disponible' : $ecorregimen['descripcion']; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php elseif($catalogo == 'fertilizantes'): ?>
                <h2>Catálogo de fertilizantes</h2>
                <ul class="lista-columna">
                    <?php foreach($fertilizantes as $fertilizante): ?>
                        <li>
                            <strong><?php echo $fertilizante['id'] . '. ' . $fertilizante['num_registro'].' '. $fertilizante['nombre']; ?></strong><br>
                            Composición: N <?php echo $fertilizante['nitrogeno'];?>% - P <?php echo $fertilizante['fosforo'];?>% - K <?php echo $fertilizante['potasio'];?>% <br>
                            Descripción: <?php echo $fertilizante['descripcion']== null ? 'No disponible' : $fertilizante['descripcion']; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php elseif($catalogo == 'fitosanitarios'): ?>
                <h2>Catálogo de productos fitosanitarios</h2>
                <ul class="lista-columna">
                    <?php foreach($fitosanitarios as $fitosanitario): ?>
                        <li>
                            <strong><?php echo $fitosanitario['id'] . '. ' . $fitosanitario['num_registro'].' ' . $fitosanitario['nombre']; ?></strong><br>
                            Descripción: <?php echo $fitosanitario['descripcion']== null ? 'No disponible' : $fitosanitario['descripcion']; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
       


<?php include '../templates/footer.php'; ?>