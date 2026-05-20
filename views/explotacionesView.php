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
            <button type="button" id="btnAddExp" class="btn_agregar_exp">+ Añadir explotación</button>
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
                        <th>Cuaderno de campo</th>
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
                        <td><a href="../views/parcelasView.php?explotacion_id=<?php echo $explotacion['id']; ?>">Acceder a <?php echo htmlspecialchars($explotacion['id']); ?></a></td>
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
    </script>

<?php include '../templates/footer.php';?>