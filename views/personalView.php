<?php include '../templates/cabecera_explotacion.php';?>

<?php include '../config/db.php';

$idExplotacion = $_GET['explotacion_id']; // Obtener el ID de la explotación de la URL
include_once '../controllers/personalController.php';
$infoPersonal = PersonalController::obtenerInfoPersonal($connection, $idExplotacion);
?>

<main class="main_content">
    <div class="cabecera_parcelas">
        <h1>Personal</h1>
        <button class="add_button" onclick="abrirFormulario()">+ Agregar Personal</button>
    </div>
    <div class="table_exp">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Teléfono</th>
                    <th>Correo electrónico</th>
                    <th>Dirección</th>
                    <th>Provincia</th>
                    <th>Municipio</th>
                    <th>Nacionalidad</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se mostrarán los datos del personal -->
                    <?php foreach ($infoPersonal as $personal): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($personal['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($personal['dni']); ?></td>
                        <td><?php echo htmlspecialchars($personal['telefono']); ?></td>
                        <td><?php echo htmlspecialchars($personal['correo_electronico']); ?></td>
                        <td><?php echo htmlspecialchars($personal['direccion']); ?></td>
                        <td><?php echo htmlspecialchars($personal['provincia']); ?></td>
                        <td><?php echo htmlspecialchars($personal['municipio']); ?></td>
                        <td><?php echo htmlspecialchars($personal['nacionalidad']); ?></td>
                        <td><?php echo htmlspecialchars($personal['rol']); ?></td>
                    </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<dialog id="personal_modal" class="modal_formulario">
    <div class="modal_content">
        <h2 style="text-align: center;">Agregar Personal</h2>
        <form id="personal-form">
            <input type="hidden" name="idExplotacion" value="<?php echo $idExplotacion; ?>">
            <input type="hidden" name="accion" value="crearPersonal">
            <div class="grupo-form">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" maxlength="45" placeholder="Nombre" required>
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" maxlength="45" placeholder="Apellidos" required>
                <label for="dni">DNI:</label>
                <input type="text" id="dni" name="dni" maxlength="9" placeholder="DNI" required>
                <label for="telefono">Teléfono:</label>
                <input type="text" inputmode="numeric" maxlength="15" id="telefono" name="telefono" placeholder="Número de teléfono" required>
                <label for="correo">Email:</label>
                <input type="email" id="email" name="correo" maxlength="45" placeholder="Email" required>
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" maxlength="45" placeholder="Dirección" required>
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
                <label for="nacionalidad">Nacionalidad:</label>
                <input type="text" id="nacionalidad" name="nacionalidad" maxlength="45" placeholder="Nacionalidad" required>
                <label for="rol">Rol:</label>
                <select name="rol" id="rol">
                    <option value="" selected disabled>Selecciona rol</option>
                    <option value="propietario">Propietario</option>
                    <option value="tecnico">Técnico</option>
                    <option value="trabajador">Trabajador</option>
                    <option value="administrativo">Administrativo</option>
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
    function abrirFormulario() {
        document.getElementById('personal_modal').showModal();
    }

    function cerrarFormulario() {
        document.getElementById('personal_modal').close();
    }

    //Limitar input teléfono a números y máximo 9 dígitos
    const telefono = document.getElementById("telefono");
    telefono.addEventListener("input", function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 9);
    });

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

    //Guardar personal
    document.getElementById("personal-form").addEventListener("submit", async function(e) {
        e.preventDefault();
        const mensajeError = document.getElementById("mensaje-error");
        mensajeError.textContent = ""; // Limpiar mensaje de error previo
        const formData = new FormData(this);
        try{
            console.log("enviando datos...");
            const respuesta = await fetch("../controllers/personalController.php", {
                method: "POST",
                body: formData
            });

            const resultado = await respuesta.json();
            
            if(resultado.ok){ 
                alert(resultado.mensaje);
                location.reload();
            } else {
                mensajeError.textContent = resultado.mensaje;
                console.error(resultado.mensaje);
            }
        } catch (error) {
            mensajeError.textContent = "Error en la conexión con el servidor. Por favor, inténtalo de nuevo.";
            console.error("Error al guardar el personal:", error);
        }
    
    });

</script>

<?php
include '../templates/footer.php';
?>