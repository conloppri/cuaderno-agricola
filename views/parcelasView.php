<!-- Cabecera -->
<?php include "../templates/cabecera_explotacion.php"; ?>

<!-- Contenido principal -->
<?php

include "../controllers/comprobarUsuarioExp.php";
include "../controllers/globalController.php";

//Desde la pantalla de explotaciones, se envía el id de la explotación para mostrar solo las parcelas de esa explotación. 

$explotacion_id = $_GET['explotacion_id'];
$nombre_explotacion = obtenerNombreExplotacion($explotacion_id);
comprobarUsuarioExp($connection, $explotacion_id); // Comprobar que el usuario tiene permiso para acceder a esta explotación
include_once "../controllers/parcelaController.php";
$parcelas = ParcelaController::obtenerInfoParcelas($connection, $explotacion_id);
?>
<div class="main_content">
    <div class="cabecera_main">
        <h1><?php echo $nombre_explotacion ?></h1>
        <i class="ti ti-fence"></i>
        <h2 class="titulo_principal">Parcelas y unidades de gestión</h2>
    </div>

    <!-- Formulario para añadir nueva parcela -->
    <dialog id="parcela_modal" class= "modal_formulario">
        <div>
            <h2 style="text-align: center;">Nueva parcela</h2>
            <form id="form_parcela" method="POST">
                <div class="grupo-form">
                    <input id = "accionParcela" type="hidden" name="accion" value="crearParcela">
                    <input id = "idExplotacion" type="hidden" name="idExplotacion" value="<?php echo $explotacion_id; ?>">
                    <label for="nombreParcela">Nombre:</label>
                    <input id = "nombreParcela" type="text" name="nombreParcela" placeholder="Nombre" maxlength="20" required>
                    <label for="superficieParcela">Superficie (ha):</label>
                    <input id = "superficieParcela" type="number" step="0.1" name="superficieParcela" placeholder="Superficie" required>
                    <label for="sigpac">SIGPAC:</label>
                    <input id = "sigpac" type="text" name="sigpac" placeholder="SIGPAC" maxlength="22" required>
                </div>
                <p id="mensaje_error" style="color: red;"></p>
                <div style="display: flex; justify-content: space-around; margin-top: 20px;">
                    <button  class="cancel_button" type="button" onclick="cerrarFormularioParcela()">Cancelar</button>
                    <button class="add_button" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </dialog>


    <div class="table_exp_parcelas">
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
                <?php foreach ($parcelas as $index => $parcela): 
                    $claseFila = $index % 2 === 0 ? 'tr-odd' : 'tr-even'; ?>
                    <tr class="<?php echo $claseFila; ?>">
                        <td><?php echo htmlspecialchars($parcela['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($parcela['sigpac']); ?></td>
                        <td><?php echo htmlspecialchars($parcela['provincia']); ?></td>
                        <td><?php echo htmlspecialchars($parcela['municipio']); ?></td>
                        <td><?php echo htmlspecialchars($parcela['superficie'] . ' ha'); ?></td>
                        <td><button class="boton-detalles" type="button" onclick="toggleFila(<?php echo $parcela['id']; ?>)"> <i id="bt-flecha-<?php echo $parcela['id']; ?>" class="ti ti-plus"></i> </button></td>
                    </tr>
                    <tr id="fila-<?php echo $parcela['id']; ?>" class="<?php echo $claseFila; ?>" style="display: none;">
                        <td colspan="6" class="celda_detalle">
                            <?php $unidadesGestion = ParcelaController::obtenerInfoUnidadesGestion($connection, $parcela['id']); ?>
                            <h3>Unidades de gestión</h3>
                            <?php if(count($unidadesGestion) == 0): ?>
                                <p>No hay unidades de gestión para esta parcela.</p>
                            <?php else: ?>
                                <ul style="list-style-type: none; padding-left: 0;">
                                    <?php foreach($unidadesGestion as $unidad): ?>
                                        <li>
                                            <strong><?php echo htmlspecialchars($unidad['nombre']); ?></strong> - 
                                            Superficie: <?php echo htmlspecialchars($unidad['superficie'] ); ?> - 
                                            Uso <?php echo htmlspecialchars($unidad['uso']); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <button type="button" class="add_button" onclick="abrirFormularioUniGest()">+ Nueva unidad</button>
                            <dialog class="modal_formulario" id="uniGestion_modal">
                                <div>
                                    <h2 style="text-align: center;">Nueva unidad de gestión</h2>
                                    <form id="form_uniGestion" method="POST">
                                        <input type="hidden" name="accion" value="crearUniGestion">
                                        <input type="hidden" name="idParcela" value="<?php echo $parcela['id']; ?>">
                                        <input type="hidden" name="parcelaSuperficie" value="<?php echo $parcela['superficie']; ?>">
                                        <div class="grupo-form">
                                            <label for="nombreUnidad">Nombre:</label>
                                            <input type="text" name="nombreUnidad" maxlength="20" placeholder="Nombre" required>
                                            <label for="superficieUnidad">Superficie (ha):</label>
                                            <input type="number" step="0.1"  name="superficieUnidad" placeholder="Superficie" required>
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
                                        <p id="mensaje_error_uniGest" style="color: red;"></p>
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
    <div class="fab-container">
        <span class="fab-etiqueta">Agregar parcela</span>
        <button class="fab" onclick="abrirFormularioParcela()">+</button>
    </div>
</div>
<script>
    //Función para que aparezcan las unidades de gestión ocmo una fila extra de tabla
    function toggleFila(id) {
        var fila = document.getElementById("fila-" + id);
        var bt_flecha = document.getElementById("bt-flecha-"+id);
        if (fila.style.display === "none") {
            fila.style.display = "table-row";
            bt_flecha.classList.replace("ti-plus", "ti-minus");

        } else {
            fila.style.display = "none";
            bt_flecha.classList.replace("ti-minus", "ti-plus");
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
    /*
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
    */

    //Guardar parcela
    document.getElementById("form_parcela").addEventListener("submit", async function(event) {
        event.preventDefault(); // Evitar el envío tradicional del formulario
        const mensajeError = document.getElementById("mensaje_error");
        mensajeError.textContent = ""; // Limpiar mensaje de error previo

        const formData = new FormData(event.target); // Obtener los datos del formulario
        
        try{
            const respuesta = await fetch("../controllers/parcelaController.php", {
                method: "POST",
                body: formData,
            });
            
            const resultado = await respuesta.json();
            if(resultado.ok){
                //Si se ha podido guardar correctamente, recargamos la página para mostrar la nueva parcela en la tabla
                location.reload();
                alert("Parcela guardada correctamente"); //
            } else {
                mensajeError.textContent = resultado.mensaje; // Mostrar mensaje de error devuelto por el servidor
            }
        } catch (error) {
            console.error("Error al guardar la parcela:", error);
            mensajeError.textContent = "Error con la conexión. Por favor, inténtalo de nuevo."; // Mensaje de error genérico
        }
        
    });

    //Guardar unidad de gestión
    document.getElementById("form_uniGestion").addEventListener("submit", async function(event) {
        event.preventDefault(); // Evitar el envío tradicional del formulario
        const mensajeError = document.getElementById("mensaje_error_uniGest");
        mensajeError.textContent = ""; // Limpiar mensaje de error previo

        const formData = new FormData(event.target); // Obtener los datos del formulario

        try{
            const respuesta = await fetch("../controllers/parcelaController.php", {
                method: "POST",
                body: formData,
            });

            const resultado = await respuesta.json();
            if(resultado.ok){
                //Si se ha podido guardar correctamente, recargamos la página para mostrar la nueva unidad de gestión en la tabla
                location.reload();
                alert("Unidad de gestión guardada correctamente"); //Notificación de éxito
            } else {
                mensajeError.textContent = resultado.mensaje; // Mostrar mensaje de error devuelto por el servidor
            }
        } catch (error) {
            console.error("Error al guardar la unidad de gestión:", error);
            mensajeError.textContent = "Error con la conexión. Por favor, inténtalo de nuevo."; // Mensaje de error genérico
        }
    });
</script>
<!-- Pie de página -->
<?php include "../templates/footer.php"; ?>