<?php include '../templates/cabecera_explotacion.php';?>

<?php include '../config/db.php';
include '../controllers/personalController.php';

$idExplotacion = $_POST['idExplotacion'] ?? 1; // ID de explotación para pruebas
$infoPersonal = obtenerInfoPersonal($connection, $idExplotacion);
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
            <div class="grupo-form">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" required>
                <label for="telefono">Teléfono:</label>
                <input type="tel" pattern="[0-9]" inputmode="numeric" maxlength="9" id="telefono" name="telefono" placeholder="Número de teléfono" required>
                <label for="correo">Email:</label>
                <input type="email" id="email" name="correo" placeholder="Email" required>
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" placeholder="Dirección" required>
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
                <input type="text" id="nacionalidad" name="nacionalidad" placeholder="Nacionalidad" required>
                <label for="rol">Rol:</label>
                <select name="rol" id="rol">
                    <option value="" selected disabled>Selecciona rol</option>
                    <option value="propietario">Propietario</option>
                    <option value="tecnico">Técnico</option>
                    <option value="trabajador">Trabajador</option>
                    <option value="administrativo">Administrativo</option>
                </select>
            </div>
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

</script>

<?php
include '../templates/footer.php';
?>