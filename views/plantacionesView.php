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
                    <th>Fecha fin</th>
                    <th>Parcela</th>
                    <th>Cultivo</th>
                    <th>Variedad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaPlantacion">
                <?php foreach ($plantaciones as $plantacion): ?>
                    <tr>
                        <td><?php echo $plantacion['fecha_inicio']; ?></td>
                        <td><?php echo $plantacion['fecha_fin']; ?></td>
                        <td><?php echo $plantacion['parcela_nombre']; ?></td>
                        <td><?php echo $plantacion['cultivo_nombre']; ?></td>
                        <td><?php echo $plantacion['variedad_nombre']; ?></td>
                        <td>
                            <button type="button" class="btnModificarPlantacion" onclick='modificarPlantacion(
                                        <?php echo json_encode($plantacion["plantacion_id"]); ?>,
                                        <?php echo json_encode($plantacion["parcela_id"]); ?>,
                                        <?php echo json_encode($plantacion["unidad_gestion_id"]); ?>,
                                        <?php echo json_encode($plantacion["cultivo_id"]); ?>,
                                        <?php echo json_encode($plantacion["densidad_unidad"]); ?>,
                                        <?php echo json_encode($plantacion["recinto"]); ?>,
                                        <?php echo json_encode($plantacion["fecha_inicio"]); ?>,
                                        <?php echo json_encode($plantacion["fecha_fin"]); ?>,
                                        <?php echo json_encode($plantacion["sistema_cultivo"]); ?>,
                                        <?php echo json_encode($plantacion["sistema_riego"]); ?>,
                                        <?php echo json_encode($plantacion["finalidad"]); ?>,
                                        <?php echo json_encode($plantacion["manejo"]); ?>,
                                        <?php echo json_encode($plantacion["valor_densidad"]); ?>,
                                        <?php echo json_encode($plantacion["anotaciones"]); ?>
                                    )'><i class="ti ti-pencil"></i>Modificar</button>
                            <button type="button" class="btnEliminarPlantacion" data-id="<?php echo $plantacion['plantacion_id']; ?>"><i class="ti ti-trash"></i>Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="fab-container">
    <span class="fab-etiqueta">Añadir</span>
    <button class="fab" onclick="abrirFormulario()">+</button>
</div>

