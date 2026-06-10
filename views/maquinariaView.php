<?php
include "../templates/cabecera_explotacion.php";

include "../controllers/globalController.php";
include_once "../controllers/maquinariaController.php";
include '../models/rolesUsuariosModel.php';
$explotacion_id = $_GET['explotacion_id'];
$nombre_explotacion = obtenerNombreExplotacion($explotacion_id);
$rol = obtenerRolUsuarioEnExplotacion($connection, $_SESSION['usuario_id'], $explotacion_id);

$maquinaria = maquinariaController::obtenerMaquinariaPorExplotacion($connection, $explotacion_id);
?>

<div class="main_content">
    <div class="cabecera_main">
        <h1><?php echo $nombre_explotacion ?> </h1>
        <i class="ti ti-tractor"></i>
        <h2 class="titulo_principal">Maquinaria</h2>
    </div>
    <div class="lista-maquinaria">
        <?php foreach ($maquinaria as $maquina): ?>
            <div class="card-maquina" onclick="mostrarDetallesMaquina(<?php echo $maquina['id']; ?>)">
                <div class="card-body">
                    <div class="tags">
                        <div class="tag"><?php echo $maquina['tipo']; ?></div>
                        <div class="tag" style="background-color: <?php if ($maquina['estado'] == 'Activa') echo '#bdf8bf';
                                                                    else if ($maquina['estado'] == 'Fuera de servicio') echo '#ffaaa4';
                                                                    else echo '#fad68d'; ?>">
                            <?php echo $maquina['estado']; ?>
                        </div>
                    </div>
                    <h3 class="card-title"><?php echo $maquina['alias']; ?></h3>
                    <p class="card-text">
                        <strong>Modelo:</strong> <?php echo $maquina['modeloCompleto']; ?><br>
                        <strong>Matrícula:</strong> <?php echo $maquina['matricula']; ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <dialog id="maquinaria_modal" class="info_modal">
        <div class="modal_content">
            <span class="close_button" onclick="document.getElementById('maquinaria_modal').close();">&times;</span>
            <div class="modal_body">
                <h2 style="text-align: center;">Detalles de <span id="maq_alias"></span>
                    <?php if ($rol === 'administrador'): ?>
                        <button class="editar_btn" type="button" onclick=""> <i class="ti ti-pencil"></i> </button>
                        <button class="eliminar_btn" type="button" onclick=""><i class="ti ti-trash"></i> </button>
                    <?php endif ?>
                </h2>
                <table id="maq_detalles" class="info_table"></table>
            </div>
        </div>
    </dialog>

    <dialog id="add_maquinaria" class="modal_formulario maquinaria_form">
        <div class="modal_content">
            <span class="close_button" onclick="document.getElementById('add_maquinaria').close();">&times;</span>
            <h2 style="text-align: center;">Agregar nueva maquinaria</h2>

            <form id="maquinaria_form" method="POST" action="../controllers/maquinariaController.php">
                <input type="hidden" name="accion" value="agregarMaquinaria">
                <input type="hidden" name="explotacion_id" value="<?php echo $explotacion_id; ?>">
                <table class="info_table">
                    <tr>
                        <td class="info_label"><label for="alias">Alias*:</label></td>
                        <td><input type="text" id="alias" name="alias" required></td>
                    </tr>
                    <tr>
                        <td class="info_label"><label for="tipo">Tipo*:</label></td>
                        <td><select id="tipo" name="tipo" required>
                                <option value="" selected disabled>Seleccionar tipo</option>
                                <option value="Tractor">Tractor</option>
                                <option value="Arado">Arado</option>
                                <option value="Subsolador">Subsolador</option>
                                <option value="Cultivador">Cultivador</option>
                                <option value="Grada">Grada</option>
                                <option value="Sembradora">Sembradora</option>
                                <option value="Plantadora">Plantadora</option>
                                <option value="Pulverizadora">Pulverizadora</option>
                                <option value="Atomizador">Atomizador</option>
                                <option value="Cosechadora">Cosechadora</option>
                                <option value="Vibradora">Vibradora</option>
                                <option value="Remolque">Remolque</option>
                                <option value="Desbrozadora">Desbrozadora</option>
                                <option value="Trituradora">Trituradora</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="info_label"><label for="marca">Marca*:</label></td>
                        <td><input type="text" id="marca" name="marca" required></td>
                    </tr>
                    <tr>
                        <td class="info_label"><label for="modelo">Modelo*:</label></td>
                        <td><input type="text" id="modelo" name="modelo" required></td>
                    </tr>


                    <tr>
                        <td class="info_label"><label for="matricula">Matrícula*:</label></td>
                        <td><input type="text" id="matricula" name="matricula" required></td>
                    </tr>

                    <tr>
                        <td class="info_label"><label for="estado">Estado*:</label></td>
                        <td>
                            <select id="estado" name="estado" required>
                                <option value="" selected disabled>Seleccionar estado</option>
                                <option value="Activa">Activa</option>
                                <option value="Fuera de servicio">Fuera de servicio</option>
                                <option value="Mantenimiento">En mantenimiento</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="info_label"><label for="titular">Titular:</label></td>
                        <td><input type="text" id="titular" name="titular"></td>
                    </tr>
                    <tr>
                        <td class="info_label"><label for="num_roma">Número de ROMA:</label></td>
                        <td><input type="text" id="num_roma" name="num_roma"></td>
                    </tr>
                    <tr>
                        <td class="info_label"><label for="num_reganip">Número de REGANIP:</label></td>
                        <td><input type="text" id="num_reganip" name="num_reganip"></td>
                    </tr>
                    <tr>
                        <td class="info_label"><label for="fecha_adquisicion">Fecha de adquisición:</label></td>
                        <td><input type="date" id="fecha_adquisicion" name="fecha_adquisicion"></td>
                    </tr>
                    <tr>
                        <td class="info_label"><label for="ultima_inspeccion">Fecha de última inspección:</label></td>
                        <td><input type="date" id="ultima_inspeccion" name="ultima_inspeccion"></td>
                    </tr>
                    <tr>
                        <td class="info_label"><label for="caducidad_itv">Fecha de caducidad de ITV:</label></td>
                        <td><input type="date" id="caducidad_itv" name="caducidad_itv"></td>
                    </tr>
                    <tr>
                        <td class="info_label"><label for="observaciones">Observaciones:</label></td>
                        <td>
                            <textarea id="observaciones" name="observaciones" rows="3"></textarea>
                        </td>
                    </tr>
                </table>
                <p><em>* Campos obligatorios</em></p>

                <div>
                    <p id="mensaje-error" style="color: red; text-align: center;"></p>
                </div>
                <div style="display: flex; justify-content: space-around; margin-top: 20px;">
                    <button type="button" class="cancel_button" onclick="document.getElementById('add_maquinaria').close();">Cancelar</button>
                    <button type="submit" class="add_button">Guardar</button>
                </div>
            </form>
        </div>
    </dialog>

    <div class="fab-container">
        <span class="fab-etiqueta">Agregar maquinaria</span>
        <button class="fab" onclick="document.getElementById('add_maquinaria').showModal();">+</button>
    </div>

