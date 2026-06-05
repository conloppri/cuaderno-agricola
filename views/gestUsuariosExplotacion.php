<?php
session_start();

include "../templates/cabecera_explotacion_simple.php";
include '../controllers/gestUsuariosExplController.php';

if(obtenerRolUsuarioEnExplotacion($connection, $_SESSION['usuario_id'], $_GET['explotacion_id']) !== 'administrador') {
    header("Location: ../views/sinPermiso.php");
    exit();
}

$explotacionId = $_GET['explotacion_id'] ?? null;
$explotacion = getExplotacionById($connection, $explotacionId);
$roles = getRolesExplotacion($connection, $explotacionId);
?>
    <main>
        <div class="contenido">
            <h1>Gestión de usuarios de la explotación: <?php echo $explotacion['nombre']; ?></h1>
            <p>Aquí puedes gestionar los usuarios asociados a esta explotación.</p>
        </div>
        <div class="table_exp">
            <h2>Usuarios asociados</h2>
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roles as $rol): ?>
                        <tr>
                            <td><?php echo $rol['email']; ?></td>
                            <td><?php echo $rol['rol']; ?></td>
                            <td>
                                <button class="btnModificarUsuario" data-email="<?php echo $rol['email']; ?>" data-usuario-id="<?php echo $rol['usuario_id']; ?>">Modificar</button>
                                <button class="btnEliminarUsuario" data-email="<?php echo $rol['email']; ?>" data-usuario-id="<?php echo $rol['usuario_id']; ?>">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <dialog id="modificarUsuario_modal">
        <form id="modificarUsuario_form" method="dialog">
            <h2>Modificar rol de usuario</h2>
            <input type="hidden" id="usuarioIdRol" name="usuarioIdRol">
            <select id="nuevoRol" name="nuevoRol" required>
                <option value="administrador">Administrador</option>
                <option value="propietario">Propietario</option>
                <option value="tecnico">Técnico</option>
                <option value="trabajador">Trabajador</option>
                <option value="administrativo">Administrativo</option>
                <option value="mecanico">Mecánico</option>
            </select>
            <button type="submit">Aceptar</button>
            <button type="button" id="cancelarModificarUsuario">Cancelar</button>
        </form>
    </dialog>

    <script>
        
        const btnEliminarUsuario = document.querySelectorAll(".btnEliminarUsuario");
        const btnModificarUsuario = document.querySelectorAll(".btnModificarUsuario");
        const cancelarModificarUsuario = document.getElementById("cancelarModificarUsuario");

        btnEliminarUsuario.forEach(button => {
            button.addEventListener("click", function() {
                const email = this.getAttribute("data-email");
                const usuarioId = this.getAttribute("data-usuario-id");

                if (confirm(`¿Estás seguro de que deseas eliminar al usuario con email ${email} de esta explotación?`)) {
                    fetch(`../controllers/eliminarUsuarioExp.php?explotacion_id=<?php echo $explotacionId; ?>&usuario_id=${usuarioId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            location.reload();
                        } else {
                            alert("Error al eliminar el usuario: " + data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error al eliminar el usuario:", error);
                        alert("Error en la conexión con el servidor. Por favor, inténtalo de nuevo.");
                    });
                }
            });
        });

        btnModificarUsuario.forEach(button => {
            button.addEventListener("click", function() {
                const email = this.getAttribute("data-email");
                const usuarioId = this.getAttribute("data-usuario-id");
                const modal = document.getElementById("modificarUsuario_modal");

                fetch(`../controllers/obtenerRolUsuarioExp.php?usuario_id=${usuarioId}&explotacion_id=<?php echo $explotacionId; ?>`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById("nuevoRol").value = data.rol;
                        document.getElementById("usuarioIdRol").value = usuarioId;
                        modal.showModal();
                    } else {
                        alert("Error al obtener el rol: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Error al obtener el rol:", error);
                    alert("Error en la conexión con el servidor. Por favor, inténtalo de nuevo.");
                });
            });
        });

        cancelarModificarUsuario.addEventListener("click", function() {
            document.getElementById("modificarUsuario_modal").close();
        });

        document.getElementById("modificarUsuario_form").addEventListener("submit", function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch(`../controllers/modificarRolUsuarioExp.php?explotacion_id=<?php echo $explotacionId; ?>`, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        alert("Error al modificar el rol: " + data.message);
                    }
                }
            })
            .catch(error => {
                console.error("Error al modificar el rol:", error);
                alert("Error en la conexión con el servidor. Por favor, inténtalo de nuevo.");
            });
        });

    </script>

<?php include "../templates/footer.php";?>