<dialog id="modalAddPlantacion" class="modal_formulario">
    <div class="modal_content">
        <span class="close_button" onclick="cerrarFormulario();">&times;</span>
        <h2 style="text-align: center;">Agregar plantación</h2>
        <form id="plantacion-form">
            <div class="grupo-form">
                <input id="accionPlantacion" type="hidden" name="accion" value="crearPlantacion">
                <input id="plantacion_id" type="hidden" name="plantacion_id">
                <label for="fecha_inicio">Fecha inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" required>
                <label for="fecha_fin" id="label_fecha_fin" style="visibility: hidden;">Fecha fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" style="visibility: hidden;">
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
                        $variedadText = !empty($cultivo['variedad']) ? ' - ' . htmlspecialchars($cultivo['variedad']) : '';
                        echo "<option value='" . $cultivo['cultivo_id'] . "'>" . htmlspecialchars($cultivo['nombre']) . $variedadText . "</option>";
                    }
                    ?>
                </select>
                <label for="unidadGestion">Unidad de gestión:</label>
                <select name="unidadGestion" id="unidadGestion">
                    <option value="" selected disabled>Selecciona unidad de gestión</option>
                    <option value="null">Sin unidad de gestión</option>
                    <?php
                    $unidadGestion = obtenerUnidadesGestionExplotacion($explotacion_id);
                    foreach ($unidadGestion as $unidad) {
                        echo "<option value='" . $unidad['unidad_gestion_id'] . "'>" . htmlspecialchars($unidad['nombre']) . "</option>";
                    }
                    ?>
                </select>
                <label for="unidadDensidad">Unidad de densidad:</label>
                <select name="unidadDensidad" id="unidadDensidad">
                    <option value="" selected disabled>Selecciona unidad</option>
                    <?php 
                    $unidadDensidades = obtenerCatalogoUnidadDensidad();
                    foreach ($unidadDensidades as $unidadDensidad) {
                        echo "<option value='" . $unidadDensidad['unidad_id'] . "'>" . htmlspecialchars($unidadDensidad['unidad']) . "</option>";
                    }
                    ?>
                </select>
                <label for="recinto">Recinto:</label>
                <input type="number" id="recinto" name="recinto" min="0" required>
                <label for="sistema_cultivo">Sistema de cultivo:</label>
                <select name="sistema_cultivo" id="sistema_cultivo">
                    <option value="" selected disabled>Selecciona sistema de cultivo</option>
                    <option value="intensivo">Intensivo</option>
                    <option value="extensivo">Extensivo</option>
                    <option value="tradicional">Tradicional</option>
                    <option value="superintensivo">Superintensivo</option>
                </select>
                <label for="sistema_riego">Sistema de riego:</label>
                <select name="sistema_riego" id="sistema_riego">
                    <option value="" selected disabled>Selecciona sistema de riego</option>
                    <option value="secano">Secano</option>
                    <option value="goteo">Goteo</option>
                    <option value="aspersion">Aspersion</option>
                    <option value="gravedad">Gravedad</option>
                </select>
                <label for="finalidad">Finalidad:</label>
                <select name="finalidad" id="finalidad">
                    <option value="" selected disabled>Selecciona finalidad</option>
                    <option value="produccion_agricola">Produccion agricola</option>
                    <option value="autoconsumo">Autoconsumo</option>
                    <option value="ganadera">Ganadera</option>
                    <option value="conservacion">Conservacion</option>
                    <option value="energetica">Energetica</option>
                </select>
                <label for="manejo">Manejo:</label>
                <select name="manejo" id="manejo">
                    <option value="" selected disabled>Selecciona manejo</option>
                    <option value="convencional">Convencional</option>
                    <option value="produccion_integrada">Produccion integrada</option>
                    <option value="ecologico">Ecologico</option>
                    <option value="regenerativo">Regenerativo</option>
                </select>
                <label for="valor_densidad">Valor densidad:</label>
                <input type="number" id="valor_densidad" name="valor_densidad" min="0" step="0.01">
                <label for="anotaciones">Anotaciones:</label>
                <textarea id="anotaciones" name="anotaciones"></textarea>
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
    function abrirFormulario() {
        document.getElementById('modalAddPlantacion').showModal();
    }

    function cerrarFormulario() {
        document.getElementById('modalAddPlantacion').close();
        document.getElementById('accionPlantacion').value = 'crearPlantacion';
        document.getElementById('label_fecha_fin').style.visibility = 'hidden';
        document.getElementById('fecha_fin').style.visibility = 'hidden';
        document.getElementById('plantacion-form').reset();
    }

    function modificarPlantacion(plantacion_id, parcela_id, unidad_gestion_id, cultivo_id, densidad_unidad, recinto, fecha_inicio, fecha_fin, sistema_cultivo, 
        sistema_riego, finalidad, manejo, valor_densidad, anotaciones) {
            document.getElementById('accionPlantacion').value = 'modificarPlantacion';
            document.getElementById('label_fecha_fin').style.visibility = 'visible';
            document.getElementById('fecha_fin').style.visibility = 'visible';
            document.getElementById('plantacion_id').value = plantacion_id;

            document.getElementById('parcela').value = parcela_id;

            if (unidad_gestion_id === null || unidad_gestion_id === "") {
                document.getElementById('unidadGestion').value = "null";
            } else {
                document.getElementById('unidadGestion').value = String(unidad_gestion_id);
            }

            document.getElementById('cultivo').value = cultivo_id;
            document.getElementById('unidadDensidad').value = densidad_unidad;
            document.getElementById('recinto').value = recinto;
            document.getElementById('fecha_inicio').value = fecha_inicio;
            document.getElementById('fecha_fin').value = fecha_fin;
            document.getElementById('sistema_cultivo').value = sistema_cultivo;
            document.getElementById('sistema_riego').value = sistema_riego;
            document.getElementById('finalidad').value = finalidad;
            document.getElementById('manejo').value = manejo;
            document.getElementById('valor_densidad').value = valor_densidad;
            document.getElementById('anotaciones').value = anotaciones;

            abrirFormulario();
    }

    // Manejar el envío del formulario
    document.getElementById('plantacion-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('../controllers/guardarPlantacion.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Respuesta del servidor:', data);
            if(data.success) {
                alert('Explotación guardada exitosamente');
                // Recarga la página actual
                location.reload();
            } else {
                alert('Error al guardar la explotación: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error al guardar la explotación:', error);
            alert('Error al guardar la explotación');
        });
    });
</script>

<?php include '../templates/footer.php'; ?>