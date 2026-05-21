<?php
    include '../templates/cabecera_explotacion_principal.php';
    include '../models/globalModel.php';
    include '../controllers/comprobarUsuarioExp.php';

    comprobarUsuarioExp($connection, $_GET['explotacion_id']); // Comprobar que el usuario tiene permiso para acceder a esta explotación

    $explotacion = obtenerExplotacionPorId($connection, $_GET['explotacion_id']);
?>
    <main>
        <header>
            <h1>Modificar explotación</h1>
        </header>

        <form id="formModificarExplotacion" class="formularioExp">
            <div class="grupo-form">
                <label for="nombre">Nombre de la explotación:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($explotacion['nombre']); ?>" placeholder="Nombre de la explotación" required>
            </div>
            <div class="grupo-form">
                <label for="alias">Alias:</label>
                <input type="text" id="alias" name="alias" value="<?php echo htmlspecialchars($explotacion['alias']); ?>" placeholder="Alias de la explotación">
            </div>
            <div class="grupo-form">
                <label for="organizacion">Organización:</label>
                <select id="organizacion" name="organizacion" required>
                    <option value="">Selecciona una organización</option>
                    <?php
                    $organizaciones = obtenerOrganizaciones($connection, $_SESSION['usuario_id']);
                    foreach ($organizaciones as $org) {
                        $selected = $org['organizacion_id'] == $explotacion['organizacion_id'] ? ' selected' : '';
                        echo '<option value="' . $org['organizacion_id'] . '"' . $selected . '>' . htmlspecialchars($org['nombre_organizacion']) . ' (' . htmlspecialchars($org['nif']) . ')</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="grupo-form">
                <label for="provincia">Provincia:</label>
                <select id="provincia" name="provincia" required>
                    <option value="">Selecciona una provincia</option>
                    <?php
                    $provincias = obtenerListaProvincias($connection);
                    foreach ($provincias as $provincia) {
                        $selected = $provincia['provincia_id'] == $explotacion['provincia_id'] ? ' selected' : '';
                        echo '<option value="' . $provincia['provincia_id'] . '"' . $selected . '>' . htmlspecialchars($provincia['nombre']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="grupo-form">
                <label for="municipio">Municipio:</label>
                <select id="municipio" name="municipio" required disabled>
                    <option value="">Selecciona un municipio</option>
                </select>
            </div>
            <div class="grupo-form">
                <label for="comunidad">Comunidad:</label>
                <input type="text" id="comunidad" name="comunidad" value="<?php echo htmlspecialchars($explotacion['comunidad']); ?>" placeholder="Comunidad autónoma" required>
            </div>
            <div class="grupo-form">
                <label for="codigo_rea">Código REA:</label>
                <input type="text" id="codigo_rea" name="codigo_rea" placeholder="Código REA" value="<?php echo htmlspecialchars($explotacion['codigo_rea']); ?>">
            </div>
            <div class="grupo-form">
                <label for="codigo_siex">Código SIEX:</label>
                <input type="text" id="codigo_siex" name="codigo_siex" placeholder="Código SIEX" value="<?php echo htmlspecialchars($explotacion['codigo_siex']); ?>">
            </div>
            <div class="grupo-form">
                <button type="submit" class="btn_guardar_exp">Modificar explotación</button>
                <button type="button" id="btnCancelar">Cancelar</button>
            </div>
        </form>
    </main>

    <dialog id="mensaje-modal" class="ventana-modal">
        <div class="modal-content">
            <p id="mensaje-texto"></p>
            <button id="btnCerrarMensaje">Cerrar</button>
        </div>
    </dialog>

    <script>
        // Cargar municipios al seleccionar una provincia
        document.getElementById('provincia').addEventListener('change', function() {
            const provinciaId = this.value;
            const selectMunicipio = document.getElementById('municipio');

            if(!provinciaId) {
                selectMunicipio.innerHTML = '<option value="">Selecciona un municipio</option>';
                selectMunicipio.disabled = true;
                return;
            }

            fetch(`../controllers/obtenerMunicipios.php?provincia_id=${provinciaId}`)
                .then(response => response.json())
                .then(municipios => {
                    selectMunicipio.innerHTML = '<option value="">Selecciona un municipio</option>';
                    municipios.forEach(municipio => {
                        const option = document.createElement('option');
                        option.value = municipio.id;
                        option.textContent = municipio.nombre;
                        selectMunicipio.appendChild(option);
                    });
                    selectMunicipio.disabled = false;
                    selectMunicipio.value = "<?php echo $explotacion['municipio_id']; ?>"; // Seleccionar el municipio actual de la explotación
                })
                .catch(error => {
                    console.error('Error al cargar municipios:', error);
                    selectMunicipio.innerHTML = '<option value="">Error al cargar municipios</option>';
                    selectMunicipio.disabled = true;
                });
        });

        // Manejar el envío del formulario
        const explotacionId = <?php echo intval($explotacion['explotacion_id']); ?>; // Obtener el ID de la explotación desde PHP
        document.getElementById('formModificarExplotacion').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch(`../controllers/modificarExplotacionController.php?explotacion_id=${explotacionId}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta del servidor:', data);
                if(data.success) {
                    document.getElementById('mensaje-texto').textContent = 'Explotación modificada correctamente.';
                    document.getElementById('mensaje-modal').showModal();
                } else {
                    alert('Error al modificar la explotación: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error al modificar la explotación:', error);
                alert('Error al modificar la explotación');
            });
        });

        // Manejar el clic en el botón de cancelar
        document.getElementById('btnCancelar').addEventListener('click', function() {
            window.location.href = '../views/explotacionesView.php';
        });

        // Cargar municipios al cargar la página si ya hay una provincia seleccionada
        const provinciaSeleccionada = document.getElementById('provincia').value;
        if(provinciaSeleccionada) {
            document.getElementById('provincia').dispatchEvent(new Event('change'));
        }

        // Manejar el cierre del mensaje modal
        const btnCerrarMensaje = document.getElementById('btnCerrarMensaje');
        btnCerrarMensaje.addEventListener('click', () => {
            document.getElementById('mensaje-modal').close();
            window.location.href = '../views/explotacionesView.php';
        });
    </script>

<?php include '../templates/footer.php';?>