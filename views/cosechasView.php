<?php
include '../templates/cabecera_cuadernoCampo.php';

$explotacion_id = $_GET['explotacion_id'];
$nombre_explotacion = obtenerNombreExplotacion($explotacion_id);

$plantaciones = obtenerPlantacionesExplotacion($explotacion_id);
?>

<div class="main_content">
    <div class="cabecera_main">
        <h1><?php echo $nombre_explotacion; ?></h1>
        <i class="ti ti-plant"></i>
        <h2 class="titulo_principal">Plantaciones</h2>
    </div>

    <div class="table_exp">
        <table>
            <thead>
                <tr>
                    <th>Fecha inicio</th>
                    <th>Parcela</th>
                    <th>Cultivo</th>
                    <th>Variedad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaCosechas">
                <?php foreach ($plantaciones as $plantacion): ?>
                    <tr>
                        <td><?php echo $plantacion['fecha_inicio']; ?></td>
                        <td><?php echo $plantacion['parcela_nombre']; ?></td>
                        <td><?php echo $plantacion['cultivo_nombre']; ?></td>
                        <td><?php echo $plantacion['variedad_nombre']; ?></td>
                        <td>
                            <button type="button" class="btnModificarCosecha" data-id="<?php echo $plantacion['plantacion_id']; ?>">Modificar</button>
                            <button type="button" class="btnEliminarCosecha" data-id="<?php echo $plantacion['plantacion_id']; ?>">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="fab-container">
    <span class="fab-etiqueta">Añadir</span>
    <button class="fab" onclick="">+</button>
</div>

<?php include '../templates/footer.php'; ?>