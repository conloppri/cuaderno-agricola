<?php include '../templates/cabecera_explotacion.php'; ?>

<?php include '../config/db.php';
include '../controllers/globalController.php';
include '../models/rolesUsuariosModel.php';
include_once '../controllers/personalController.php';

$idExplotacion = $_GET['explotacion_id']; // Obtener el ID de la explotación de la URL
$nombre_explotacion = obtenerNombreExplotacion($idExplotacion);

$rol = obtenerRolUsuarioEnExplotacion($connection, $_SESSION['usuario_id'], $idExplotacion);


$infoPersonal = PersonalController::obtenerInfoPersonal($connection, $idExplotacion);
?>

<main class="main_content">
    <div class="cabecera_main">
        <h1><?php echo $nombre_explotacion ?></h1>
        <i class="ti ti-users"></i>
        <h2 class="titulo_principal">Personal</h2>
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
                    <?php if ($rol === 'administrador'): ?>
                        <th>Administrar</th>
                    <?php endif ?>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se mostrarán los datos del personal -->
                <?php foreach ($infoPersonal as $personal): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($personal['nombre']. ' ' .$personal['apellidos']); ?></td>
                        <td><?php echo htmlspecialchars($personal['dni']); ?></td>
                        <td><?php echo htmlspecialchars($personal['telefono']); ?></td>
                        <td><?php echo htmlspecialchars($personal['correo_electronico']); ?></td>
                        <td><?php echo htmlspecialchars($personal['direccion']); ?></td>
                        <td><?php echo htmlspecialchars($personal['provincia']); ?></td>
                        <td><?php echo htmlspecialchars($personal['municipio']); ?></td>
                        <td><?php echo htmlspecialchars($personal['nacionalidad']); ?></td>
                        <td><?php echo htmlspecialchars($personal['rol']); ?></td>
                        <?php if ($rol === 'administrador'): ?>
                            <td>
                                <button class="editar_btn" type="button" onclick='modificarPersonal(
                                        <?php echo json_encode($personal["id"]); ?>,
                                        <?php echo json_encode($personal["nombre"]); ?>,
                                        <?php echo json_encode($personal["apellidos"]); ?>,
                                        <?php echo json_encode($personal["dni"]); ?>,
                                        <?php echo json_encode($personal["telefono"]); ?>,
                                        <?php echo json_encode($personal["correo_electronico"]); ?>,
                                        <?php echo json_encode($personal["direccion"]); ?>,
                                        <?php echo json_encode($personal["provincia_id"]); ?>,
                                        <?php echo json_encode($personal["municipio_id"]); ?>,
                                        <?php echo json_encode($personal["nacionalidad"]); ?>,
                                        <?php echo json_encode($personal["rol"]); ?>
                                    )'> <i class="ti ti-pencil"></i> </button>
                                <button class="eliminar_btn" type="button" onclick='eliminarPersonal(<?php echo json_encode($personal["id"]); ?>)'><i class="ti ti-trash"></i> </button>
                            </td>
                        <?php endif ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="fab-container">
        <?php if (obtenerRolUsuarioEnExplotacion($connection, $_SESSION['usuario_id'], $idExplotacion) === 'administrador') {
            echo '<div class="fab-container fab-usuario-container">
                    <span class="fab-etiqueta">Agregar usuario</span>
                    <button class="fab" onclick="abrirUsuario()">+</button>
                </div>';
        } ?>
        <div>
            <span class="fab-etiqueta">Agregar personal</span>
            <button class="fab" onclick="abrirFormulario()">+</button>
        </div>
    </div>
</main>

