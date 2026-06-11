<!-- Cabecera -->
<?php include "../templates/cabecera_explotacion.php"; ?>

<!-- Contenido principal -->
<?php

include "../controllers/comprobarUsuarioExp.php";
include "../controllers/globalController.php";
include_once "../controllers/parcelaController.php";
include '../models/rolesUsuariosModel.php';

//Desde la pantalla de explotaciones, se envía el id de la explotación para mostrar solo las parcelas de esa explotación. 

$explotacion_id = $_GET['explotacion_id'];
$nombre_explotacion = obtenerNombreExplotacion($explotacion_id);
comprobarUsuarioExp($connection, $explotacion_id); // Comprobar que el usuario tiene permiso para acceder a esta explotación
$rol = obtenerRolUsuarioEnExplotacion($connection, $_SESSION['usuario_id'], $explotacion_id);

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
        <div class="modal_content">
            <span class="close_button" onclick="document.getElementById('parcela_modal').close();">&times;</span>
            <h2 style="text-align: center;">Nueva parcela</h2>
            <form id="form_parcela" method="POST">
                <div class="grupo-form">
                    <input id = "accionParcela" type="hidden" name="accion" value="crearParcela">
                    <input id = "idExplotacion" type="hidden" name="idExplotacion" value="<?php echo $explotacion_id; ?>">
                    <input id= "parcela_id" type="hidden" name="parcela_id" value="">
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
                    <?php if($rol === 'administrador'):?>
                        <th>Administrar</th>
                    <?php endif ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parcelas as $index => $parcela): 
                    $claseFila = $index % 2 === 0 ? 'tr-odd' : 'tr-even';?>
                    <tr class="<?php echo $claseFila; ?>">
                        <td><?php echo htmlspecialchars($parcela['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($parcela['sigpac']); ?></td>
                        <td><?php echo htmlspecialchars($parcela['provincia']); ?></td>
                        <td><?php echo htmlspecialchars($parcela['municipio']); ?></td>
                        <td><?php echo htmlspecialchars($parcela['superficie'] . ' ha'); ?></td>
                        <td><button class="boton-detalles" type="button" onclick="toggleFila(<?php echo $parcela['id']; ?>)"> <i id="bt-flecha-<?php echo $parcela['id']; ?>" class="ti ti-plus"></i> </button></td>
                        <?php if($rol === 'administrador'):?>
                            <td>
                                <button class="editar_btn" type="button" onclick='modificarParcela(
                                    <?php echo json_encode($parcela["id"]); ?>,
                                    <?php echo json_encode($parcela["nombre"]); ?>,
                                    <?php echo json_encode($parcela["superficie"]); ?>,
                                    <?php echo json_encode($parcela["sigpac"]); ?>
                                )'> <i class="ti ti-pencil"></i> </button>  
                                <button class="eliminar_btn" type="button" onclick='eliminarParcela(<?php echo json_encode($parcela["id"]); ?>)'><i class="ti ti-trash"></i> </button>
                            </td>
                        <?php endif?>
                    </tr>
                    <tr id="fila-<?php echo $parcela['id']; ?>" class="<?php echo $claseFila; ?>" style="display: none;">
                        <td colspan="7" class="celda_detalle">
                            <?php $unidadesGestion = ParcelaController::obtenerInfoUnidadesGestion($parcela['id']); ?>
                            <h3>Unidades de gestión</h3>
                            <?php if(count($unidadesGestion) == 0): ?>
                                <p>No hay unidades de gestión para esta parcela.</p>
                            <?php else: ?>
                                <ul style="list-style-type: none; padding-left: 0;">
                                    <?php foreach($unidadesGestion as $unidad): ?>
                                        <li>
                                            <strong><?php echo htmlspecialchars($unidad['nombre']); ?></strong> - 
                                            Superficie: <?php echo htmlspecialchars($unidad['superficie']. ' ha' ); ?> - 
                                            Uso <?php echo htmlspecialchars($unidad['uso']); ?>
                                            <?php if($rol === 'administrador'):?>
                                                - <button class="editar_btn" type="button" onclick='modificarUnidad(
                                                <?php echo json_encode($unidad["id"]); ?>,
                                                <?php echo json_encode($unidad["nombre"]); ?>,
                                                <?php echo json_encode($unidad["superficie"]); ?>,
                                                <?php echo json_encode($unidad["uso"]); ?>)'> <i class="ti ti-pencil"></i> </button>  
                                                <button class="eliminar_btn" type="button" onclick='eliminarUnidad(<?php echo json_encode($unidad["id"]); ?>)'><i class="ti ti-trash"></i> </button>
                                            <?php endif ?>

                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <button type="button" class="add_button" onclick="abrirFormularioUniGest()">+ Nueva unidad</button>
                            <dialog class="modal_formulario" id="uniGestion_modal">
                                <div class="modal_content">
                                    <span class="close_button" onclick="document.getElementById('uniGestion_modal').close();">&times;</span>
                                    <h2 style="text-align: center;">Nueva unidad de gestión</h2>
                                    <form id="form_uniGestion" method="POST">
                                        <input id="accionUnidad" type="hidden" name="accion" value="crearUniGestion">
                                        <input type="hidden" name="idParcela" value="<?php echo $parcela['id']; ?>">
                                        <input id="uniGes_id" type="hidden" name="uniGes_id" value="">
                                        <input type="hidden" name="parcelaSuperficie" value="<?php echo $parcela['superficie']; ?>">
                                        <div class="grupo-form">
                                            <label for="nombreUnidad">Nombre:</label>
                                            <input id="nombreUnidad" type="text" name="nombreUnidad" maxlength="20" placeholder="Nombre" required>
                                            <label for="superficieUnidad">Superficie (ha):</label>
                                            <input id="superficieUnidad" type="number" step="0.1"  name="superficieUnidad" placeholder="Superficie" required>
                                            <label for="uso">Uso:</label>
                                            <select id="uso"  name="uso" id="uso">
                                                <option value="" selected disabled>Selecciona uso</option>
                                                <option value="agricola">Agrícola</option>
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
        document.getElementById('accionParcela').value = 'crearParcela';
        document.getElementById('parcela_modal').showModal();
    }

    function cerrarFormularioParcela() {
        document.getElementById('parcela_modal').close();
        document.getElementById('form_parcela').reset();
        document.getElementById('accionParcela').value = 'crearParcela';
    }

    function abrirFormularioUniGest() {
        document.getElementById("uniGestion_modal").showModal();
    }

    function cerrarFormularioUniGest() {
        document.getElementById("uniGestion_modal").close();
        document.getElementById('form_uniGestion').reset();
        document.getElementById('accionUnidad').value = 'crearUniGestion';
    }

    function modificarParcela(parcela_id, nombre, superficie, sigpac){
        abrirFormularioParcela();
        document.getElementById('nombreParcela').value = nombre;
        document.getElementById('superficieParcela').value = superficie;
        document.getElementById('sigpac').value = sigpac;
        document.getElementById('accionParcela').value = 'modificarParcela';
        document.getElementById('parcela_id').value = parcela_id;

    }

    async function eliminarParcela(parcela_id){
        let respuesta = confirm("¿Estás seguro de que quieres eliminar este registro?");
        if(respuesta){
            try{
            const formData = new FormData();
            formData.append("accion", "eliminarParcela");
            formData.append("parcela_id", parcela_id);
            const respuesta = await fetch("../controllers/parcelaController.php", {
                method: "POST",
                body: formData,
            });

            const resultado = await respuesta.json();
            if(resultado.ok){
                //Si se ha podido guardar correctamente, recargamos la página para mostrar la nueva unidad de gestión en la tabla
                location.reload();
                alert("Parcela eliminada correctamente."); //Notificación de éxito
            } else {
                alert(resultado.mensaje); // Mostrar mensaje de error devuelto por el servidor
            }
        } catch (error) {
            console.error("Error al eliminar la parcela", error);
            alert("Error con la conexión. Por favor, inténtalo de nuevo."); // Mensaje de error genérico
        }
        }
    }

    function modificarUnidad(unidad_id, nombre, superficie, uso ){
        abrirFormularioUniGest();
        document.getElementById('accionUnidad').value = 'modificarUnidad';
        document.getElementById("uniGes_id").value = unidad_id;
        document.getElementById('nombreUnidad').value = nombre;
        document.getElementById('superficieUnidad').value = superficie;
        document.getElementById('uso').value = uso;
    }

    async function eliminarUnidad(unidad_id){
        let respuesta = confirm("¿Estás seguro de que quieres eliminar este registro?");
        if(respuesta){
            try{
            const formData = new FormData();
            formData.append("accion", "eliminarUnidad");
            formData.append("unidad_id", unidad_id);
            const respuesta = await fetch("../controllers/parcelaController.php", {
                method: "POST",
                body: formData,
            });

            const resultado = await respuesta.json();
            if(resultado.ok){
                //Si se ha podido guardar correctamente, recargamos la página para mostrar la nueva unidad de gestión en la tabla
                location.reload();
                alert("Unidad de gestión eliminada correctamente."); //Notificación de éxito
            } else {
                alert(resultado.mensaje); // Mostrar mensaje de error devuelto por el servidor
            }
        } catch (error) {
            console.error("Error al eliminar la unidad de gestión", error);
            alert("Error con la conexión. Por favor, inténtalo de nuevo."); // Mensaje de error genérico
        }
        }
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