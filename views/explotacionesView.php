<?php
include '../controllers/comprobarSesion.php';
include '../controllers/explotacionesController.php';
include '../templates/cabecera_explotacion.php';

$usuarioID = $_SESSION['usuario_id'];
?>

    <main>
        <div class="contenido">
            <h1>Bienvenido, <?php echo $_SESSION['username']; ?>!</h1>
            <p>Gestiona tus explotaciones agrícolas de manera eficiente.</p>
        </div>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>Nombre de la explotación</th>
                        <th>Alias</th>
                        <th>Organización</th>
                        <th>Provincia</th>
                        <th>Municipio</th>
                        <th>Comunidad</th>
                        <th>Código REA</th>
                        <th>Código SIEX</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php $explotaciones = obtenerExplotacionesUsuario($connection, $_SESSION['username']); ?>
                        <?php foreach ($explotaciones as $explotacion): ?>
                        <td><?php echo htmlspecialchars($explotacion['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($explotacion['alias']); ?></td>
                        <td><?php echo htmlspecialchars($explotacion['organizacion']); ?></td>
                        <td><?php echo htmlspecialchars($explotacion['provincia']); ?></td>
                        <td><?php echo htmlspecialchars($explotacion['municipio']); ?></td>
                        <td><?php echo htmlspecialchars($explotacion['comunidad']); ?></td>
                        <td><?php echo htmlspecialchars($explotacion['rea']); ?></td>
                        <td><?php echo htmlspecialchars($explotacion['siex']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
    
<?php include '../templates/footer.php';?>