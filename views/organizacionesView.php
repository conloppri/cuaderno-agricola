<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include '../templates/cabecera_explotacion_principal.php';
include '../controllers/organizacionesController.php';
?>
    <main>
        <div class="contenido">
            <div>
                <h1>Bienvenido, <?php echo $_SESSION['username']; ?>!</h1>
                <p>Gestiona tus organizaciones de manera eficiente.</p>
            </div>
            <div class="acciones">
                <button type="button" id="btnVolver" class="btn_volver">Volver a explotaciones</button>
                <button type="button" id="btnAddExp" class="btn_agregar_exp">+ Añadir organización</button>
            </div>
        </div>

        <div id="tabla_organizaciones" class="table_exp">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Razón social</th>
                        <th>NIF</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Correo electrónico</th>
                        <th>Código postal</th>
                        <th>Municipio</th>
                        <th>Provincia</th>
                        <th>Comunidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php $organizaciones = obtenerOrganizacionesUsuario($connection, $_SESSION['usuario_id']); ?>
                        <?php foreach ($organizaciones as $organizacion): ?>
                        <td><?php echo htmlspecialchars($organizacion['nombre_organizacion']); ?></td>
                        <td><?php echo htmlspecialchars($organizacion['nombre_razon_social']); ?></td>
                        <td><?php echo htmlspecialchars($organizacion['nif']); ?></td>
                        <td><?php echo htmlspecialchars($organizacion['tlf_fijo']); ?> </br> <?php echo htmlspecialchars($organizacion['tlf_movil']); ?></td>
                        <td><?php echo htmlspecialchars($organizacion['direccion']); ?></td>
                        <td><?php echo htmlspecialchars($organizacion['email']); ?></td>
                        <td><?php echo htmlspecialchars($organizacion['cod_postal']); ?></td>
                        <td><?php echo htmlspecialchars($organizacion['municipio']); ?></td>
                        <td><?php echo htmlspecialchars($organizacion['provincia']); ?></td>
                        <td><?php echo htmlspecialchars($organizacion['comunidad']); ?></td>
                        <td>
                            <button class="btnModificarOrg" data-id="<?php echo $organizacion['organizacion_id']; ?>">Modificar</button>
                            <button class="btnEliminarOrg" data-id="<?php echo $organizacion['organizacion_id']; ?>">Eliminar</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
    <script>
        // Botón para volver a la vista de explotaciones
        const btnVolver = document.getElementById('btnVolver');
        btnVolver.addEventListener('click', () => {
            window.location.href = '../views/explotacionesView.php';
        });

        // Botón para añadir nueva organización
        const btnAddExp = document.getElementById('btnAddExp');
        btnAddExp.addEventListener('click', () => {
            window.location.href = '../views/nuevaOrganizacion.php';
        });
    </script>

<?php include '../templates/footer.php';?>