<dialog id="personal_modal" class="modal_formulario">
    <div class="modal_content">
        <span class="close_button" onclick="document.getElementById('personal_modal').close();">&times;</span>
        <h2 style="text-align: center;">Agregar Personal</h2>
        <form id="personal-form">
            <input type="hidden" name="idExplotacion" value="<?php echo $idExplotacion; ?>">
            <input id="accionPersonal" type="hidden" name="accion" value="crearPersonal">
            <input id="personal_id" type="hidden" name="personal_id" value="">
            <div class="grupo-form">
                <label for="nombre">Nombre:</label>
                <input id="nombrePersonal" type="text" id="nombre" name="nombre" maxlength="45" placeholder="Nombre" required>
                <label for="apellidos">Apellidos:</label>
                <input id="apellidosPersonal" type="text" id="apellidos" name="apellidos" maxlength="45" placeholder="Apellidos" required>
                <label for="dni">DNI:</label>
                <input id="dniPersonal" type="text" id="dni" name="dni" maxlength="9" placeholder="DNI" required>
                <label for="telefono">Teléfono:</label>
                <input id="telefonoPersonal" type="text" inputmode="numeric" maxlength="15" id="telefono" name="telefono" placeholder="Número de teléfono" required>
                <label for="correo">Email:</label>
                <input id="correoPersonal" type="email" id="email" name="correo" maxlength="45" placeholder="Email" required>
                <label for="direccion">Dirección:</label>
                <input id="direccionPersonal" type="text" id="direccion" name="direccion" maxlength="45" placeholder="Dirección" required>
                <label for="provincia">Provincia:</label>
                <select id="provinciaPersonal" name="provincia">
                    <option value="" selected disabled>Selecciona provincia</option>
                    <?php
                    $provincias = obtenerProvincias($connection);
                    foreach ($provincias as $provincia) {
                        echo "<option value='" . $provincia['provincia_id'] . "'>" . htmlspecialchars($provincia['nombre']) . "</option>";
                    }
                    ?>
                </select>
                <label for="municipio">Municipio:</label>
                <select id="municipioPersonal" name="municipio">
                    <option value="" selected disabled>Selecciona municipio</option>
                </select>
                <label for="nacionalidad">Nacionalidad:</label>
                <input id="nacionalidadPersonal" type="text" id="nacionalidad" name="nacionalidad" maxlength="45" placeholder="Nacionalidad" required>
                <label for="rol">Rol:</label>
                <select id="rolPersonal" name="rol" id="rol">
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

