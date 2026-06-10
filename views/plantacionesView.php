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

<dialog id="modalAddPlantacion" class="modal_formulario">
    <div class="modal_content">
        <span class="close_button" onclick="document.getElementById('modalAddPlantacion').close();">&times;</span>
        <h2 style="text-align: center;">Agregar plantación</h2>
        <form id="addPlantacion-form">
            <div class="grupo-form">
                <label for="nombre">Fecha inicio:</label>
                <input type="date" id="nombre" name="nombre" required>
                <label for="parcela">Parcela:</label>
                <select name="parcela" id="parcela">
                    <option value="" selected disabled>Selecciona parcela</option>
                    <?php
                    $parcelas = obtenerParcelasExplotacion($explotacion_id);
                    foreach ($parcelas as $parcela) {
                        echo "<option value='" . $parcela['parcela_id'] . "'>" . htmlspecialchars($parcela['nombre']) . "</option>";
                    }
                    ?>
                </select>
                <label for="cultivo">Cultivo:</label>
                <select name="cultivo" id="cultivo">
                    <option value="" selected disabled>Selecciona cultivo</option>
                    <?php 
                    $cultivos = obtenerCatalogoCultivos();
                    foreach ($cultivos as $cultivo) {
                        echo "<option value='" . $cultivo['cultivo_id'] . "'>" . htmlspecialchars($cultivo['nombre']) . htmlspecialchars(($cultivo['variedad']) ? ' - ' . $cultivo['variedad'] : '') . "</option>";
                    }
                    ?>
                </select>
                <label for="unidadGestion">Unidad de gestión:</label>
                <select name="unidadGestion" id="unidadGestion">
                    <option value="" selected disabled>Selecciona unidad de gestión</option>
                    <?php
                    $unidadGestion = obtenerUnidadesGestionExplotacion($explotacion_id);
                    foreach ($unidadGestion as $unidad) {
                        echo "<option value='" . $unidad['unidad_gestion_id'] . "'>" . htmlspecialchars($unidad['nombre']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <p id="mensaje-error" style="color: red; text-align: center;"></p>
            <div style="display: flex; justify-content: space-around; margin-top: 20px;">
                <button type="submit" class="add_button">Guardar</button>
                <button type="button" class="cancel_button" onclick="cerrarFormulario()">Cancelar</button>
            </div>
        </form>
    </div>
</dialog>

<script>
    document.querySelector('.fab').addEventListener('click', function() {
        document.getElementById('modalAddPlantacion').showModal();
    });

    function cerrarFormulario() {
        document.getElementById('modalAddPlantacion').close();
    }
</script>

<?php include '../templates/footer.php'; ?>