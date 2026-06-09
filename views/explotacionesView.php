<?php
include '../controllers/explotacionesController.php';
include '../templates/cabecera_explotacion_principal.php';
?>
    <main>
        <div class="contenido">
            <div>
                <h1>Bienvenido, <?php echo $_SESSION['username']; ?>!</h1>
                <p>Gestiona tus explotaciones agrícolas de manera eficiente.</p>
            </div>
            <div class="acciones">
                <button type="button" id="btnGestionarOrg" class="btn_gestionar_org">Gestionar Organizaciones</button>
                <button type="button" id="btnAddExp" class="btn_agregar_exp">+ Añadir explotación</button>
            </div>
        </div>

        <div class="table_exp">
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
                        <th>Componentes y cuaderno de campo</th>
                        <th>Acciones</th>
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
                        <td><?php echo htmlspecialchars($explotacion['codigo_rea']); ?></td>
                        <td><?php echo htmlspecialchars($explotacion['codigo_siex']); ?></td>
                        <td><button class="btnAccederExp" data-id="<?php echo $explotacion['explotacion_id']; ?>">Acceder</button></td>
                        <td>
                            <?php if ($explotacion['rol'] === 'administrador'): // Solo el administrador puede modificar o eliminar ?>
                                <button class="btnModificarExp" data-id="<?php echo $explotacion['explotacion_id']; ?>">Modificar</button>
                                <button class="btnEliminarExp" data-id="<?php echo $explotacion['explotacion_id']; ?>">Eliminar</button>
                            <?php else: ?>
                                <span>Sin acciones</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        // Botón para añadir nueva explotación
        const btnAddExp = document.getElementById('btnAddExp');
        btnAddExp.addEventListener('click', () => {
            window.location.href = '../views/nuevaExplotacion.php';
        });

        // Botón para acceder a una explotación
        const btnAccederExp = document.querySelectorAll('.btnAccederExp');
        btnAccederExp.forEach(button => {
            button.addEventListener('click', () => {
                const explotacionId = button.getAttribute('data-id');
                window.location.href = `../views/parcelasView.php?explotacion_id=${explotacionId}`;
            });
        });

        // Botón para modificar una explotación
        const btnModificarExp = document.querySelectorAll('.btnModificarExp');
        btnModificarExp.forEach(button => {
            button.addEventListener('click', () => {
                const explotacionId = button.getAttribute('data-id');
                window.location.href = `../views/modificarExplotacion.php?explotacion_id=${explotacionId}`;
            });
        });

        // Botón para eliminar una explotación
        const btnEliminarExp = document.querySelectorAll('.btnEliminarExp');
        btnEliminarExp.forEach(button => {
            button.addEventListener('click', () => {
                const explotacionId = button.getAttribute('data-id');
                if (confirm('¿Estás seguro de que quieres eliminar esta explotación?')) {
                    fetch(`../controllers/eliminarExplotacionController.php?explotacion_id=${explotacionId}`)
                        .then(response => response.text())
                        .then(data => {
                            alert('Explotación eliminada correctamente.');
                            location.reload(); // Recargar la página para reflejar los cambios
                        })
                        .catch(error => {
                            console.error('Error al eliminar la explotación:', error);
                            alert('Hubo un error al eliminar la explotación. Por favor, inténtalo de nuevo.');
                        });
                }
            });
        });

        // Botón para gestionar organizaciones
        const btnGestionarOrg = document.getElementById('btnGestionarOrg');
        btnGestionarOrg.addEventListener('click', () => {
            window.location.href = '../views/organizacionesView.php';
        });
    </script>

<?php include '../templates/footer.php';?>