<dialog id="addUsuario_modal" class="modal_formulario">
    <div class="modal_content">
        <h2 style="text-align: center;">Agregar Usuario</h2>
        <form id="usuario-form">
            <div class="grupo-form">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" maxlength="45" placeholder="Email" required>
            </div>
            <div class="grupo-form">
                <label for="rol">Rol:</label>
                <select name="rol" id="rol">
                    <option value="" selected disabled>Selecciona rol</option>
                    <option value="administrador">Administrador</option>
                    <option value="propietario">Propietario</option>
                    <option value="tecnico">Técnico</option>
                    <option value="trabajador">Trabajador</option>
                    <option value="administrativo">Administrativo</option>
                    <option value="mecanico">Mecánico</option>
                </select>
            </div>
            <div>
                <p id="mensaje-error-usuario" style="color: red; text-align: center;"></p>
            </div>
            <div style="display: flex; justify-content: space-around; margin-top: 20px;">
                <button type="submit" class="add_button">Guardar</button>
                <button type="button" class="cancel_button" onclick="cerrarUsuario()">Cancelar</button>
            </div>
            <div style="display: flex; justify-content: center; margin-top: 20px;">
                <button type="button" class="gestionar_usuarios_button">Gestionar usuarios</button>
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
        document.getElementById('personal-form').reset();
        document.getElementById('accionPersonal').value = 'crearPersonal';
    }

    function abrirUsuario() {
        document.getElementById('usuario-form').reset();
        document.getElementById("mensaje-error-usuario").textContent = "";
        document.getElementById('addUsuario_modal').showModal();
    }

    function cerrarUsuario() {
        document.getElementById('addUsuario_modal').close();
        document.getElementById("mensaje-error-usuario").textContent = "";
        document.getElementById('usuario-form').reset();
    }

    function listarMunicipiosPorProvincia(provincia_id){
        fetch("../controllers/obtenerMunicipios.php?provincia_id=" + provincia_id)
            .then(res => res.json())
            .then(data => {
                const selectMunicipio = document.getElementById("municipioPersonal");
                
                data.forEach(m => {
                    selectMunicipio.innerHTML += `<option value="${m.id}">${m.nombre}</option>`;
                });
            });
    }

    function modificarPersonal(personal_id, nombre, apellidos, dni, telefono, correo, direccion, provincia, municipio, nacionalidad, rol) {
        abrirFormulario();
        document.getElementById('accionPersonal').value = 'modificarPersonal';
        document.getElementById('personal_id').value = personal_id;
        document.getElementById('nombrePersonal').value = nombre;
        document.getElementById('apellidosPersonal').value = apellidos;
        document.getElementById('dniPersonal').value = dni;
        document.getElementById('telefonoPersonal').value = telefono;
        document.getElementById('correoPersonal').value = correo;
        document.getElementById('direccionPersonal').value = direccion;
        document.getElementById('provinciaPersonal').value = provincia;
        listarMunicipiosPorProvincia(provincia);
        document.getElementById('municipioPersonal').value = municipio;
        document.getElementById('nacionalidadPersonal').value = nacionalidad;
        document.getElementById('rolPersonal').value = rol;
    }

    async function eliminarPersonal(personal_id){
        let respuesta = confirm("¿Estás seguro de que quieres eliminar este registro?");
        if(respuesta){
            try{
            const formData = new FormData();
            formData.append("accion", "eliminarPersonal");
            formData.append("personal_id", personal_id);
            const respuesta = await fetch("../controllers/personalController.php", {
                method: "POST",
                body: formData,
            });

            const resultado = await respuesta.json();
            if(resultado.ok){
                //Si se ha podido guardar correctamente, recargamos la página para mostrar la nueva unidad de gestión en la tabla
                location.reload();
                alert("Personal eliminado correctamente."); //Notificación de éxito
            } else {
                alert(resultado.mensaje); // Mostrar mensaje de error devuelto por el servidor
            }
        } catch (error) {
            console.error("Error al eliminar el personal", error);
            alert("Error con la conexión. Por favor, inténtalo de nuevo."); // Mensaje de error genérico
        }
        }
    }

    document.querySelector(".gestionar_usuarios_button").addEventListener("click", function() {
        window.location.href = "gestUsuariosExplotacion.php?explotacion_id=<?php echo $idExplotacion; ?>";
    });

    //Limitar input teléfono a números y máximo 9 dígitos
    const telefono = document.getElementById("telefonoPersonal");
    telefono.addEventListener("input", function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 9);
    });

    //Municipios por provincia
    document.getElementById("provinciaPersonal").addEventListener("change", function() {
        const provinciaId = this.value;
        listarMunicipiosPorProvincia(provinciaId);
        
    });


    //Guardar personal
    document.getElementById("personal-form").addEventListener("submit", async function(e) {
        e.preventDefault();
        const mensajeError = document.getElementById("mensaje-error");
        mensajeError.textContent = ""; // Limpiar mensaje de error previo
        const formData = new FormData(this);
        try {
            console.log("enviando datos...");
            const respuesta = await fetch("../controllers/personalController.php", {
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
            console.error("Error al guardar el personal:", error);
        }

    });

    // Añadir usuario a explotación
    document.getElementById("usuario-form").addEventListener("submit", function(e) {
        e.preventDefault();

        <?php if (obtenerRolUsuarioEnExplotacion($connection, $_SESSION['usuario_id'], $idExplotacion) !== 'administrador') { ?>
            alert("No tienes permisos para agregar usuarios a esta explotación.");
            cerrarUsuario();
            return;
        <?php } ?>

        const mensajeErrorUsuario = document.getElementById("mensaje-error-usuario");
        const formData = new FormData(this);

        fetch("../controllers/addUsuarioExp.php?explotacion_id=<?php echo $idExplotacion; ?>", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    cerrarUsuario();
                } else {
                    mensajeErrorUsuario.textContent = data.message;
                    console.error(data.message);
                }
            })
            .catch(error => {
                mensajeErrorUsuario.textContent = "Error en la conexión con el servidor. Por favor, inténtalo de nuevo.";
                console.error("Error al agregar usuario:", error);
            });
    });
</script>

<?php
include '../templates/footer.php';
?>