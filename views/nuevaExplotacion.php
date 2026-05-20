<?php
    include '../templates/cabecera_explotacion_principal.php';
    include '../models/globalModel.php';
?>
    <main>
        <header>
            <h1>Añadir nueva explotación</h1>
        </header>

        <form id="formNuevaExplotacion" class="formularioExp">
            <div class="grupo-form">
                <label for="nombre">Nombre de la explotación:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre de la explotación" required>
            </div>
            <div class="grupo-form">
                <label for="alias">Alias:</label>
                <input type="text" id="alias" name="alias" placeholder="Alias de la explotación">
            </div>
            <div class="grupo-form">
                <label for="organizacion">Organización:</label>
                <select id="organizacion" name="organizacion" required>
                    <option value="">Selecciona una organización</option>
                    <?php
                    $organizaciones = obtenerOrganizaciones($connection, $_SESSION['usuario_id']);
                    foreach ($organizaciones as $org) {
                        echo '<option value="' . $org['organizacion_id'] . '">' . htmlspecialchars($org['nombre_organizacion']) . ' (' . htmlspecialchars($org['nif']) . ')</option>';
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
                        echo '<option value="' . $provincia['provincia_id'] . '">' . htmlspecialchars($provincia['nombre']) . '</option>';
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
                <input type="text" id="comunidad" name="comunidad" placeholder="Comunidad autónoma" required>
            </div>
            <div class="grupo-form">
                <label for="codigo_rea">Código REA:</label>
                <input type="text" id="codigo_rea" name="codigo_rea" placeholder="Código REA">
            </div>
            <div class="grupo-form">
                <label for="codigo_siex">Código SIEX:</label>
                <input type="text" id="codigo_siex" name="codigo_siex" placeholder="Código SIEX">
            </div>
            <div class="grupo-form">
                <button type="submit" class="btn_guardar_exp">Guardar explotación</button>
                <button type="button" id="btnCancelar">Cancelar</button>
            </div>
        </form>

    </main>

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
                })
                .catch(error => {
                    console.error('Error al cargar municipios:', error);
                    selectMunicipio.innerHTML = '<option value="">Error al cargar municipios</option>';
                    selectMunicipio.disabled = true;
                });
        });

        // Manejar el envío del formulario
        document.getElementById('formNuevaExplotacion').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('../controllers/guardarExplotacion.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta del servidor:', data);
                if(data.success) {
                    alert('Explotación guardada exitosamente');
                    window.location.href = '../views/explotacionesView.php';
                } else {
                    alert('Error al guardar la explotación: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error al guardar la explotación:', error);
                alert('Error al guardar la explotación');
            });
        });

        // Manejar el clic en el botón de cancelar
        document.getElementById('btnCancelar').addEventListener('click', function() {
            window.location.href = '../views/explotacionesView.php';
        });
    </script>

<?php include '../templates/footer.php';?>