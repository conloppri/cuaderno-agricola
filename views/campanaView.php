<?php include "../templates/cabecera_explotacion.php"; ?>

<?php
include "../controllers/globalController.php";

$explotacion_id = $_GET['explotacion_id'];
$nombre_explotacion = obtenerNombreExplotacion($explotacion_id);

include_once "../controllers/campanaController.php";
$campanas = obtenerCampanas($explotacion_id);

$ano_campana = $_GET['campana'] ?? null;

if ($ano_campana == null) {
    header("Location: campanaView.php?explotacion_id=$explotacion_id&campana={$campanas[0]['ano']}");
    exit();
}

?>

<div class="main_content">
    <div class="cabecera_main">
        <h1><?php echo $nombre_explotacion; ?></h1>
        <i class="ti ti-calendar"></i>
        <h2 class="titulo_principal">Campañas</h2>
    </div>
    <div class="main_campanas">
        <nav class="nav_campanas">
            <?php foreach ($campanas as $campana): ?>
                <a href="campanaView.php?explotacion_id=<?php echo $explotacion_id; ?>&campana=<?php echo $campana['ano']; ?>">
                    <?php echo $campana['nombre']; ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="info_campanas">
            <h3 style="text-align: center; grid-column: span 3;">Resumen de la campaña <?php echo $ano_campana; ?></h3>
            <?php $resumen = obtenerResumenCampana($explotacion_id, $ano_campana); ?>
            <div class="card-campana" onclick="mostrarDetalle()">
                <h3>Plantaciones</h3>
                <?php if ($resumen['plantaciones']['numPlantaciones'] > 0): ?>
                    <p>Número de plantaciones: <?php echo $resumen['plantaciones']['numPlantaciones']; ?></p>
                    <p>Fecha de plantación más reciente: <?php echo $resumen['plantaciones']['fechaReciente']; ?></p>
                <?php else: ?>
                    <p>No hay plantaciones registradas para esta campaña.</p>
                <?php endif; ?>
            </div>
            <div class="card-campana">
                <h3>Cosechas</h3>
                <?php if ($resumen['cosechas']): ?>
                    <p>Última cosecha:</p>
                    <p><?php echo $resumen['cosechas']['fecha_fin'] . " - " . ucfirst($resumen['cosechas']['cultivo']) . " - " . $resumen['cosechas']['cantidad'] . " " . $resumen['cosechas']['unidad']; ?></p>
                <?php else: ?>
                    <p>No hay cosechas registradas para esta campaña.</p>
                <?php endif; ?>
            </div>
            <div class="card-campana" onclick="mostrarDetalleTratamientos()">
                <h3>Tratamientos</h3>
                <?php if ($resumen['tratamientos']): ?>
                    <p>Último tratamiento:</p>
                    <p><?php echo $resumen['tratamientos']['fecha'] . " - " . ucfirst($resumen['tratamientos']['fitosanitario']) . " - " . $resumen['tratamientos']['parcela'] . " - " . $resumen['tratamientos']['cultivo']; ?></p>
                <?php else: ?>
                    <p>No hay tratamientos registrados para esta campaña.</p>
                <?php endif; ?>
            </div>
            <div class="card-campana" onclick="mostrarDetalleFertilizaciones()">
                <h3>Fertilizaciones</h3>
                <?php if ($resumen['fertilizaciones']): ?>
                    <p>Última fertilización:</p>
                    <p><?php echo $resumen['fertilizaciones']['fecha'] . " - " . ucfirst($resumen['fertilizaciones']['fertilizante']) . " - " . $resumen['fertilizaciones']['parcela'] . " - " . $resumen['fertilizaciones']['cultivo']; ?></p>
                <?php else: ?>
                    <p>No hay fertilizaciones registradas para esta campaña.</p>
                <?php endif; ?>
            </div>
            <div class="card-campana">
                <h3>Riego</h3>
                <p>En desarrollo...</p>
            </div>
            <div class="card-campana">
                <h3>Labores</h3>
                <p>En desarrollo...</p>
            </div>
        </div>
    </div>

    <!-- En desarollo: sección de detalles de plantaciones, tratamientos, fertilizaciones, riego y labores -->
     <!-- Por ahora solo se muestra el detalle de las plantaciones al hacer click en la card correspondiente, solo versión de prueba -->
    <div class="detalle-campaña">
        <h3 style="text-align: center; grid-column: span 3;">Detalles de las plantaciones de la campaña <?php echo $ano_campana; ?></h3>
        <?php $plantaciones = obtenerDetallesPlantacionesPorCampana($explotacion_id, $ano_campana); ?>
        <?php if (count($plantaciones) > 0): ?>
            <table class="info_table">
                <thead>
                    <tr>
                        <th>Fecha de plantación</th>
                        <th>Finalidad</th>
                        <th>Cultivo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($plantaciones as $plantacion): ?>
                        <tr>
                            <td><?php echo $plantacion['fecha_inicio']; ?></td>
                            <td><?php echo $plantacion['finalidad']; ?></td>
                            <td><?php echo $plantacion['cultivo']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay plantaciones registradas para esta campaña.</p>
        <?php endif; ?>
    </div>

    <!-- Detalles de los tratamientos de la campaña -->
    <div class="detalle-campana-tratamientos">
        <h3 style="text-align: center; grid-column: span 3;">Detalles de los tratamientos de la campaña <?php echo $ano_campana; ?></h3>
        <?php $tratamientos = obtenerDetallesTratamientosPorCampana($explotacion_id, $ano_campana); ?>
        <?php if (count($tratamientos) > 0): ?>
            <table class="info_table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Fitosanitario</th>
                        <th>Parcela</th>
                        <th>Cultivo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tratamientos as $tratamiento): ?>
                        <tr>
                            <td><?php echo $tratamiento['fecha']; ?></td>
                            <td><?php echo $tratamiento['fitosanitario']; ?></td>
                            <td><?php echo $tratamiento['parcela']; ?></td>
                            <td><?php echo $tratamiento['cultivo']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay tratamientos registrados para esta campaña.</p>
        <?php endif; ?>
    </div>

        <!-- Detalles de las fertilizaciones de la campaña -->
        <div class="detalle-campana-fertilizaciones">
            <h3 style="text-align: center; grid-column: span 3;">Detalles de las fertilizaciones de la campaña <?php echo $ano_campana; ?></h3>
            <?php $fertilizaciones = obtenerDetallesFertilizacionesPorCampana($explotacion_id, $ano_campana); ?>
            <?php if (count($fertilizaciones) > 0): ?>
                <table class="info_table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Fertilizante</th>
                            <th>Parcela</th>
                            <th>Cultivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fertilizaciones as $fertilizacion): ?>
                            <tr>
                                <td><?php echo $fertilizacion['fecha']; ?></td>
                                <td><?php echo $fertilizacion['fertilizante']; ?></td>
                                <td><?php echo $fertilizacion['parcela']; ?></td>
                                <td><?php echo $fertilizacion['cultivo']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay fertilizaciones registradas para esta campaña.</p>
            <?php endif; ?>
        </div>

    <div class="fab-container">
        <span class="fab-etiqueta">En desarrollo</span>
        <button class="fab" onclick="window.location.href='campanaAdd.php'">+</button>
    </div>
</div>

<script>
    function mostrarDetalle() {
        $detalle = document.querySelector('.detalle-campaña');
        if ($detalle.style.display === 'none' || $detalle.style.display === '') {
            $detalle.style.display = 'block';
            Sdetalle.focus();
        } else {
            $detalle.style.display = 'none';
        }
    }

    function mostrarDetalleTratamientos() {
        $detalle = document.querySelector('.detalle-campana-tratamientos');
        if ($detalle.style.display === 'none' || $detalle.style.display === '') {
            $detalle.style.display = 'block';
            Sdetalle.focus();
        } else {
            $detalle.style.display = 'none';
        }
    }

    function mostrarDetalleFertilizaciones() {
        $detalle = document.querySelector('.detalle-campana-fertilizaciones');
        if ($detalle.style.display === 'none' || $detalle.style.display === '') {
            $detalle.style.display = 'block';
            $detalle.focus();
        } else {
            $detalle.style.display = 'none';
        }
    }
</script>


<?php include "../templates/footer.php"; ?>