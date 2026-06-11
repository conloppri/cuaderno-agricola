<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../templates/cabecera_explotacion_principal.php';
include '../models/globalModel.php';
include '../controllers/comprobarUsuarioOrg.php';

comprobarUsuarioOrg($connection, $_GET['organizacion_id']); // Comprobar que el usuario tiene permiso para acceder a esta organización

$organizacion = obtenerOrganizacion($connection, $_GET['organizacion_id']);
?>

    <main class="main_content">
        <header>
            <h1>Modificar organización</h1>
        </header>

        <form id="formModificarOrganizacion" class="formularioExp">
            <div class="grupo-form">
                <label for="nombre_organizacion">Nombre de la organización:</label>
                <input type="text" id="nombre_organizacion" name="nombre_organizacion" value="<?php echo htmlspecialchars($organizacion['nombre_organizacion']); ?>" placeholder="Nombre de la organización" required>
            </div>
            <div class="grupo-form">
                <label for="nombre_razon_social">Razón social:</label>
                <input type="text" id="nombre_razon_social" name="nombre_razon_social" value="<?php echo htmlspecialchars($organizacion['nombre_razon_social']); ?>" placeholder="Razón social de la organización" required>
            </div>
            <div class="grupo-form">
                <label for="nif">NIF:</label>
                <input type="text" id="nif" name="nif" value="<?php echo htmlspecialchars($organizacion['nif']); ?>" placeholder="NIF de la organización">
            </div>
            <div class="grupo-form">
                <label for="tlf_movil">Teléfono móvil:</label>
                <input type="text" id="tlf_movil" name="tlf_movil" value="<?php echo htmlspecialchars($organizacion['tlf_movil']); ?>" placeholder="Teléfono móvil de la organización">
            </div>
            <div class="grupo-form">
                <label for="tlf_fijo">Teléfono fijo:</label>
                <input type="text" id="tlf_fijo" name="tlf_fijo" value="<?php echo htmlspecialchars($organizacion['tlf_fijo']); ?>" placeholder="Teléfono fijo de la organización">
            </div>
            <div class="grupo-form">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($organizacion['direccion']); ?>" placeholder="Dirección de la organización">
            </div>
            <div class="grupo-form">
                <label for="correo_electronico">Correo electrónico:</label>
                <input type="email" id="correo_electronico" name="correo_electronico" value="<?php echo htmlspecialchars($organizacion['email']); ?>" placeholder="Correo electrónico de la organización">
            </div>
            <div class="grupo-form">
                <label for="codigo_postal">Código postal:</label>
                <input type="text" id="codigo_postal" name="codigo_postal" value="<?php echo htmlspecialchars($organizacion['cod_postal']); ?>" placeholder="Código postal de la organización">
            </div>
            <div class="grupo-form">
                <label for="provincia">Provincia:</label>
                <select id="provincia" name="provincia" required>
                    <option value="">Selecciona una provincia</option>
                    <?php
                    $provincias = obtenerListaProvincias($connection);
                    foreach ($provincias as $provincia) {
                        $selected = $provincia['provincia_id'] == $organizacion['provincia_id'] ? ' selected' : '';
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
                <input type="text" id="comunidad" name="comunidad" value="<?php echo htmlspecialchars($organizacion['comunidad']); ?>" placeholder="Comunidad de la organización">
            </div>
            <div class="grupo-form">
                <button type="submit" class="btn_agregar_exp">Guardar organización</button>
                <button type="button" id="btnCancelar" class="btn_volver">Cancelar</button>
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
                    selectMunicipio.value = "<?php echo $organizacion['municipio_id']; ?>"; // Seleccionar el municipio actual de la organización
                })
                .catch(error => {
                    console.error('Error al cargar municipios:', error);
                    selectMunicipio.innerHTML = '<option value="">Error al cargar municipios</option>';
                    selectMunicipio.disabled = true;
                });
        });

        // Manejar el envío del formulario
        const organizacionId = "<?php echo intval($organizacion['organizacion_id']); ?>"; // Obtener el ID de la organización desde PHP
        document.getElementById('formModificarOrganizacion').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch(`../controllers/modificarOrganizacionController.php?organizacion_id=${organizacionId}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta del servidor:', data);
                if(data.success) {
                    alert('Organización guardada exitosamente');
                    window.location.href = '../views/organizacionesView.php';
                } else {
                    alert('Error al guardar la organización: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error al guardar la organización:', error);
                alert('Error al guardar la organización');
            });
        });

        // Botón para volver a la vista de explotaciones
        const btnCancelar = document.getElementById('btnCancelar');
        btnCancelar.addEventListener('click', () => {
            window.location.href = 'organizacionesView.php';
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