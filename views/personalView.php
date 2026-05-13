<?php
include '../templates/cabecera_explotacion.php';
include '../config/db.php';
include '../controllers/personalController.php';

$idExplotacion = $_POST['idExplotacion'] ?? 1; // ID de explotación para pruebas
$infoPersonal = obtenerInfoPersonal($connection, $idExplotacion);
?>

<div class="main-content">
    <h1>Personal</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Correo electrónico</th>
                <th>Dirección</th>
                <th>Provincia</th>
                <th>Municipio</th>
                <th>Nacionalidad</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí se mostrarán los datos del personal -->
                <?php foreach ($infoPersonal as $personal): ?>
                <tr>
                    <td><?php echo htmlspecialchars($personal['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($personal['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($personal['correo_electronico']); ?></td>
                    <td><?php echo htmlspecialchars($personal['direccion']); ?></td>
                    <td><?php echo htmlspecialchars($personal['provincia']); ?></td>
                    <td><?php echo htmlspecialchars($personal['municipio']); ?></td>
                    <td><?php echo htmlspecialchars($personal['nacionalidad']); ?></td>
                    <td><?php echo htmlspecialchars($personal['rol']); ?></td>
                </tr>
                <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include '../templates/footer.php';
?>