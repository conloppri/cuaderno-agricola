<!-- Cabecera -->
<?php include "../templates/cabecera_explotacion.php"; ?>

<!-- Contenido principal -->
<?php include "../controllers/parcelaController.php";

//Desde la pantalla de explotaciones, se envía el id de la explotación para mostrar solo las parcelas de esa explotación. 

$explotacion_id = $_POST['id'] ?? 1; //Como aun no sta implementado el paso de información, se asigna un id por defecto para mostrar las parcelas de la explotación con id 1.
$parcelas = obtenerInfoParcelas($connection, $explotacion_id);
?>
<div class="main_content">
    <div class="cabecera_parcelas">
        <h1>Parcelas y unidades de gestión</h1>
        <button type="button" class="add_button" onclick="abrirFormularioParcela()">+ Añadir parcela</button>
    </div>

    <!-- Formulario para añadir nueva parcela -->
    <dialog id="parcela_modal" class= "modal_formulario">
        <div>
            <h2 style="text-align: center;">Nueva parcela</h2>
            <form action="guardar.php" method="POST">
                <div class="grupo-form">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" placeholder="Nombre">
                    <label for="provincia">Provincia:</label>
                    <select name="provincia" id="provincia">
                        <option value="" selected disabled>Selecciona provincia</option>
                        <?php
                        $provincias = obtenerProvincias($connection);
                        foreach ($provincias as $provincia) {
                            echo "<option value='" . $provincia['provincia_id'] . "'>" . htmlspecialchars($provincia['nombre']) . "</option>";
                        }
                        ?>
                    </select>
                    <label for="municipio">Municipio:</label>
                    <select name="municipio" id="municipio">
                        <option value="" selected disabled>Selecciona municipio</option>
                    </select>
                    <label for="superficie">Superficie (ha):</label>
                    <input type="number" step="0.1" name="superficie" placeholder="Superficie">
                    <label for="sigpac">SIGPAC:</label>
                    <input type="text" name="sigpac" placeholder="SIGPAC">
                </div>
                <div style="display: flex; justify-content: space-around; margin-top: 20px;">
                    <button class="add_button" type="submit">Guardar</button>
                    <button  class="cancel_button" type="button" onclick="cerrarFormularioParcela()">Cancelar</button>
                </div>
            </form>
        </div>
    </dialog>


    <div class="table_exp">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>SIGPAC</th>
                    <th>Provincia</th>
                    <th>Municipio</th>
                    <th>Superficie (ha)</th>
                    <th>Unidades de gestión</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parcelas as $parcela): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($parcela['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($parcela['sigpac']); ?></td>
                        <td><?php echo htmlspecialchars($parcela['provincia']); ?></td>
                        <td><?php echo htmlspecialchars($parcela['municipio']); ?></td>
                        <td><?php echo htmlspecialchars($parcela['superficie']); ?></td>
                        <td><button type="button" onclick="toggleFila(<?php echo $parcela['id']; ?>)"> + </button></td>
                    </tr>
                    <tr id="fila-<?php echo $parcela['id']; ?>" style="display: none;">
                        <td colspan="6" class="celda_detalle">
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="3">Unidades de gestión</th>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Superficie (ha)</th>
                                        <th>Uso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $unidadesGestion = obtenerInfoUnidadesGestion($connection, $parcela['id']);
                                    foreach ($unidadesGestion as $unidad): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($unidad['nombre']); ?></td>
                                            <td><?php echo htmlspecialchars($unidad['superficie']); ?></td>
                                            <td><?php echo htmlspecialchars($unidad['uso']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <button type="button" class="add_button" onclick="abrirFormularioUniGest()">+ Añadir unidad de gestión</button>
                            <dialog class="modal_formulario" id="uniGestion_modal">
                                <div>
                                    <h2 style="text-align: center;">Nueva unidad de gestión</h2>
                                    <div class="grupo-form">
                                        <label for="nombre">Nombre:</label>
                                        <input type="text" name="nombre" placeholder="Nombre">
                                        <label for="superficie">Superficie (ha):</label>
                                        <input type="number" step="0.1" name="superficie" placeholder="Superficie">
                                        <label for="uso">Uso:</label>
                                        <select name="uso" id="uso">
                                            <option value="" selected disabled>Selecciona uso</option>
                                            <option value="agrícola">Agrícola</option>
                                            <option value="ganadero">Ganadero</option>
                                            <option value="forestal">Forestal</option>
                                            <option value="en descanso">En descanso</option>
                                            <option value="otro">Otro</option>
                                        </select>
                                    </div>
                                        <button type="submit" class="add_button">Guardar</button>
                                        <button type="button" class="cancel_button" onclick="cerrarFormularioUniGest()">Cancelar</button>
                                    </form>
                                </div>
                            </dialog>
                        </td>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    //Función para que aparezcan las unidades de gestión ocmo una fila extra de tabla
    function toggleFila(id) {
        var fila = document.getElementById("fila-" + id);
        if (fila.style.display === "none") {
            fila.style.display = "table-row";
        } else {
            fila.style.display = "none";
        }
    }
    function abrirFormularioParcela() {
        document.getElementById('parcela_modal').showModal();
    }

    function cerrarFormularioParcela() {
        document.getElementById('parcela_modal').close();
    }

    function abrirFormularioUniGest() {
        document.getElementById("uniGestion_modal").showModal();
    }

    function cerrarFormularioUniGest() {
        document.getElementById("uniGestion_modal").close();
    }

    //Municpios por provincia
    document.getElementById("provincia").addEventListener("change", function() {
        const provinciaId = this.value;

        fetch("../controllers/obtenerMunicipios.php?provincia_id=" + provinciaId)
            .then(res => res.json())
            .then(data => {
                const selectMunicipio = document.getElementById("municipio");

                data.forEach(m => {
                    selectMunicipio.innerHTML += `<option value="${m.id}">${m.nombre}</option>`;
                });
            });
    });
</script>
<!-- Pie de página -->
<?php include "../templates/footer.php"; ?>