</div>

<script>
    function mostrarDetallesMaquina(id) {
        fetch(`../controllers/maquinariaController.php?accion=obtenerDetallesMaquina&id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('maq_alias').textContent = data.alias;
                document.getElementById('maq_detalles').innerHTML = `
                <tr><td class="info_label"><strong>Tipo:</strong></td><td>${data.tipo}</td></tr>
                <tr><td class="info_label"><strong>Marca:</strong></td><td>${data.marca}</td></tr>
                <tr><td class="info_label"><strong>Modelo:</strong></td><td>${data.modelo}</td></tr>
                <tr><td class="info_label"><strong>Matrícula:</strong></td><td>${data.matricula}</td></tr>
                <tr><td class="info_label"><strong>Estado:</strong></td><td>${data.estado}</td></tr>
                <tr><td class="info_label"><strong>Titular:</strong></td><td>${data.titular}</td></tr>
                <tr><td class="info_label"><strong>Número de ROMA:</strong></td><td>${data.num_roma}</td></tr>
                <tr><td class="info_label"><strong>Número de REGANIP:</strong></td><td>${data.num_reganip}</td></tr>
                <tr><td class="info_label"><strong>Fecha de adquisición:</strong></td><td>${data.fecha_adquisicion}</td></tr>
                <tr><td class="info_label"><strong>Última inspección:</strong></td><td>${data.ultima_inspeccion}</td></tr>
                <tr><td class="info_label"><strong>Caducidad ITV:</strong></td><td>${data.caducidad_itv}</td></tr>
                <tr><td class="info_label"><strong>Observaciones:</strong></td><td>${data.observaciones}</td></tr>
            `;
                document.getElementById('maquinaria_modal').showModal();
            })
    }

    //Guardar maquinaria
    document.getElementById("maquinaria_form").addEventListener("submit", async function(e) {
        e.preventDefault();
        const mensajeError = document.getElementById("mensaje-error");
        mensajeError.textContent = ""; // Limpiar mensaje de error previo
        const formData = new FormData(this);

        try {
            const respuesta = await fetch("../controllers/maquinariaController.php", {
                method: "POST",
                body: formData
            });

            const resultado = await respuesta.json();

            if (resultado.ok) {
                alert(resultado.mensaje);
                location.reload();
            } else {
                mensajeError.textContent = resultado.mensaje;
                console.error(resultado.mensaje);
            }
        } catch (error) {
            mensajeError.textContent = "Error en la conexión con el servidor. Por favor, inténtalo de nuevo.";
            console.error("Error al guardar la maquinaria:", error);
        }

    });
</script>
<?php
include "../templates/footer.php";
?>