<?php
include "../templates/cabecera_explotacion_simple.php";
include '../controllers/gestUsuariosExplController.php';

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

<?php include "../templates/footer.php";?>